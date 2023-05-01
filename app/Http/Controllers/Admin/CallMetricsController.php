<?php

namespace App\Http\Controllers\Admin;

use App\ContactCompany;
use App\DTO\CallMetricReportDTO;
use App\DTO\CallMetricReportOptions;
use App\Http\Controllers\Controller;
use App\Location;
use App\Services\CallMetricApi;
use App\Services\CallMetricReports;
use App\TrackingNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CallMetricsController extends Controller
{
    public function index(Request $request)
    {
        $search_params = ['date-range' => '', 'location_id' => '', 'company_id' => '', 'tracking_number_ids' => [], 'callmetric_account_id'=>null];
        $start = Carbon::now()->subDay(6);
        $end = Carbon::now();

        if ($request->get('date-range')) {
            $date_range_arr = explode(' - ', $request->get('date-range'));
            $start = Carbon::parse($date_range_arr[0]);
            $end = Carbon::parse($date_range_arr[1]);
        }

        if ($start && $end) {
            $search_params['date-range'] = date('m/d/Y', strtotime($start)).' - '.date('m/d/Y', strtotime($end));
        }

        $company_id = $request->get('company_id');
        $location_id = $request->get('location_id');
        $callmetric_account_id = $request->get('callmetric_account_id');
        $companies = ContactCompany::select('name', 'id')->get();
        $selectedCompany = null;
        $locations = new Collection();
        if ($company_id) {
            $selectedCompany = $companies->where('id', $company_id)->first();
            $locations = Location::byTrackingNumberCompany($company_id)
                ->select('id', 'nickname')
                ->get();
        }

        $callMetricApiClient = new CallMetricApi();
        $callMetricAccounts = $callMetricApiClient->getAllAccounts();
        $tracking_numbers = new Collection();
        $trackingQuery = TrackingNumber::query();
        if (!empty($location_id)) {
            $trackingQuery = $trackingQuery->where('location_id', $location_id);
            $search_params['location_id'] = $location_id;
        }
        if (!empty($callmetric_account_id)) {
            $search_params['callmetric_account_id'] = $callmetric_account_id;
        }
        if ($selectedCompany) {
            $trackingQuery = $trackingQuery->where('company_id', $selectedCompany->id);
            $search_params['company_id'] = $selectedCompany->id;
            $tracking_numbers = $trackingQuery->get();
        }
        if (!empty($request->get('tracking_number_ids'))) {
            $search_params['tracking_number_ids'] = $request->get('tracking_number_ids');
        }
        if (count($search_params['tracking_number_ids']) === 0 && count($tracking_numbers) > 0) {
            $search_params['tracking_number_ids'] = $tracking_numbers->pluck('id')->toArray();
        }

        $filterable_tracking_numbers = $tracking_numbers->filter(function ($tracking_number) use ($search_params) {
            return in_array($tracking_number->id, $search_params['tracking_number_ids']);
        });

        $reportDto = null;
        if (!empty($search_params['tracking_number_ids'])) {
            if ($request->ajax()) {
                $reportDto = new CallMetricReportDTO();
                $callMetricOptions = new CallMetricReportOptions($callmetric_account_id);
                $callMetricOptions->start_date = $start;
                $callMetricOptions->end_date = $end;
                if (!empty($request->get('dimension'))) {
                    $callMetricOptions->dimension = $request->get('dimension');
                }
                $order = $request->get('order');
                $callMetricOptions->sort = 'total';

                $i = 0;
                foreach ($reportDto->metricMapping as $key => $value) {
                    if ($i == $order[0]['column']) {
                        $callMetricOptions->sort = $key;
                        break;
                    }
                    $i++;
                }
                $callMetricOptions->sortDir = $order[0]['dir'];
                if ($request->get('start')) {
                    $callMetricOptions->page = ceil(($request->get('start') + 1) / 10);
                }

                $reportDto = (new CallMetricReports())->getReport($callMetricOptions, $filterable_tracking_numbers);

                return response()->json($this->toDataTable($request, $reportDto));
            } else {
                $reportDto = new CallMetricReportDTO();
            }
        }

        return view('admin.call_metrics.index', compact('locations', 'callMetricAccounts', 'companies', 'tracking_numbers', 'search_params', 'reportDto'));
    }

    protected function toDataTable(Request $request, CallMetricReportDTO $dto)
    {
        if (count($dto->groups) > 0) {
            $datableResponse = [
                'draw'            => $request->get('draw'),
                'recordsTotal'    => $dto->groups->total(),
                'recordsFiltered' => $dto->groups->total(),
                'data'            => [],
                'series'          => $dto->series,
            ];

            $aggregation = ['first' => 'Total'];
            foreach ($dto->aggregation as $metricName => $metric) {
                $aggregation[$metricName] = $dto->getDisplayableValue($metricName, $metric);
            }

            $datableResponse['data'] = $dto->groups->map(function ($group) use ($dto) {
                $rowData = [
                    'first' => '<div>'.$group->name->name.'</div><div>'.(property_exists($group->name, 'desc') ? $group->name->desc : '').'</div>',
                ];

                foreach ($group->metrics as $metricName => $metric) {
                    $rowData[$metricName] = $dto->getDisplayableValue($metricName, $metric);
                }

                return $rowData;
            })->all();
            array_unshift($datableResponse['data'], $aggregation);

            return $datableResponse;
        } else {
            return [
                'draw'            => $request->get('draw'),
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ];
        }
    }
}

<?php

namespace App\Services;

use App\DTO\CallMetricReportDTO;
use App\DTO\CallMetricReportOptions;
use App\TrackingNumber;
use function GuzzleHttp\Promise\unwrap;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CallMetricReports
{
    /**
     * Undocumented variable.
     *
     * @var CallMetricApi
     */
    protected $service;

    public function __construct()
    {
        $this->service = new CallMetricApi();
    }

    protected function getTrackingNumberFilters(Collection $trackingNumbers, $accountId)
    {
        $numbers = $trackingNumbers->filter(function (TrackingNumber $tracking_number) {
            return true; //empty($tracking_number->callmetric_filter_id);
        });

        $promises = [];
        foreach ($numbers as $tracking_number) {
            /**
             * @var TrackingNumber
             */
            $promise = $this->service->getNumbersForAccountAsync($accountId, 1, trim($tracking_number->number));
            $promises[] = $promise;
            $promise->then(function (LengthAwarePaginator $result) use ($tracking_number) {
                foreach ($result as $callMetricTrackingNumber) {
                    $tracking_number->callmetric_filter_id = $callMetricTrackingNumber->filter_id;
                    $tracking_number->save();
                    break;
                }
            });

            if (count($promises) == 8) {
                unwrap($promises);
                $promises = [];
            }
        }

        if (count($promises) > 0) {
            unwrap($promises);
        }
        $filterIds = $trackingNumbers->filter(function (TrackingNumber $tracking_number) {
            return !empty($tracking_number->callmetric_filter_id);
        })->map(function (TrackingNumber $tracking_number) {
            return $tracking_number->callmetric_filter_id;
        })->toArray();

        return $filterIds;
    }

    /**
     * @return null|CallMetricReportDTO
     */
    public function getReport(CallMetricReportOptions $options, Collection $tracking_numbers)
    {
        $dto = null;
        $options->tracking_numbers_filter_ids = $this->getTrackingNumberFilters($tracking_numbers, $options->account_id);
        $dto = new CallMetricReportDTO();
        $groups = [];
        $accountId = $options->account_id;
        if (count($options->tracking_numbers_filter_ids) > 0) {
            $resp = $this->service->getReportSeries($accountId, $options);
            if ($resp !== null) {
                $dto->metrics = $resp->metrics;
                $dto->aggregation = $resp->aggregations;
                $dto->series = $resp->series;
                $dto->groups = new LengthAwarePaginator($resp->groups->items, $resp->groups->total_entries, $resp->groups->per_page, $resp->groups->page);
                $last_page = $resp->groups->total_pages;
            }
        }

        return $dto;
    }
}

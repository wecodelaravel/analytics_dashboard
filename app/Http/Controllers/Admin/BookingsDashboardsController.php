<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\DataTables;

class BookingsDashboardsController extends Controller
{
    protected $bookings;

    public function __construct(Booking $bookings)
    {
        $this->booking = $bookings;
    }

    /**
     * Display a listing of Booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clinics = \App\Clinic::orderBy('nickname', 'asc')->pluck('nickname', 'id');

        $locations = [];
        if (Input::get('clinic')) {
            $locations = \App\Location::where('clinic_id', Input::get('clinic'))->orderBy('nickname', 'asc')->pluck('nickname', 'id');
        }

        $start = Carbon::now()->subDay(6);
        $end = Carbon::now();

        $yesterday = Carbon::yesterday();
        $one_week_ago = Carbon::now()->subWeeks(1);
        $today = Carbon::now();

        if (Input::get('date-range')) {
            $date_range_arr = explode(' - ', Input::get('date-range'));
            $start = Carbon::parse($date_range_arr[0]);
            $end = Carbon::parse($date_range_arr[1]);
        }

        $search_params = [];
        if ($start && $end) {
            $search_params['date-range'] = date('m/d/Y', strtotime($start)).' - '.date('m/d/Y', strtotime($end));
        }

        $clinic_id = 0;
        if (Input::get('clinic')) {
            $search_params['clinic'] = Input::get('clinic');
            $clinic_id = Input::get('clinic');
        }

        $location_id = 0;
        if (Input::get('location_id')) {
            $search_params['location_id'] = Input::get('location_id');
            $location_id = Input::get('location_id');
        }

        if ($clinic_id > 0) {
            $total_bookings = DB::table('bookings')
                        ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                        ->where('locations.clinic_id', $clinic_id);
            if ($location_id > 0) {
                $total_bookings = $total_bookings->where('locations.id', $location_id);
            }

            $total_bookings = $total_bookings->count();

            $todays_bookings = DB::table('bookings')
                        ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                        ->where('locations.clinic_id', $clinic_id)
                        // ->whereDate('bookings.submitted','>=',$end)
                        ->whereDate('bookings.submitted', $end);

            if ($location_id > 0) {
                $todays_bookings = $todays_bookings->where('locations.id', $location_id);
            }

            $todays_bookings = $todays_bookings->count();

            $todays_appointments = DB::table('bookings')
                            ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                            ->where('locations.clinic_id', $clinic_id)
                            // ->whereDate('bookings.submitted','>=',$end)
                            ->whereDate('bookings.submitted', $end);

            if ($location_id > 0) {
                $todays_appointments = $todays_appointments->where('locations.id', $location_id);
            }

            $todays_appointments = $todays_appointments->count();

            $this_weeks_bookings = DB::table('bookings')
                ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                ->where('locations.clinic_id', $clinic_id)
                ->whereDate('bookings.submitted', '>=', $one_week_ago)
                ->whereDate('bookings.submitted', '<=', $yesterday);

            if ($location_id > 0) {
                $this_weeks_bookings = $this_weeks_bookings->where('locations.id', $location_id);
            }

            $this_weeks_bookings = $this_weeks_bookings->count();

            $this_weeks_appointments = DB::table('bookings')
                    ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                    ->where('locations.clinic_id', $clinic_id)
                    ->whereDate('bookings.requested_date', '>=', $one_week_ago)
                    ->whereDate('bookings.requested_date', '<=', $yesterday);

            if ($location_id > 0) {
                $this_weeks_appointments = $this_weeks_appointments->where('locations.id', $location_id);
            }

            $this_weeks_appointments = $this_weeks_appointments->count();

            $firstDayofMonth = Carbon::now()->startOfMonth()->toDateString();

            $this_months_bookings = DB::table('bookings')
                ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                ->where('locations.clinic_id', $clinic_id)
                ->whereDate('bookings.submitted', '>=', $firstDayofMonth)
                ->whereDate('bookings.submitted', '<=', $today);

            if ($location_id > 0) {
                $this_months_bookings = $this_months_bookings->where('locations.id', $location_id);
            }

            $this_months_bookings = $this_months_bookings->count();

            $this_months_appointments = DB::table('bookings')
                    ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                    ->where('locations.clinic_id', $clinic_id)
                    ->whereDate('bookings.requested_date', '>=', $firstDayofMonth)
                    ->whereDate('bookings.requested_date', '<=', $today);

            if ($location_id > 0) {
                $this_months_appointments = $this_months_appointments->where('locations.id', $location_id);
            }

            $this_months_appointments = $this_months_appointments->count();

            $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $lastDayofPreviousMonth = Carbon::now()->endOfMonth()->subMonth()->toDateString();

            $last_months_bookings = DB::table('bookings')
                ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                ->where('locations.clinic_id', $clinic_id)
                ->whereDate('bookings.submitted', '>=', $firstDayofPreviousMonth)
                ->whereDate('bookings.submitted', '<=', $lastDayofPreviousMonth);

            if ($location_id > 0) {
                $last_months_bookings = $last_months_bookings->where('locations.id', $location_id);
            }

            $last_months_bookings = $last_months_bookings->count();

            $last_months_appointments = DB::table('bookings')
                    ->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id')
                    ->where('locations.clinic_id', $clinic_id)
                    ->whereDate('bookings.requested_date', '>=', $firstDayofPreviousMonth)
                    ->whereDate('bookings.requested_date', '<=', $lastDayofPreviousMonth);

            if ($location_id > 0) {
                $last_months_appointments = $last_months_appointments->where('locations.id', $location_id);
            }

            $last_months_appointments = $last_months_appointments->count();
        }

        if (!Gate::allows('booking_access')) {
            return abort(401);
        }

        if ($clinic_id > 0 && request()->ajax()) {
            $query = Booking::query();
            $query->join('locations', 'bookings.clinic_id', '=', 'locations.clinic_location_id');
            $query->where('locations.clinic_id', $clinic_id);
            $query->whereDate('bookings.submitted', '>=', $start);
            $query->whereDate('bookings.submitted', '<=', $end);

            if ($location_id > 0) {
                $query = $query->where('locations.id', $location_id);
            }

            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('booking_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'bookings.id',
                'bookings.submitted',
                'bookings.customername',
                'bookings.email',
                'bookings.phone',
                'bookings.family_number',
                'bookings.how_long',
                'bookings.requested_date',
                'bookings.requested_time',
                'bookings.requested_clinic',
                'bookings.clinic_id',
                'bookings.clinic_email',
                'bookings.clinic_address',
                'bookings.clinic_phone',
                'bookings.clinic_text_numbers',
                'bookings.client_firstname',
                'bookings.submitted_user_city',
                'bookings.submitted_user_state',
                'bookings.searched_for',
                'bookings.latitude',
                'bookings.longitude',
                'bookings.country',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'booking_';
                $routeKey = 'admin.bookings';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('submitted', function ($row) {
                return $row->submitted ? $row->submitted : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('family_number', function ($row) {
                return $row->family_number ? $row->family_number : '';
            });
            $table->editColumn('how_long', function ($row) {
                return $row->how_long ? $row->how_long : '';
            });
            $table->editColumn('requested_date', function ($row) {
                return $row->requested_date ? $row->requested_date : '';
            });
            $table->editColumn('requested_time', function ($row) {
                return $row->requested_time ? $row->requested_time : '';
            });
            $table->editColumn('requested_clinic', function ($row) {
                return $row->requested_clinic ? $row->requested_clinic : '';
            });
            $table->editColumn('clinic_id', function ($row) {
                return $row->clinic_id ? $row->clinic_id : '';
            });
            $table->editColumn('clinic_email', function ($row) {
                return $row->clinic_email ? $row->clinic_email : '';
            });
            $table->editColumn('clinic_address', function ($row) {
                return $row->clinic_address ? $row->clinic_address : '';
            });
            $table->editColumn('clinic_phone', function ($row) {
                return $row->clinic_phone ? $row->clinic_phone : '';
            });
            $table->editColumn('clinic_text_numbers', function ($row) {
                return $row->clinic_text_numbers ? $row->clinic_text_numbers : '';
            });
            $table->editColumn('client_firstname', function ($row) {
                return $row->client_firstname ? $row->client_firstname : '';
            });
            $table->editColumn('submitted_user_city', function ($row) {
                return $row->submitted_user_city ? $row->submitted_user_city : '';
            });
            $table->editColumn('submitted_user_state', function ($row) {
                return $row->submitted_user_state ? $row->submitted_user_state : '';
            });
            $table->editColumn('searched_for', function ($row) {
                return $row->searched_for ? $row->searched_for : '';
            });
            $table->editColumn('latitude', function ($row) {
                return $row->latitude ? $row->latitude : '';
            });
            $table->editColumn('longitude', function ($row) {
                return $row->longitude ? $row->longitude : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : '';
            });

            $table->rawColumns(['actions', 'massDelete']);

            return $table->make(true);
        }

        return view('admin.bookings_dashboards.index', compact('todays_bookings', 'total_bookings', 'search_params', 'clinics', 'clinic_id', 'locations', 'location_id', 'this_weeks_bookings', 'this_months_bookings', 'last_months_bookings', 'this_months_appointments', 'last_months_appointments', 'this_weeks_appointments', 'todays_appointments'));
    }
}

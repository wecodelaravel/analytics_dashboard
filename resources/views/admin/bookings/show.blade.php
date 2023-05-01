@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.bookings.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.bookings.fields.customername')</th>
                            <td field-key='customername'>{{ $booking->customername }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.phone')</th>
                            <td field-key='phone'>{{ $booking->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.family-number')</th>
                            <td field-key='family_number'>{{ $booking->family_number }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.email')</th>
                            <td field-key='email'>{{ $booking->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.how-long')</th>
                            <td field-key='how_long'>{{ $booking->how_long }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.requested-date')</th>
                            <td field-key='requested_date'>{{ $booking->requested_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.requested-time')</th>
                            <td field-key='requested_time'>{{ $booking->requested_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.requested-clinic')</th>
                            <td field-key='requested_clinic'>{{ $booking->requested_clinic }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.clinic-id')</th>
                            <td field-key='clinic_id'>{{ $booking->clinic_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.clinic-email')</th>
                            <td field-key='clinic_email'>{{ $booking->clinic_email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.clinic-address')</th>
                            <td field-key='clinic_address'>{{ $booking->clinic_address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.clinic-phone')</th>
                            <td field-key='clinic_phone'>{{ $booking->clinic_phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.clinic-text-numbers')</th>
                            <td field-key='clinic_text_numbers'>{{ $booking->clinic_text_numbers }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.client-firstname')</th>
                            <td field-key='client_firstname'>{{ $booking->client_firstname }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.submitted-user-city')</th>
                            <td field-key='submitted_user_city'>{{ $booking->submitted_user_city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.submitted-user-state')</th>
                            <td field-key='submitted_user_state'>{{ $booking->submitted_user_state }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.searched-for')</th>
                            <td field-key='searched_for'>{{ $booking->searched_for }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.latitude')</th>
                            <td field-key='latitude'>{{ $booking->latitude }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.longitude')</th>
                            <td field-key='longitude'>{{ $booking->longitude }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.country')</th>
                            <td field-key='country'>{{ $booking->country }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.bookings.fields.submitted')</th>
                            <td field-key='submitted'>{{ $booking->submitted }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.bookings.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

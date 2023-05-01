@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.locations.title')</h3>
    
    {!! Form::model($location, ['method' => 'PUT', 'route' => ['admin.locations.update', $location->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('parent_website_id', trans('global.locations.fields.parent-website').'', ['class' => 'control-label']) !!}
                    {!! Form::select('parent_website_id', $parent_websites, old('parent_website_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('parent_website_id'))
                        <p class="help-block">
                            {{ $errors->first('parent_website_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('clinic_website_link', trans('global.locations.fields.clinic-website-link').'', ['class' => 'control-label']) !!}
                    {!! Form::text('clinic_website_link', old('clinic_website_link'), ['class' => 'form-control', 'placeholder' => 'This is the link to the clinic info page. Used if multiple locations on one site.']) !!}
                    <p class="help-block">This is the link to the clinic info page. Used if multiple locations on one site.</p>
                    @if($errors->has('clinic_website_link'))
                        <p class="help-block">
                            {{ $errors->first('clinic_website_link') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('clinic_id', trans('global.locations.fields.clinic').'', ['class' => 'control-label']) !!}
                    {!! Form::select('clinic_id', $clinics, old('clinic_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('clinic_id'))
                        <p class="help-block">
                            {{ $errors->first('clinic_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('clinic_location_id', trans('global.locations.fields.clinic-location-id').'', ['class' => 'control-label']) !!}
                    {!! Form::number('clinic_location_id', old('clinic_location_id'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('clinic_location_id'))
                        <p class="help-block">
                            {{ $errors->first('clinic_location_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('nickname', trans('global.locations.fields.nickname').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('nickname', old('nickname'), ['class' => 'form-control', 'placeholder' => 'Title or Name of location', 'required' => '']) !!}
                    <p class="help-block">Title or Name of location</p>
                    @if($errors->has('nickname'))
                        <p class="help-block">
                            {{ $errors->first('nickname') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('contact_person_id', trans('global.locations.fields.contact-person').'', ['class' => 'control-label']) !!}
                    {!! Form::select('contact_person_id', $contact_people, old('contact_person_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contact_person_id'))
                        <p class="help-block">
                            {{ $errors->first('contact_person_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address', trans('global.locations.fields.address').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('address_2', trans('global.locations.fields.address-2').'', ['class' => 'control-label']) !!}
                    {!! Form::text('address_2', old('address_2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address_2'))
                        <p class="help-block">
                            {{ $errors->first('address_2') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('city', trans('global.locations.fields.city').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('city', old('city'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('city'))
                        <p class="help-block">
                            {{ $errors->first('city') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('state', trans('global.locations.fields.state').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('state', old('state'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('state'))
                        <p class="help-block">
                            {{ $errors->first('state') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('location_email', trans('global.locations.fields.location-email').'', ['class' => 'control-label']) !!}
                    {!! Form::email('location_email', old('location_email'), ['class' => 'form-control', 'placeholder' => 'Add the email even if used by multiple clinics']) !!}
                    <p class="help-block">Add the email even if used by multiple clinics</p>
                    @if($errors->has('location_email'))
                        <p class="help-block">
                            {{ $errors->first('location_email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('phone', trans('global.locations.fields.phone').'', ['class' => 'control-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone'))
                        <p class="help-block">
                            {{ $errors->first('phone') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('phone2', trans('global.locations.fields.phone2').'', ['class' => 'control-label']) !!}
                    {!! Form::text('phone2', old('phone2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone2'))
                        <p class="help-block">
                            {{ $errors->first('phone2') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if ($location->storefront)
                        <a href="{{ asset(env('UPLOAD_PATH').'/'.$location->storefront) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/'.$location->storefront) }}"></a>
                    @endif
                    {!! Form::label('storefront', trans('global.locations.fields.storefront').'', ['class' => 'control-label']) !!}
                    {!! Form::file('storefront', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('storefront_max_size', 4) !!}
                    {!! Form::hidden('storefront_max_width', 1800) !!}
                    {!! Form::hidden('storefront_max_height', 1800) !!}
                    <p class="help-block"></p>
                    @if($errors->has('storefront'))
                        <p class="help-block">
                            {{ $errors->first('storefront') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('google_map_link', trans('global.locations.fields.google-map-link').'', ['class' => 'control-label']) !!}
                    {!! Form::text('google_map_link', old('google_map_link'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('google_map_link'))
                        <p class="help-block">
                            {{ $errors->first('google_map_link') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Zipcodes
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('global.zipcodes.fields.zipcode')</th>
                        
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="zipcodes">
                    @forelse(old('zipcodes', []) as $index => $data)
                        @include('admin.locations.zipcodes_row', [
                            'index' => $index
                        ])
                    @empty
                        @foreach($location->zipcodes as $item)
                            @include('admin.locations.zipcodes_row', [
                                'index' => 'id-' . $item->id,
                                'field' => $item
                            ])
                        @endforeach
                    @endforelse
                </tbody>
            </table>
            <a href="#" class="btn btn-success pull-right add-new">@lang('global.app_add_new')</a>
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent

    <script type="text/html" id="zipcodes-template">
        @include('admin.locations.zipcodes_row',
                [
                    'index' => '_INDEX_',
                ])
               </script > 

            <script>
        $('.add-new').click(function () {
            var tableBody = $(this).parent().find('tbody');
            var template = $('#' + tableBody.attr('id') + '-template').html();
            var lastIndex = parseInt(tableBody.find('tr').last().data('index'));
            if (isNaN(lastIndex)) {
                lastIndex = 0;
            }
            tableBody.append(template.replace(/_INDEX_/g, lastIndex + 1));
            return false;
        });
        $(document).on('click', '.remove', function () {
            var row = $(this).parentsUntil('tr').parent();
            row.remove();
            return false;
        });
        </script>
@stop
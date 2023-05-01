@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.website.title')</h3>
    
    {!! Form::model($website, ['method' => 'PUT', 'route' => ['admin.websites.update', $website->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('global.website.fields.company').'', ['class' => 'control-label']) !!}
                    {!! Form::select('company_id', $companies, old('company_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('company_id'))
                        <p class="help-block">
                            {{ $errors->first('company_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('clinic_id', trans('global.website.fields.clinic').'', ['class' => 'control-label']) !!}
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
                    {!! Form::label('website', trans('global.website.fields.website').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('website', old('website'), ['class' => 'form-control', 'placeholder' => 'Do not use http only user root domain', 'required' => '']) !!}
                    <p class="help-block">Do not use http only user root domain</p>
                    @if($errors->has('website'))
                        <p class="help-block">
                            {{ $errors->first('website') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Locations
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('global.locations.fields.clinic-website-link')</th>
                        <th>@lang('global.locations.fields.clinic-location-id')</th>
                        <th>@lang('global.locations.fields.nickname')</th>
                        <th>@lang('global.locations.fields.address')</th>
                        <th>@lang('global.locations.fields.address-2')</th>
                        <th>@lang('global.locations.fields.city')</th>
                        <th>@lang('global.locations.fields.state')</th>
                        <th>@lang('global.locations.fields.location-email')</th>
                        <th>@lang('global.locations.fields.phone')</th>
                        <th>@lang('global.locations.fields.phone2')</th>
                        <th>@lang('global.locations.fields.google-map-link')</th>
                        
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="locations">
                    @forelse(old('locations', []) as $index => $data)
                        @include('admin.websites.locations_row', [
                            'index' => $index
                        ])
                    @empty
                        @foreach($website->locations as $item)
                            @include('admin.websites.locations_row', [
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
    <div class="panel panel-default">
        <div class="panel-heading">
            Adwords
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('global.adwords.fields.client-customer-id')</th>
                        <th>@lang('global.adwords.fields.user-agent')</th>
                        <th>@lang('global.adwords.fields.client-id')</th>
                        <th>@lang('global.adwords.fields.client-secret')</th>
                        <th>@lang('global.adwords.fields.refresh-token')</th>
                        <th>@lang('global.adwords.fields.authorization-uri')</th>
                        <th>@lang('global.adwords.fields.redirect-uri')</th>
                        <th>@lang('global.adwords.fields.token-credential-uri')</th>
                        <th>@lang('global.adwords.fields.scope')</th>
                        
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="adwords">
                    @forelse(old('adwords', []) as $index => $data)
                        @include('admin.websites.adwords_row', [
                            'index' => $index
                        ])
                    @empty
                        @foreach($website->adwords as $item)
                            @include('admin.websites.adwords_row', [
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
    <div class="panel panel-default">
        <div class="panel-heading">
            Analytics
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>@lang('global.analytics.fields.view-name')</th>
                        <th>@lang('global.analytics.fields.view-id')</th>
                        
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="analytics">
                    @forelse(old('analytics', []) as $index => $data)
                        @include('admin.websites.analytics_row', [
                            'index' => $index
                        ])
                    @empty
                        @foreach($website->analytics as $item)
                            @include('admin.websites.analytics_row', [
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

    <script type="text/html" id="locations-template">
        @include('admin.websites.locations_row',
                [
                    'index' => '_INDEX_',
                ])
               </script > 

    <script type="text/html" id="adwords-template">
        @include('admin.websites.adwords_row',
                [
                    'index' => '_INDEX_',
                ])
               </script > 

    <script type="text/html" id="analytics-template">
        @include('admin.websites.analytics_row',
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
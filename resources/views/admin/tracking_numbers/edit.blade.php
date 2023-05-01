@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.tracking-numbers.title')</h3>
    
    {!! Form::model($tracking_number, ['method' => 'PUT', 'route' => ['admin.tracking_numbers.update', $tracking_number->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('metrics_id', trans('global.tracking-numbers.fields.metrics-id').'', ['class' => 'control-label']) !!}
                    {!! Form::text('metrics_id', old('metrics_id'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('metrics_id'))
                        <p class="help-block">
                            {{ $errors->first('metrics_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('number', trans('global.tracking-numbers.fields.number').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('number', old('number'), ['class' => 'form-control', 'placeholder' => 'tracking number assigned by call tracking metrics', 'required' => '']) !!}
                    <p class="help-block">tracking number assigned by call tracking metrics</p>
                    @if($errors->has('number'))
                        <p class="help-block">
                            {{ $errors->first('number') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('location_id', trans('global.tracking-numbers.fields.location').'', ['class' => 'control-label']) !!}
                    {!! Form::select('location_id', $locations, old('location_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('location_id'))
                        <p class="help-block">
                            {{ $errors->first('location_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('global.tracking-numbers.fields.company').'', ['class' => 'control-label']) !!}
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
                    {!! Form::label('callmetric_filter_id', trans('global.tracking-numbers.fields.callmetric-filter-id').'', ['class' => 'control-label']) !!}
                    {!! Form::text('callmetric_filter_id', old('callmetric_filter_id'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('callmetric_filter_id'))
                        <p class="help-block">
                            {{ $errors->first('callmetric_filter_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop


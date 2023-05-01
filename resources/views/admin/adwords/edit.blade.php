@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.adwords.title')</h3>
    
    {!! Form::model($adword, ['method' => 'PUT', 'route' => ['admin.adwords.update', $adword->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('company_id', trans('global.adwords.fields.company').'', ['class' => 'control-label']) !!}
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
                    {!! Form::label('website_id', trans('global.adwords.fields.website').'', ['class' => 'control-label']) !!}
                    {!! Form::select('website_id', $websites, old('website_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('website_id'))
                        <p class="help-block">
                            {{ $errors->first('website_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('client_customer_id', trans('global.adwords.fields.client-customer-id').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_customer_id', old('client_customer_id'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_customer_id'))
                        <p class="help-block">
                            {{ $errors->first('client_customer_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_agent', trans('global.adwords.fields.user-agent').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('user_agent', old('user_agent'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_agent'))
                        <p class="help-block">
                            {{ $errors->first('user_agent') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('client_id', trans('global.adwords.fields.client-id').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_id', old('client_id'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_id'))
                        <p class="help-block">
                            {{ $errors->first('client_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('client_secret', trans('global.adwords.fields.client-secret').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('client_secret', old('client_secret'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('client_secret'))
                        <p class="help-block">
                            {{ $errors->first('client_secret') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('refresh_token', trans('global.adwords.fields.refresh-token').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('refresh_token', old('refresh_token'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('refresh_token'))
                        <p class="help-block">
                            {{ $errors->first('refresh_token') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('authorization_uri', trans('global.adwords.fields.authorization-uri').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('authorization_uri', old('authorization_uri'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('authorization_uri'))
                        <p class="help-block">
                            {{ $errors->first('authorization_uri') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('redirect_uri', trans('global.adwords.fields.redirect-uri').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('redirect_uri', old('redirect_uri'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('redirect_uri'))
                        <p class="help-block">
                            {{ $errors->first('redirect_uri') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('token_credential_uri', trans('global.adwords.fields.token-credential-uri').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('token_credential_uri', old('token_credential_uri'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('token_credential_uri'))
                        <p class="help-block">
                            {{ $errors->first('token_credential_uri') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('scope', trans('global.adwords.fields.scope').'*', ['class' => 'control-label']) !!}
                    {!! Form::text('scope', old('scope'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('scope'))
                        <p class="help-block">
                            {{ $errors->first('scope') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('clinic_id', trans('global.adwords.fields.clinic').'', ['class' => 'control-label']) !!}
                    {!! Form::select('clinic_id', $clinics, old('clinic_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('clinic_id'))
                        <p class="help-block">
                            {{ $errors->first('clinic_id') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop


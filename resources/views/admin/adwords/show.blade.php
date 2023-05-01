@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.adwords.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.adwords.fields.company')</th>
                            <td field-key='company'>{{ $adword->company->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.client-customer-id')</th>
                            <td field-key='client_customer_id'>{{ $adword->client_customer_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.user-agent')</th>
                            <td field-key='user_agent'>{{ $adword->user_agent }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.client-id')</th>
                            <td field-key='client_id'>{{ $adword->client_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.client-secret')</th>
                            <td field-key='client_secret'>{{ $adword->client_secret }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.refresh-token')</th>
                            <td field-key='refresh_token'>{{ $adword->refresh_token }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.authorization-uri')</th>
                            <td field-key='authorization_uri'>{{ $adword->authorization_uri }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.redirect-uri')</th>
                            <td field-key='redirect_uri'>{{ $adword->redirect_uri }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.token-credential-uri')</th>
                            <td field-key='token_credential_uri'>{{ $adword->token_credential_uri }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.scope')</th>
                            <td field-key='scope'>{{ $adword->scope }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.adwords.fields.clinic')</th>
                            <td field-key='clinic'>{{ $adword->clinic->nickname or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.adwords.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

<tr data-index="{{ $index }}">
    <td>{!! Form::text('locations['.$index.'][clinic_website_link]', old('locations['.$index.'][clinic_website_link]', isset($field) ? $field->clinic_website_link: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::number('locations['.$index.'][clinic_location_id]', old('locations['.$index.'][clinic_location_id]', isset($field) ? $field->clinic_location_id: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][nickname]', old('locations['.$index.'][nickname]', isset($field) ? $field->nickname: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][address]', old('locations['.$index.'][address]', isset($field) ? $field->address: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][address_2]', old('locations['.$index.'][address_2]', isset($field) ? $field->address_2: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][city]', old('locations['.$index.'][city]', isset($field) ? $field->city: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][state]', old('locations['.$index.'][state]', isset($field) ? $field->state: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::email('locations['.$index.'][location_email]', old('locations['.$index.'][location_email]', isset($field) ? $field->location_email: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][phone]', old('locations['.$index.'][phone]', isset($field) ? $field->phone: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][phone2]', old('locations['.$index.'][phone2]', isset($field) ? $field->phone2: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('locations['.$index.'][google_map_link]', old('locations['.$index.'][google_map_link]', isset($field) ? $field->google_map_link: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('global.app_delete')</a>
    </td>
</tr>
<tr data-index="{{ $index }}">
    <td>{!! Form::text('contacts['.$index.'][first_name]', old('contacts['.$index.'][first_name]', isset($field) ? $field->first_name: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('contacts['.$index.'][last_name]', old('contacts['.$index.'][last_name]', isset($field) ? $field->last_name: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('contacts['.$index.'][phone1]', old('contacts['.$index.'][phone1]', isset($field) ? $field->phone1: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('contacts['.$index.'][phone2]', old('contacts['.$index.'][phone2]', isset($field) ? $field->phone2: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('contacts['.$index.'][email]', old('contacts['.$index.'][email]', isset($field) ? $field->email: ''), ['class' => 'form-control']) !!}</td>
<td>{!! Form::text('contacts['.$index.'][skype]', old('contacts['.$index.'][skype]', isset($field) ? $field->skype: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('global.app_delete')</a>
    </td>
</tr>
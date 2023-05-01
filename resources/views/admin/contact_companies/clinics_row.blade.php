<tr data-index="{{ $index }}">
    <td>{!! Form::text('clinics['.$index.'][nickname]', old('clinics['.$index.'][nickname]', isset($field) ? $field->nickname: ''), ['class' => 'form-control']) !!}</td>

    <td>
        <a href="#" class="remove btn btn-xs btn-danger">@lang('quickadmin.qa_delete')</a>
    </td>
</tr>
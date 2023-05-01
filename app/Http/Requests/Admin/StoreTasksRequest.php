<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTasksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required',
            'status_id' => 'required',
            'tag.*'     => 'exists:task_tags,id',
            'due_date'  => 'nullable|date_format:'.config('app.date_format'),
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationsRequest extends FormRequest
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
            'clinic_location_id' => 'max:2147483647|nullable|numeric',
            'nickname'           => 'required',
            'address'            => 'required',
            'city'               => 'required',
            'state'              => 'required',
            'location_email'     => 'email',
            'storefront'         => 'nullable|mimes:png,jpg,jpeg,gif',
        ];
    }
}

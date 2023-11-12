<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'insurance_company' => 'required',
            'date_of_insurance' => 'required|date',
            'insurance_amount' => 'required',
            'date_of_expiry_of_insurance' => 'required|date',
        ];
    }
}

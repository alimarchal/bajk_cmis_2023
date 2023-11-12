<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'branch_id' => 'required',
            'name' => 'required|string',
            'son_daughter_wife' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'business_department_profession' => 'required|string',
            'designation' => 'required|string',
            'pp_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'office_business_address' => 'required|string',
            'present_address' => 'required|string',
            'permanent_address' => 'required|string',
            'customer_cnic' => 'required|string',
            'customer_contact_number' => 'required|string',
            'account_cd_saving' => 'required|string',
            'manual_account' => 'nullable|string', // Add validation for manual_account if needed
            'product_id' => 'required|integer', // Example rule
            'product_type_id' => 'required|integer',
            'renewal_enhancement_fresh_sanction' => 'required|string|max:255',
            'amount_sanctioned' => 'required|numeric|min:0.01',
//            'amount_enhanced' => 'nullable|numeric|min:0',
            'sanction_date' => 'required|date',
            'tenure_of_loan_in_months' => 'required|integer|min:1|max:60',
            'installment_type' => 'required|in:Monthly,Quarterly,Half Yearly,Lump sump',
            'emi_amount' => 'required|numeric|min:1',
            'dac_issuance_date' => 'required|date',
            'loan_due_date' => 'required|date',
            'disbursement_date' => 'required|date',
            'amount_disbursed' => 'required|numeric|min:0',
            'expiry_date_as_per_dac' => 'required|date',
            'kibor_or_fixed' => 'required|in:1,0',
            'kibor_rate' => 'nullable|numeric|min:0',
            'bank_spread_rate' => 'nullable|numeric|min:0',
            'secure_unsecure_loan' => 'required|in:Secure,Unsecure',
        ];
    }
}

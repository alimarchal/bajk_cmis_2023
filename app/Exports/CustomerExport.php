<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    public function headings(): array
    {
        return [
            'ID',
            'Branch No',
            'Name',
            'Son/Daughter/Wife',
            'Gender',
            'Business/Department/Profession',
            'Designation',
            'PP Number',
            'Date of Birth',
            'Office Business Address',
            'Present Address',
            'Permanent Address',
            'District',
            'Customer CNIC',
            'Customer Contact Number',
            'Account/CD/Saving',
            'Manual Account',
            'Nature of Facility Availed',
            'Type of Facility Approved',
            'Renewal/Enhancement',
            'Amount Sanctioned',
            'Amount Enhanced (If Any)',
            'Sanctioned Date',
            'Tenure of Loan in Months',
            'Installment Type',
            'Installment Amount',
            'No of Installment',
            'DAC Issuance Date',
            'Installment Due Date',
            'DAC Disbursement Date',
            'Amount Disbursed',
            'Expiry Date as per DAC',
            'KIBOR / Fixed',
            'KIBOR Rate',
            'Bank Spread Rate',
            'Total Markup Rate (KIBOR+SPREAD)',
            'Facility',
            'Sanctioning (Branch Manager)',
            'Principal Outstanding',
            'mark_up_receivable',
            'total',
            'last_installment_date',
            'customer_status',
            'status',
        ];
    }


    public function collection()
    {
        ini_set('memory_limit', '512M');
        $customers = null;
        if (Auth::user()->hasRole(['Credit Officer', 'Branch Manager'])) {
            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type', 'guarantee')->where('branch_id', \auth()->user()->branch_id))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->join('products', 'customers.product_id', '=', 'products.id')
                ->join('product_types', 'customers.product_type_id', '=', 'product_types.id')
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('guarantee.cnic'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('product_id'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::scope('customer_status_custom'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),
                ])
                ->select('customers.id', 'branches.name as branch_name',
                    'customers.name',
                    'customers.son_daughter_wife',
                    'customers.gender',
                    'customers.business_department_profession',
                    'customers.designation',
                    'customers.pp_number',
                    'customers.date_of_birth',
                    'customers.office_business_address',
                    'customers.present_address',
                    'customers.permanent_address',
                    'customers.district',
                    'customers.customer_cnic',
                    'customers.customer_contact_number',
                    'customers.account_cd_saving',
                    'customers.manual_account',
                    'products.product_name',
                    'product_types.product_type',
                    'customers.renewal_enhancement_fresh_sanction',
                    'customers.amount_sanctioned',
                    'customers.amount_enhanced',
                    'customers.sanction_date',
                    'customers.tenure_of_loan_in_months',
                    'customers.installment_type',
                    'customers.emi_amount',
                    'customers.no_of_installments',
                    'customers.dac_issuance_date',
                    'customers.disbursement_date',
                    'customers.loan_due_date',
                    'customers.amount_disbursed',
                    'customers.expiry_date_as_per_dac',
                    'customers.kibor_or_fixed',
                    'customers.kibor_rate',
                    'customers.bank_spread_rate',
                    'customers.mark_up_rate',
                    'customers.secure_unsecure_loan',
                    'customers.branch_manager_name_while_sanctioning',
                    'customers.principle_amount',
                    'customers.mark_up_receivable',
                    'customers.total',
                    'customers.last_installment_date',
                    'customers.customer_status',
                    'customers.status'
                )
                ->get();
        } elseif (Auth::user()->hasRole('South Regional MIS Officer')) {
            $south_branches = Branch::where('region', 'South Region')->get('id');
            $branches = [];
            foreach ($south_branches as $item) {
                $branches[] = $item->id;
            }

            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type')->whereIn('branch_id', $branches))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->join('products', 'customers.product_id', '=', 'products.id')
                ->join('product_types', 'customers.product_type_id', '=', 'product_types.id')
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('product_id'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),

                ])
                ->select('customers.id', 'branches.name as branch_name',
                    'customers.name',
                    'customers.son_daughter_wife',
                    'customers.gender',
                    'customers.business_department_profession',
                    'customers.designation',
                    'customers.pp_number',
                    'customers.date_of_birth',
                    'customers.office_business_address',
                    'customers.present_address',
                    'customers.permanent_address',
                    'customers.district',
                    'customers.customer_cnic',
                    'customers.customer_contact_number',
                    'customers.account_cd_saving',
                    'customers.manual_account',
                    'products.product_name',
                    'product_types.product_type',
                    'customers.renewal_enhancement_fresh_sanction',
                    'customers.amount_sanctioned',
                    'customers.amount_enhanced',
                    'customers.sanction_date',
                    'customers.tenure_of_loan_in_months',
                    'customers.installment_type',
                    'customers.emi_amount',
                    'customers.no_of_installments',
                    'customers.dac_issuance_date',
                    'customers.disbursement_date',
                    'customers.loan_due_date',
                    'customers.amount_disbursed',
                    'customers.expiry_date_as_per_dac',
                    'customers.kibor_or_fixed',
                    'customers.kibor_rate',
                    'customers.bank_spread_rate',
                    'customers.mark_up_rate',
                    'customers.secure_unsecure_loan',
                    'customers.branch_manager_name_while_sanctioning',
                    'customers.principle_amount',
                    'customers.mark_up_receivable',
                    'customers.total',
                    'customers.last_installment_date',
                    'customers.customer_status',
                    'customers.status'
                )->get();
        } elseif (Auth::user()->hasRole('North Regional MIS Officer')) {

            $north_branches = Branch::where('region', 'North Region')->get('id');
            $branches = [];
            foreach ($north_branches as $item) {
                $branches[] = $item->id;
            }

            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type')->whereIn('branch_id', $branches))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->join('products', 'customers.product_id', '=', 'products.id')
                ->join('product_types', 'customers.product_type_id', '=', 'product_types.id')
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('product_id'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('status'),

                ])->select('customers.id', 'branches.name as branch_name',
                    'customers.name',
                    'customers.son_daughter_wife',
                    'customers.gender',
                    'customers.business_department_profession',
                    'customers.designation',
                    'customers.pp_number',
                    'customers.date_of_birth',
                    'customers.office_business_address',
                    'customers.present_address',
                    'customers.permanent_address',
                    'customers.district',
                    'customers.customer_cnic',
                    'customers.customer_contact_number',
                    'customers.account_cd_saving',
                    'customers.manual_account',
                    'products.product_name',
                    'product_types.product_type',
                    'customers.renewal_enhancement_fresh_sanction',
                    'customers.amount_sanctioned',
                    'customers.amount_enhanced',
                    'customers.sanction_date',
                    'customers.tenure_of_loan_in_months',
                    'customers.installment_type',
                    'customers.emi_amount',
                    'customers.no_of_installments',
                    'customers.dac_issuance_date',
                    'customers.disbursement_date',
                    'customers.loan_due_date',
                    'customers.amount_disbursed',
                    'customers.expiry_date_as_per_dac',
                    'customers.kibor_or_fixed',
                    'customers.kibor_rate',
                    'customers.bank_spread_rate',
                    'customers.mark_up_rate',
                    'customers.secure_unsecure_loan',
                    'customers.branch_manager_name_while_sanctioning',
                    'customers.principle_amount',
                    'customers.mark_up_receivable',
                    'customers.total',
                    'customers.last_installment_date',
                    'customers.customer_status',
                    'customers.status'
                )->get();
        } elseif (Auth::user()->hasRole(['Head Office', 'Super-Admin'])) {
            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'guarantee', 'product_type'))
                ->join('branches', 'customers.branch_id', '=', 'branches.id')
                ->join('products', 'customers.product_id', '=', 'products.id')
                ->join('product_types', 'customers.product_type_id', '=', 'product_types.id')
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('product_id'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('guarantee.cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),
                ])->select('customers.id', 'branches.name as branch_name',
                    'customers.name',
                    'customers.son_daughter_wife',
                    'customers.gender',
                    'customers.business_department_profession',
                    'customers.designation',
                    'customers.pp_number',
                    'customers.date_of_birth',
                    'customers.office_business_address',
                    'customers.present_address',
                    'customers.permanent_address',
                    'customers.district',
                    'customers.customer_cnic',
                    'customers.customer_contact_number',
                    'customers.account_cd_saving',
                    'customers.manual_account',
                    'products.product_name',
                    'product_types.product_type',
                    'customers.renewal_enhancement_fresh_sanction',
                    'customers.amount_sanctioned',
                    'customers.amount_enhanced',
                    'customers.sanction_date',
                    'customers.tenure_of_loan_in_months',
                    'customers.installment_type',
                    'customers.emi_amount',
                    'customers.no_of_installments',
                    'customers.dac_issuance_date',
                    'customers.disbursement_date',
                    'customers.loan_due_date',
                    'customers.amount_disbursed',
                    'customers.expiry_date_as_per_dac',
                    'customers.kibor_or_fixed',
                    'customers.kibor_rate',
                    'customers.bank_spread_rate',
                    'customers.mark_up_rate',
                    'customers.secure_unsecure_loan',
                    'customers.branch_manager_name_while_sanctioning',
                    'customers.principle_amount',
                    'customers.mark_up_receivable',
                    'customers.total',
                    'customers.last_installment_date',
                    'customers.customer_status',
                    'customers.status'
                )->get();
        }


//        $prisoners = QueryBuilder::for(Customer::class)
//            ->where('product_id', 3)
//            ->get(['branch_id', 'name']);

        return $customers;

//    /**
//    * @return \Illuminate\Support\Collection
//    */
//    public function collection()
//    {
//        return Customer::all();
//    }

    }
}

<?php

namespace App\Models;

use App\Http\Controllers\ValuationController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    /*
        1 => Regular
        2 => Irregular
        3 => OAEM
        4 => Substandard
        5 => Doubtful
        6 => Loss
     */



    public function scopeStartsBefore(Builder $query, $date): Builder
    {
        if (!empty($date)) {
            $datetime1 = null;
            $datetime2 = null;

            if (isset($date) && !empty($date)) {
                $dates = explode(' – ', $date);
                $fdate = @$dates[0];
                $tdate = @$dates[1];
                if (!empty($fdate) && !empty($tdate)) {
                    $datetime1 = new \DateTime($fdate);
                    $datetime2 = new \DateTime($tdate);
                }
            }

            $date_from = null;
            $date_to = null;

            if (!empty($date)) {
                $date_from = $datetime1->format('Y-m-d');
                $date_to = $datetime2->format('Y-m-d');
            }


        }

        return $query->whereBetween('created_at', [$date_from, $date_to]);
    }

    public function scopeSearchString(Builder $query, $search): Builder
    {
        return $query->where('name', 'LIKE', '%' . $search . '%')->
        orWhere('branch_id', 'LIKE', '%' . $search . '%')->
        orWhere('name', 'LIKE', '%' . $search . '%')->
        orWhere('son_daughter_wife', 'LIKE', '%' . $search . '%')->
        orWhere('business_department_profession', 'LIKE', '%' . $search . '%')->
        orWhere('designation', 'LIKE', '%' . $search . '%')->
        orWhere('pp_number', 'LIKE', '%' . $search . '%')->
        orWhere('date_of_birth', 'LIKE', '%' . $search . '%')->
        orWhere('office_business_address', 'LIKE', '%' . $search . '%')->
        orWhere('present_address', 'LIKE', '%' . $search . '%')->
        orWhere('customer_cnic', 'LIKE', '%' . $search . '%')->
        orWhere('customer_contact_number', 'LIKE', '%' . $search . '%')->
        orWhere('account_cd_saving', 'LIKE', '%' . $search . '%')->
        orWhere('renewal_enhancement_fresh_sanction', 'LIKE', '%' . $search . '%')->
        orWhere('sanction_date', 'LIKE', '%' . $search . '%')->
        orWhere('tenure_of_loan_in_months', 'LIKE', '%' . $search . '%')->
        orWhere('installment_type', 'LIKE', '%' . $search . '%')->
        orWhere('secure_unsecure_loan', 'LIKE', '%' . $search . '%')->
        orWhere('branch_manager_name_while_sanctioning', 'LIKE', '%' . $search . '%')->
        orWhere('status', 'LIKE', '%' . $search . '%')->
        orWhere('permanent_address', 'LIKE', '%' . $search . '%');
    }

    protected $fillable = [
        'branch_id',
        'name',
        'son_daughter_wife',
        'gender',
        'business_department_profession',
        'designation',
        'pp_number',
        'date_of_birth',
        'office_business_address',
        'present_address',
        'permanent_address',
        'customer_cnic',
        'customer_contact_number',
        'account_cd_saving',
        'product_id',
        'product_type_id',
        'renewal_enhancement_fresh_sanction',
        'amount_sanctioned',
        'amount_enhanced',
        'sanction_date',
        'tenure_of_loan_in_months',
        'installment_type',
        'emi_amount',
        'no_of_installments',
        'dac_issuance_date',
        'disbursement_date',
        'amount_disbursed',
        'expiry_date_as_per_dac',
        'kibor_or_fixed',
        'kibor_rate',
        'bank_spread_rate',
        'mark_up_rate',
        'branch_manager_name_while_sanctioning',
        'principle_amount',
        'markup_amount',
        'installment_insurance',
        'total_installment',
        'valuation_evaluator_company',
        'valuation_date_of_valuation',
        'secure_unsecure_loan',
        'manual_account',
        'customer_status',
        'loan_due_date',
        'last_installment_date',
        'status',
    ];


    public function guarantee(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Guarantee::class);
    }


    public function other_guarantee(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OtherGuarantee::class);
    }

    public function insurance(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Insurance::class);
    }


    public function claim_outstanding(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InsuranceClaim::class);
    }

    public function valuation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Valuation::class);
    }

    public function litigation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Litigation::class);
    }

    public function installments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Installment::class);
    }


    public function overDueInstallments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OverDueInstallment::class);
    }

    public function markup_details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MarkUpDetails::class);
    }


    public function interest(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Interest::class);
    }

    public function npl(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Npl::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }

}

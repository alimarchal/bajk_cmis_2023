<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Branch;
use App\Models\BranchOutstanding;
use App\Models\BranchOutstandingDaily;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\Insurance;
use App\Models\Interest;
use App\Models\MarkUpDetails;
use App\Models\OverDueInstallment;
use App\Models\ProductWiseDaily;
use App\Models\ProductWiseMonthly;
use App\Models\Test;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function dashboard()
    {

        // Consumer Finance First Category
//        $consumer_loan_first_cat = Customer::where('product_id', 1)->whereIn('product_type_id',[2,3,6])->where('status', 1)->get();
//        foreach ($consumer_loan_first_cat as $cl) {
//            $date = Carbon::parse($cl->last_installment_date);
//            $current_date = Carbon::now();
//            $diff = $date->diffInDays($current_date);
//
//            if ($diff >= 90) {
//                $cl->customer_status = 'Substandard';
//                $cl->save();
//            } elseif ($diff >= 180) {
//                $cl->customer_status = 'Doubtful';
//                $cl->save();
//            } elseif ($diff >= 365) {
//                $cl->customer_status = 'Loss';
//                $cl->save();
//            }
//        }


//        $consumer_loan_second_cat = Customer::where('product_id', 1)->whereIn('product_type_id', [1,4,5,7])->where('status', 1)->get();
//
//        foreach ($consumer_loan_second_cat as $cl) {
//            $date = Carbon::parse($cl->last_installment_date);
//            $current_date = Carbon::now();
//            $diff = $date->diffInDays($current_date);
//
//            if ($diff >= 90) {
//                $cl->customer_status = 'Substandard';
//                $cl->save();
//            } elseif ($diff >= 180) {
//                $cl->customer_status = 'Doubtful';
//                $cl->save();
//            } elseif ($diff >= 365) {
//                $cl->customer_status = 'Loss';
//                $cl->save();
//            }
//        }


        // commercial loan
//        $commercial_loans = Customer::where('product_id', 2)->where('status', 1)->get();
//        foreach ($commercial_loans as $cl) {
//            $date = Carbon::parse($cl->last_installment_date);
//            $current_date = Carbon::now();
//            $diff = $date->diffInDays($current_date);
//
//            if ($diff >= 90) {
//                $cl->customer_status = 'Substandard';
//                $cl->save();
//            } elseif ($diff >= 180) {
//                $cl->customer_status = 'Doubtful';
//                $cl->save();
//            } elseif ($diff >= 365) {
//                $cl->customer_status = 'Loss';
//                $cl->save();
//            }
//        }


        // micro finance
//        $micro_finance_loans = Customer::where('product_id', 3)->where('status', 1)->get();
//        foreach ($micro_finance_loans as $cl) {
//            $date = Carbon::parse($cl->last_installment_date);
//            $current_date = Carbon::now();
//            $diff = $date->diffInDays($current_date);
//
//            if ($diff >= 30 && $diff <= 90) {
//                $cl->customer_status = 'Substandard';
//                $cl->save();
//            } elseif ($diff >= 90 && $diff <= 180) {
//                $cl->customer_status = 'Doubtful';
//                $cl->save();
//            } elseif ($diff > 180) {
//                $cl->customer_status = 'Loss';
//                $cl->save();
//            }
//        }


        // micro finance
//        $agri_finance_loans = Customer::where('product_id', 4)->where('status', 1)->get();
//        foreach ($agri_finance_loans as $cl) {
//            $date = Carbon::parse($cl->last_installment_date);
//            $current_date = Carbon::now();
//            $diff = $date->diffInDays($current_date);
//
//            if ($diff >= 90) {
//                $cl->customer_status = 'OAEM';
//                $cl->save();
//            } elseif ($diff >= 365) {
//                $cl->customer_status = 'Substandard';
//                $cl->save();
//            }
//            elseif ($diff >= 547) {
//                $cl->customer_status = 'Doubtful';
//                $cl->save();
//            } elseif ($diff > 730) {
//                $cl->customer_status = 'Loss';
//                $cl->save();
//            }
//        }


//
//        $installment = Installment::where('date', '2022-08-30')->get();
//
//        foreach($installment as $inst)
//        {
//            $customer = Customer::find($inst->customer_id);
//            $customer->last_installment_date = $inst->date;
//            $customer->save();
//        }


//        $customers = Customer::all();
//
//        foreach($customers as $customer)
//        {
//            $customer->name = ucwords(strtolower($customer->name));
//            $customer->son_daughter_wife = ucwords(strtolower($customer->son_daughter_wife));
//            $customer->gender = ucwords(strtolower($customer->gender));
//            $customer->business_department_profession = ucwords(strtolower($customer->business_department_profession));
//            $customer->designation = ucwords(strtolower($customer->designation));
//            $customer->office_business_address = ucwords(strtolower($customer->office_business_address));
//            $customer->present_address = ucwords(strtolower($customer->present_address));
//            $customer->permanent_address = ucwords(strtolower($customer->permanent_address));
//            $customer->secure_unsecure_loan = ucwords(strtolower($customer->secure_unsecure_loan));
//            $customer->save();
//        }

//        dd($customers);
//        $tests = Test::all();

//        foreach($tests as $test)
//        {
//            $customer = Customer::where('account_cd_saving', $test->ac_number)->first();
//            if (!empty($customer))
//            {
//                $test->customer_id = $customer->id;
//                $test->save();
//            }
//        }

        /*
                foreach ($tests as $test) {
                    $flag = true;
                    DB::beginTransaction();
                    try {

                        $customer = Customer::find($test->customer_id);

                        $installment = Installment::create([
                            'old_os' => $customer->principle_amount,
                            'customer_id' => $test->id,
                            'user_id' => 1,
                            'date' => '2022-08-30',
                            'no_of_installment' => 1,
                            'days_passed_overdue' => 1,
                            'principal_amount' => $test->principal_amount,
                            'mark_up_amount' => $test->markup,
                            'penalty_charges' => $test->penalty_charges,
                            'total_principal_markup_penalty' => $test->total,
                            'principal_outstanding' => $test->os,
                            'category_of_default' => NULL,
                        ]);

                        if ($installment->principal_amount > 1) {
                            $customer->principle_amount = $customer->principle_amount - $installment->principal_amount;
                        }
                        $customer->save();

                        $installment_object = Installment::find($installment->id);
                        $installment_object->principal_outstanding = $customer->principle_amount;
                        $installment_object->save();

                        DB::commit();
                        // all good
                    } catch (\Exception $e) {
                        DB::rollback();
                        $flag = false;
                        // something went wrong
                    }
                }


                dd('ss');
        */

        ///


        $total_borrower = 0;
        $total_amount_outstanding = 0;
        $total_active_user = 0;
        $consumer_financing_outstanding = 0;
        $commercial_sme_financing = 0;
        $micro_financing = 0;
        $agriculture_financing = 0;
        $consumer_financing_outstanding_noa = 0;
        $commercial_sme_financing_noa = 0;
        $micro_financing_noa = 0;
        $agriculture_financing_noa = 0;

        if (Auth::user()->hasRole(['Credit Officer', 'Branch Manager'])) {

            $total_borrower = Customer::where('branch_id', \auth()->user()->branch_id)->where('status', 1)->count();
            $total_amount_outstanding = Customer::where('branch_id', \auth()->user()->branch_id)->sum('principle_amount');
            $total_active_user = User::where('branch_id', \auth()->user()->branch_id)->where('status', 'Active')->count();

            $consumer_financing_outstanding = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '1')->sum('principle_amount');
            $commercial_sme_financing = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '2')->sum('principle_amount');
            $micro_financing = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '3')->sum('principle_amount');
            $agriculture_financing = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '4')->sum('principle_amount');

            $consumer_financing_outstanding_noa = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '1')->count();
            $commercial_sme_financing_noa = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '2')->count();
            $micro_financing_noa = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '3')->count();
            $agriculture_financing_noa = Customer::where('branch_id', \auth()->user()->branch_id)->where('product_id', '4')->count();

            $npl_accounts = Customer::where('branch_id', \auth()->user()->branch_id)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->count();
            $npl_accounts_amount = Customer::where('branch_id', \auth()->user()->branch_id)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->sum('principle_amount');


        } elseif (Auth::user()->hasRole('South Regional MIS Officer')) {
            $south_branches = Branch::where('region', 'South Region')->get('id');
            $branches = [];
            foreach ($south_branches as $item) {
                $branches[] = $item->id;
            }


            $total_borrower = Customer::whereIn('branch_id', $branches)->where('status', 1)->count();
            $total_amount_outstanding = Customer::whereIn('branch_id', $branches)->sum('principle_amount');
            $total_active_user = User::whereIn('branch_id', $branches)->where('status', 'Active')->count();
            // Financing Cards
            $consumer_financing_outstanding = Customer::whereIn('branch_id', $branches)->where('product_id', '1')->sum('principle_amount');
            $commercial_sme_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '2')->sum('principle_amount');
            $micro_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '3')->sum('principle_amount');
            $agriculture_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '4')->sum('principle_amount');

            $consumer_financing_outstanding_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '1')->count();
            $commercial_sme_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '2')->count();
            $micro_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '3')->count();
            $agriculture_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '4')->count();


            $npl_accounts = Customer::whereIn('branch_id', $branches)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->count();
            $npl_accounts_amount = Customer::whereIn('branch_id', $branches)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->sum('principle_amount');

        } elseif (Auth::user()->hasRole('North Regional MIS Officer')) {

            $north_branches = Branch::where('region', 'North Region')->get('id');
            $branches = [];
            foreach ($north_branches as $item) {
                $branches[] = $item->id;
            }

            $total_borrower = Customer::whereIn('branch_id', $branches)->where('status', 1)->count();
            $total_amount_outstanding = Customer::whereIn('branch_id', $branches)->sum('principle_amount');
            $total_active_user = User::whereIn('branch_id', $branches)->where('status', 'Active')->count();
            // Financing Cards
            $consumer_financing_outstanding = Customer::whereIn('branch_id', $branches)->where('product_id', '1')->sum('principle_amount');
            $commercial_sme_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '2')->sum('principle_amount');
            $micro_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '3')->sum('principle_amount');
            $agriculture_financing = Customer::whereIn('branch_id', $branches)->where('product_id', '4')->sum('principle_amount');

            $consumer_financing_outstanding_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '1')->count();
            $commercial_sme_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '2')->count();
            $micro_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '3')->count();
            $agriculture_financing_noa = Customer::whereIn('branch_id', $branches)->where('product_id', '4')->count();

            $npl_accounts = Customer::whereIn('branch_id', $branches)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->count();
            $npl_accounts_amount = Customer::whereIn('branch_id', $branches)->where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->sum('principle_amount');

        } elseif (Auth::user()->hasRole(['Head Office', 'Super-Admin'])) {
            $total_borrower = Customer::where('status', 1)->count();
            $total_amount_outstanding = Customer::sum('principle_amount');
            $total_active_user = User::where('status', 'Active')->count();
            // Financing Cards
            $consumer_financing_outstanding = Customer::where('product_id', '1')->sum('principle_amount');
            $commercial_sme_financing = Customer::where('product_id', '2')->sum('principle_amount');
            $micro_financing = Customer::where('product_id', '3')->sum('principle_amount');
            $agriculture_financing = Customer::where('product_id', '4')->sum('principle_amount');

            $consumer_financing_outstanding_noa = Customer::where('product_id', '1')->count();
            $commercial_sme_financing_noa = Customer::where('product_id', '2')->count();
            $micro_financing_noa = Customer::where('product_id', '3')->count();
            $agriculture_financing_noa = Customer::where('product_id', '4')->count();

            $npl_accounts = Customer::where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->count();
            $npl_accounts_amount = Customer::where('customers.status', '=', 1)->whereNotIn('customers.customer_status', ['Regular', 'Irregular'])->sum('principle_amount');

        }


        return view('dashboard',
            compact('total_borrower', 'total_amount_outstanding', 'total_active_user',
                'consumer_financing_outstanding', 'commercial_sme_financing',
                'micro_financing', 'agriculture_financing',
                'consumer_financing_outstanding_noa', 'commercial_sme_financing_noa',
                'micro_financing_noa', 'agriculture_financing_noa', 'npl_accounts', 'npl_accounts_amount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = null;
        $per_page_count = $request->input('per_page_count', 10);

        if (Auth::user()->hasRole(['Credit Officer', 'Branch Manager'])) {
            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type')->where('branch_id', \auth()->user()->branch_id))
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::scope('customer_status_custom'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),
                ])->paginate($per_page_count)->withQueryString();
        } elseif (Auth::user()->hasRole('South Regional MIS Officer')) {
            $south_branches = Branch::where('region', 'South Region')->get('id');
            $branches = [];
            foreach ($south_branches as $item) {
                $branches[] = $item->id;
            }

            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type')->whereIn('branch_id', $branches))
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),

                ])->paginate($per_page_count)->withQueryString();
        } elseif (Auth::user()->hasRole('North Regional MIS Officer')) {

            $north_branches = Branch::where('region', 'North Region')->get('id');
            $branches = [];
            foreach ($north_branches as $item) {
                $branches[] = $item->id;
            }

            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type')->whereIn('branch_id', $branches))
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
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

                ])->paginate($per_page_count)->withQueryString();
        } elseif (Auth::user()->hasRole(['Head Office', 'Super-Admin'])) {
            $customers = QueryBuilder::for(Customer::with('branch', 'product', 'product_type'))
                ->allowedFilters([
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::scope('search_string'),
                    AllowedFilter::exact('customer_cnic'),
                    AllowedFilter::exact('product_type_id'),
                    AllowedFilter::exact('customer_status'),
                    AllowedFilter::exact('branch_id'),
                    AllowedFilter::exact('account_cd_saving'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('manual_account'),
                    AllowedFilter::exact('status'),
                ])->paginate($per_page_count)->withQueryString();
        }

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCustomerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {

        $flag = true;
        DB::beginTransaction();
        try {

            $branch = Branch::find($request->branch_id);
//            $request->merge(['account_cd_saving' => $branch->code . '-' . $request->account_cd_saving]);
            $customer = Customer::create($request->all());

            $interest = Interest::create([
                'customer_id' => $customer->id,
                'date' => Carbon::now()->format('Y-m-d'),
                'kibor' => $request->kibor_rate,
                'bank_spread' => $request->bank_spread_rate,
                'total' => $request->kibor_rate + $request->bank_spread_rate,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            $flag = false;
            // something went wrong
        }


        if ($flag) {
            session()->flash('message', 'Borrower successfully created.');
            return to_route('customer.show', $customer->id);
        } else {
            session()->flash('error', 'Something went wrong!.');
            return to_route('customer.show', $customer->id);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function profile(Customer $customer)
    {

        return view('customer.profile', compact('customer'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCustomerRequest $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        /*
                $account_data = $request->account_cd_saving;
                $account_no_branch = explode("-", $account_data);
                if (count($account_no_branch) > 1) {
                    $branch = Branch::find($request->branch_id);
                    $request->merge(['account_cd_saving' => $branch->code . '-' . $account_no_branch[1]]);
                } else {
                    $branch = Branch::find($request->branch_id);
                    $request->merge(['account_cd_saving' => $branch->code . '-' . $account_data]);
                }
        */
        $customer->update($request->all());
        session()->flash('message', 'Borrower successfully updated.');
        return to_route('customer.show', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

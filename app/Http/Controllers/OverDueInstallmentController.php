<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstallmentRequest;
use App\Http\Requests\StoreOverDueInstallmentRequest;
use App\Http\Requests\UpdateOverDueInstallmentRequest;
use App\Models\Customer;
use App\Models\OverDueInstallment;
use Illuminate\Support\Facades\DB;

class OverDueInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('over-due-installment.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('over-due-installment.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInstallmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOverDueInstallmentRequest $request, Customer $customer)
    {

        $flag = true;
        DB::beginTransaction();
        try {
            $request->merge(['customer_id' => $customer->id]);
            $request->merge(['user_id' => auth()->user()->id]);
            $installment = OverDueInstallment::create($request->all());

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            $flag = false;
            // something went wrong
        }

//        dd($flag);

        if ($flag) {
            session()->flash('message', 'Over Due Installment data has been successfully posted.');
            return to_route('over-due-installment.index', $customer->id);
        } else {
            session()->flash('error', 'Something went wrong! There is an error in your input!.');
            return to_route('over-due-installment.index', $customer->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OverDueInstallment  $overDueInstallment
     * @return \Illuminate\Http\Response
     */
    public function show(OverDueInstallment $overDueInstallment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OverDueInstallment  $overDueInstallment
     * @return \Illuminate\Http\Response
     */
    public function edit(OverDueInstallment $overDueInstallment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOverDueInstallmentRequest  $request
     * @param  \App\Models\OverDueInstallment  $overDueInstallment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOverDueInstallmentRequest $request, OverDueInstallment $overDueInstallment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OverDueInstallment  $overDueInstallment
     * @return \Illuminate\Http\Response
     */
    public function destroy(OverDueInstallment $overDueInstallment)
    {
        //
    }
}

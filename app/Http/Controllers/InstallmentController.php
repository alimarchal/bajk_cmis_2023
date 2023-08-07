<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstallmentRequest;
use App\Http\Requests\UpdateInstallmentRequest;
use App\Models\BranchOutstanding;
use App\Models\Customer;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('installment.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('installment.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInstallmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstallmentRequest $request, Customer $customer)
    {

        $flag = true;
        DB::beginTransaction();
        try {
            $request->merge(['customer_id' => $customer->id]);
            $request->merge(['user_id' => auth()->user()->id]);

            $installment = Installment::create($request->all());
            $customer->principle_amount = $customer->principle_amount - $installment->principal_amount;
            $customer->last_installment_date = $request->date;
            $customer->save();


//            $installment_object = Installment::find($installment->id);
            $installment->principal_outstanding = $customer->principle_amount;
            $installment->save();
//            dd($installment);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            $flag = false;
            // something went wrong
        }

//        dd($flag);

        if ($flag) {
            session()->flash('message', 'Installment data has been successfully posted.');
            return to_route('installment.index', $customer->id);
        } else {
            session()->flash('error', 'Something went wrong! There is an error in your input!.');
            return to_route('installment.index', $customer->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Installment $installment
     * @return \Illuminate\Http\Response
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Installment $installment
     * @return \Illuminate\Http\Response
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInstallmentRequest $request
     * @param \App\Models\Installment $installment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstallmentRequest $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Installment $installment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        //
    }
}

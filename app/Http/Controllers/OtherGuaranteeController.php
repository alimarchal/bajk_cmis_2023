<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOtherGuaranteeRequest;
use App\Http\Requests\UpdateOtherGuaranteeRequest;
use App\Models\Customer;
use App\Models\OtherGuarantee;

class OtherGuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('otherGuarantee.index',compact('customer'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('otherGuarantee.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOtherGuaranteeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOtherGuaranteeRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);
        $gurantee = OtherGuarantee::create($request->all());
        session()->flash('message', '>Other than personal guarantee data has been successfully saved.');
        return to_route('otherGuarantee.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OtherGuarantee  $otherGuarantee
     * @return \Illuminate\Http\Response
     */
    public function show(OtherGuarantee $otherGuarantee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OtherGuarantee  $otherGuarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(OtherGuarantee $otherGuarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOtherGuaranteeRequest  $request
     * @param  \App\Models\OtherGuarantee  $otherGuarantee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOtherGuaranteeRequest $request, OtherGuarantee $otherGuarantee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OtherGuarantee  $otherGuarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(OtherGuarantee $otherGuarantee)
    {
        //
    }
}

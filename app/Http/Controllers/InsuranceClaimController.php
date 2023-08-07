<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInsuranceClaimRequest;
use App\Http\Requests\UpdateInsuranceClaimRequest;
use App\Models\Customer;
use App\Models\InsuranceClaim;

class InsuranceClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('insuranceClaim.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insuranceClaim.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreInsuranceClaimRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInsuranceClaimRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);

        $claim_outstanding = InsuranceClaim::create($request->all());
        session()->flash('message', 'Claim outstanding data has been successfully saved.');
        return to_route('insuranceClaim.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\InsuranceClaim $insuranceClaim
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceClaim $insuranceClaim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\InsuranceClaim $insuranceClaim
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, InsuranceClaim $insuranceClaim)
    {
        return view('insuranceClaim.edit', compact('customer', 'insuranceClaim'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateInsuranceClaimRequest $request
     * @param \App\Models\InsuranceClaim $insuranceClaim
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInsuranceClaimRequest $request, Customer $customer, InsuranceClaim $insuranceClaim)
    {
        $claim_outstanding = $insuranceClaim->update($request->all());
        session()->flash('message', 'Claim outstanding data has been successfully updated.');
        return to_route('insuranceClaim.index', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\InsuranceClaim $insuranceClaim
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceClaim $insuranceClaim)
    {
        //
    }
}

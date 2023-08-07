<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreValuationRequest;
use App\Http\Requests\UpdateValuationRequest;
use App\Models\Customer;
use App\Models\Valuation;

class ValuationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('valuation.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreValuationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreValuationRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);
        $valuation = Valuation::create($request->all());
        session()->flash('message', 'Valuation data has been successfully saved.');
        return to_route('valuation.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function show(Valuation $valuation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function edit(Valuation $valuation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateValuationRequest  $request
     * @param  \App\Models\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateValuationRequest $request, Valuation $valuation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valuation  $valuation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valuation $valuation)
    {
        //
    }
}

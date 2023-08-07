<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestRequest;
use App\Http\Requests\UpdateInterestRequest;
use App\Models\Customer;
use App\Models\Interest;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('interest.index', compact('customer'));
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
     * @param  \App\Http\Requests\StoreInterestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInterestRequest $request, Customer $customer)
    {

        if (!$request->has('kibor'))
        {
            $request->merge(['kibor' => 0.00]);
        }


        $request->merge(['customer_id' => $customer->id]);
        $request->merge(['total' => $request->kibor + $request->bank_spread]);

        $interest = Interest::create($request->all());

        $customer->kibor_rate = $request->kibor;
        $customer->bank_spread_rate = $request->bank_spread;
        $customer->mark_up_rate = $request->kibor + $request->bank_spread;
        $customer->save();

        session()->flash('message', 'Interest data has been successfully saved.');
        return to_route('interest.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function show(Interest $interest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function edit(Interest $interest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInterestRequest  $request
     * @param  \App\Models\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInterestRequest $request, Interest $interest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interest  $interest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interest $interest)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuaranteeRequest;
use App\Http\Requests\UpdateGuaranteeRequest;
use App\Models\Customer;
use App\Models\Guarantee;

class GuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {

        return view('guarantee.index',compact('customer'));
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
     * @param  \App\Http\Requests\StoreGuaranteeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuaranteeRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);
        $gurantee = Guarantee::create($request->all());
        session()->flash('message', 'Security / Personal Guarantee data has been successfully saved.');
        return to_route('guarantee.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function show(Guarantee $guarantee)
    {
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantee $guarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGuaranteeRequest  $request
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuaranteeRequest $request, Guarantee $guarantee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guarantee $guarantee)
    {
        //
    }
}

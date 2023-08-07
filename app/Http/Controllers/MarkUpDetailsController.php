<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarkUpDetailsRequest;
use App\Http\Requests\UpdateMarkUpDetailsRequest;
use App\Models\Customer;
use App\Models\MarkUpDetails;

class MarkUpDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('markUpDetails.index', compact('customer'));
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
     * @param  \App\Http\Requests\StoreMarkUpDetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarkUpDetailsRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);
        $litigation = MarkUpDetails::create($request->all());
        session()->flash('message', 'Markup Details data has been successfully saved.');
        return to_route('markUpDetails.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarkUpDetails  $markUpDetails
     * @return \Illuminate\Http\Response
     */
    public function show(MarkUpDetails $markUpDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarkUpDetails  $markUpDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(MarkUpDetails $markUpDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarkUpDetailsRequest  $request
     * @param  \App\Models\MarkUpDetails  $markUpDetails
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarkUpDetailsRequest $request, MarkUpDetails $markUpDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarkUpDetails  $markUpDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarkUpDetails $markUpDetails)
    {
        //
    }
}

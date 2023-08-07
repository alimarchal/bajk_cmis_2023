<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNplRequest;
use App\Http\Requests\UpdateNplRequest;
use App\Models\Customer;
use App\Models\Interest;
use App\Models\Npl;

class NplController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        return view('npl.index', compact('customer'));
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
     * @param  \App\Http\Requests\StoreNplRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNplRequest $request, Customer $customer)
    {


        $request->merge(['customer_id' => $customer->id]);
        $npl = Npl::create($request->all());

        $customer->customer_status = $request->customer_status;
        $customer->save();

        session()->flash('message', 'NPL data has been successfully saved.');
        return to_route('npl.index', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Npl  $npl
     * @return \Illuminate\Http\Response
     */
    public function show(Npl $npl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Npl  $npl
     * @return \Illuminate\Http\Response
     */
    public function edit(Npl $npl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNplRequest  $request
     * @param  \App\Models\Npl  $npl
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNplRequest $request, Npl $npl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Npl  $npl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Npl $npl)
    {
        //
    }
}

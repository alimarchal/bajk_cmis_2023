<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnhancementRequest;
use App\Http\Requests\UpdateEnhancementRequest;
use App\Models\Customer;
use App\Models\Enhancement;

class EnhancementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Customer $customer)
    {
        return view('enhancement.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnhancementRequest $request, Customer $customer)
    {
        $request->merge(['customer_id' => $customer->id]);
        $enhancement = Enhancement::create($request->all());

        $customer->renewal_enhancement_fresh_sanction = $request->enhancement_status;
        $customer->principle_amount = $customer->principle_amount + $request->enhancement_amount;
        $customer->save();

        session()->flash('message', 'Enhancement data has been successfully saved.');
        return to_route('enhancement.index', $customer->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enhancement $enhancement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enhancement $enhancement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnhancementRequest $request, Enhancement $enhancement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enhancement $enhancement)
    {
        //
    }
}

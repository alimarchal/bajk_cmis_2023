<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdjustedRequest;
use App\Http\Requests\UpdateAdjustedRequest;
use App\Models\Adjusted;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Throwable;

class AdjustedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Customer $customer)
    {
        return view('adjusted.index', compact('customer'));
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
    public function store(StoreAdjustedRequest $request, Customer $customer)
    {
        $flag = false;

        if ($customer->principle_amount == 0)
        {
            try {
                DB::beginTransaction();

                // Set the customer_id and user_id on the request data
                $adjustedData = $request->all() + [
                        'customer_id' => $customer->id,
                        'user_id' => auth()->id(),
                    ];

                // Create the Adjusted model in the database.
                Adjusted::create($adjustedData);

                // Update the customer's status
                $customer->status = $request->adjusted_status;
                $customer->save();

                // Commit the transaction
                DB::commit();

                // Add a flash message to the session.
                session()->flash('message', 'Adjustment data has been successfully saved.');

            } catch (Throwable $e) {
                // Rollback the transaction
                DB::rollBack();

                // Handle the exception, e.g. log it and add an error message to the session
                \Log::error($e->getMessage(), ['exception' => $e]);
                session()->flash('error', 'There was a problem saving the adjustment data.');

                // Redirect back with input data in case of an error
                return back()->withInput();
            }

            // Redirect to the 'adjusted.index' route with the customer's ID.
            return to_route('adjusted.index', $customer->id);
        } else {

            session()->flash('error', 'Principal amount must be zero before adjusting the customer. Hence, I am not accepting your data.');
            return to_route('adjusted.index', $customer->id);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Adjusted $adjusted)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adjusted $adjusted)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdjustedRequest $request, Adjusted $adjusted)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjusted $adjusted)
    {
        //
    }
}

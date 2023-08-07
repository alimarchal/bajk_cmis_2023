<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchOutstandingDailyRequest;
use App\Http\Requests\UpdateBranchOutstandingDailyRequest;
use App\Models\BranchOutstandingDaily;

class BranchOutstandingDailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreBranchOutstandingDailyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchOutstandingDailyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchOutstandingDaily  $branchOutstandingDaily
     * @return \Illuminate\Http\Response
     */
    public function show(BranchOutstandingDaily $branchOutstandingDaily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchOutstandingDaily  $branchOutstandingDaily
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchOutstandingDaily $branchOutstandingDaily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchOutstandingDailyRequest  $request
     * @param  \App\Models\BranchOutstandingDaily  $branchOutstandingDaily
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchOutstandingDailyRequest $request, BranchOutstandingDaily $branchOutstandingDaily)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchOutstandingDaily  $branchOutstandingDaily
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchOutstandingDaily $branchOutstandingDaily)
    {
        //
    }
}

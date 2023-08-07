<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchOutstandingRequest;
use App\Http\Requests\UpdateBranchOutstandingRequest;
use App\Models\BranchOutstanding;

class BranchOutstandingController extends Controller
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
     * @param  \App\Http\Requests\StoreBranchOutstandingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchOutstandingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchOutstanding  $branchOutstanding
     * @return \Illuminate\Http\Response
     */
    public function show(BranchOutstanding $branchOutstanding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchOutstanding  $branchOutstanding
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchOutstanding $branchOutstanding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBranchOutstandingRequest  $request
     * @param  \App\Models\BranchOutstanding  $branchOutstanding
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchOutstandingRequest $request, BranchOutstanding $branchOutstanding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchOutstanding  $branchOutstanding
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchOutstanding $branchOutstanding)
    {
        //
    }
}

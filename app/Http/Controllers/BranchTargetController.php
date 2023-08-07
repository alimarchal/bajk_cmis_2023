<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBranchTargetRequest;
use App\Http\Requests\UpdateBranchTargetRequest;
use App\Models\BranchTarget;

class BranchTargetController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Full Access')->only('create');
        $this->middleware('permission:Full Access')->only('index');
        $this->middleware('permission:Full Access')->only('store');
        $this->middleware('permission:Full Access')->only('edit');
        $this->middleware('permission:Full Access')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch_target = BranchTarget::orderBy('branch_id', 'ASC')->paginate(80);
        return view('branchTarget.index',compact('branch_target'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branchTarget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBranchTargetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBranchTargetRequest $request)
    {
        $branch_target = BranchTarget::create([
            'branch_id' => $request->branch_id,
            'amount' => $request->amount,
            'year' => $request->year,
        ]);
        session()->flash('message', 'Branch target has been set successfully.');
        return to_route('branchTarget.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BranchTarget $branchTarget
     * @return \Illuminate\Http\Response
     */
    public function show(BranchTarget $branchTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BranchTarget $branchTarget
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchTarget $branchTarget)
    {
        return view('branchTarget.edit',compact('branchTarget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBranchTargetRequest $request
     * @param \App\Models\BranchTarget $branchTarget
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBranchTargetRequest $request, BranchTarget $branchTarget)
    {
        $branchTarget->update([
            'branch_id' => $request->branch_id,
            'amount' => $request->amount,
            'year' => $request->year,
        ]);
        session()->flash('message', 'Branch target has been successfully updated...');
        return to_route('branchTarget.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BranchTarget $branchTarget
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchTarget $branchTarget)
    {
        //
    }
}

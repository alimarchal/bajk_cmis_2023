@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Claim Outstanding
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="{{route('insuranceClaim.update', [$customer->id, $insuranceClaim->id])}}">
        @csrf
        @method('PUT')
        @include('theme.customer')

        <br>

        <div class="form-row">
            <div class="col-md-3 mb-2">
                <label for="insurance_id"><strong>Insurance Company</strong></label>
                <select class="form-control" id="insurance_id" style="width: 100%;" name="insurance_id" required>
                    <option value="">None</option>
                    @foreach($customer->insurance as $inc)
                        <option value="{{$inc->id}}" @if($insuranceClaim->insurance_id == $inc->id) selected @endif>{{$inc->insurance_company}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label for="claim_amount"><strong>Claim Amount</strong></label>
                <input type="number" min="0.00" step="0.01" value="{{$insuranceClaim->claim_amount}}" class="form-control" id="claim_amount" title="" name="claim_amount">
            </div>
            <div class="col-md-3 mb-3">
                <label for="date_of_claim"><strong>Date of Claim</strong></label>
                <input type="date" class="form-control"  value="{{$insuranceClaim->date_of_claim}}" id="date_of_claim" name="date_of_claim">
            </div>

            <div class="col-md-3 mb-2">
                <label for="status"><strong>Status</strong></label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">None</option>
                    <option value="Settled" @if($insuranceClaim->status == "Settled") selected @endif>Settled</option>
                    <option value="Pending" @if($insuranceClaim->status == "Pending") selected @endif>Pending</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="remarks"><strong>Remarks / Additional Details</strong></label>
                <textarea class="form-control" id="remarks" name="remarks">{{$insuranceClaim->remarks}}</textarea>
            </div>
        </div>
        <button class="btn btn-primary float-right" type="submit">Update</button>
    </form>

@endsection

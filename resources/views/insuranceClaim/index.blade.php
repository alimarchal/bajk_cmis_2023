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
    <form method="post" action="{{route('insuranceClaim.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <div class="form-row">
            <div class="col-md-3 mb-2">
                <label for="insurance_id"><strong>Insurance Company</strong></label>
                <select class="form-control" id="insurance_id" style="width: 100%;" name="insurance_id" required>
                    <option value="">None</option>
                    @foreach($customer->insurance as $inc)
                        <option value="{{$inc->id}}">{{$inc->insurance_company}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label for="claim_amount"><strong>Claim Amount</strong></label>
                <input type="number" min="0.00" step="0.01" class="form-control" id="claim_amount" title="" name="claim_amount">
            </div>
            <div class="col-md-3 mb-3">
                <label for="date_of_claim"><strong>Date of Claim</strong></label>
                <input type="date" class="form-control" id="date_of_claim" name="date_of_claim">
            </div>

            <div class="col-md-3 mb-2">
                <label for="status"><strong>Status</strong></label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">None</option>
                    <option value="Settled">Settled</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="remarks"><strong>Remarks / Additional Details</strong></label>
                <textarea class="form-control" id="remarks" name="remarks"></textarea>
            </div>
        </div>
        <button class="btn btn-primary float-right" type="submit">Save</button>
    </form>

    <br>
    @if($customer->claim_outstanding->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">
            Claim Outstanding
        </h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Insurance Company</th>
                <th scope="col">Claim Amount</th>
                <th scope="col">Date of Claim</th>
                <th scope="col">Remarks</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->claim_outstanding as $co)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>
                        <a href="{{route('insuranceClaim.edit',[$customer->id,$co->id])}}">
                            {{\App\Models\Insurance::find($co->insurance_id)->insurance_company}}
                        </a>
                    </td>
                    <td>{{$co->claim_amount}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date_of_claim)->format('d-m-Y')}}</td>
                    <td>{{$co->remarks}}</td>
                    <td>{{$co->status}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif

@endsection

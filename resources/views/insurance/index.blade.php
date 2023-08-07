@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Insurance
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif



    <form class="needs-validation" novalidate method="post" action="{{route('insurance.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>
        <div class="form-row">
            <div class="col-md-3 mb-2">
                <label><strong>Insurance Company</strong></label>
                <input type="text" class="form-control" id="insurance_company" name="insurance_company">
            </div>
            <div class="col-md-3 mb-3">
                <label><strong>Date of Insurance</strong></label>
                <input type="date" class="form-control" id="date_of_insurance" name="date_of_insurance">
            </div>
            <div class="col-md-3 mb-2">
                <label><strong>Insured Amount</strong></label>
                <input type="number" min="" class="form-control" id="insurance_amount" name="insurance_amount">
            </div>
            <div class="col-md-3 mb-3">
                <label><strong>Date of Expiry of Insurance</strong></label>
                <input type="date" class="form-control" id="date_of_expiry_of_insurance" name="date_of_expiry_of_insurance">
            </div>

            <div class="col-md-3 mb-3">
                <label for="remarks"><strong>Remarks / Additional Details</strong></label>
                <textarea class="form-control"  id="remarks" name="remarks" ></textarea>
            </div>
        </div>

        <button class="btn btn-primary float-right" type="submit">Save Insurance</button>
    </form>
    <br>

    @if($customer->insurance->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">Insurance</h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Insurance Company</th>
                <th scope="col">Date of Insurance</th>
                <th scope="col">Insured Amount</th>
                <th scope="col">Date of Expiry of Insurance</th>
                <th scope="col">Remarks / Additional Details</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->insurance as $inu)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$inu->insurance_company}}</td>
                    <td>{{$inu->date_of_insurance}}</td>
                    <td>{{$inu->insurance_amount}}</td>
                    <td>{{\Carbon\Carbon::parse($inu->date_of_expiry_of_insurance)->format('d-m-Y')}}</td>
                    <td>{{$inu->remarks}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif





@endsection

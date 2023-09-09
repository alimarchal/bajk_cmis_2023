@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Valuation
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="{{route('valuation.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="evaluator_company"><strong>Evaluator Company</strong></label>
                <input type="text" class="form-control" required id="evaluator_company" name="evaluator_company">
            </div>
            <div class="col-md-4 mb-3">
                <label for="date_of_valuation"><strong>Date of Valuation</strong></label>
                <input type="date" class="form-control" required id="date_of_valuation" name="date_of_valuation">
            </div>

            <div class="col-md-4 mb-3">
                <label for="date_of_valuation_expiry"><strong>Valuation Expiry</strong></label>
                <input type="date" class="form-control" required id="date_of_valuation_expiry" name="date_of_valuation_expiry">
            </div>

        </div>
        <button class="btn btn-primary float-right" type="submit">Save</button>
    </form>


    <br>
    @if($customer->valuation->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">
            Valuation
        </h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Evaluator Company</th>
                <th scope="col">Date of Valuation</th>
                <th scope="col">Valuation Expiry</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->valuation as $co)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$co->evaluator_company}}</td>
{{--                    <td>{{\Carbon\Carbon::parse($co->date_of_valuation)->format('d-m-Y')}}</td>--}}
                    <td>{{$co->date_of_valuation}}</td>
                    <td>{{$co->date_of_valuation_expiry}}</td>
{{--                    <td>{{\Carbon\Carbon::parse($co->date_of_valuation_expiry)->format('d-m-Y')}}</td>--}}
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
@endsection

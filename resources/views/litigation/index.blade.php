@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Litigation
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="{{route('litigation.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <div class="form-row">
            <div class="col-md-4 mb-2">
                <label for="name_of_court"><strong>Name of Court</strong></label>
                <input type="text" class="form-control" id="name_of_court" name="name_of_court">
            </div>
            <div class="col-md-4 mb-3">
                <label for="recovery_status"><strong>Recovery Status (Full or Partial)</strong></label>
                <select name="recovery_status" id="recovery_status" class="form-control">
                    <option value="">None</option>
                    <option value="Full">Full</option>
                    <option value="Partial">Partial</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label for="date_of_final_settlement"><strong>Date of Final Settlement</strong></label>
                <input type="date" class="form-control" id="date_of_final_settlement"
                       name="date_of_final_settlement">
            </div>
        </div>
            <button class="btn btn-primary float-right" type="submit">Save</button>
    </form>


    <br>
    @if($customer->litigation->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">
            Litigation Status</h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name of Court</th>
                <th scope="col">Recovery Status(Full or Partial)</th>
                <th scope="col">Date of Final Settlement</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->litigation as $co)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$co->name_of_court}}</td>
                    <td>{{$co->recovery_status}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date_of_final_settlement)->format('d-m-Y')}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
@endsection

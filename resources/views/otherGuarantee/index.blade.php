@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Security
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="{{route('otherGuarantee.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <livewire:security />

        <button class="btn btn-primary float-right" type="submit">Save</button>
        <br>
    </form>

    @if($customer->other_guarantee->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">Security</h2>
        <hr>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Primary</th>
                <th scope="col">Secondary</th>
                <th scope="col">Ownership</th>
                <th scope="col">Market Value</th>
                <th scope="col">FSV</th>
                <th scope="col">Remarks</th>
            </tr>
            </thead>

            <tbody>
            @foreach($customer->other_guarantee as $og)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$og->primary}}</td>
                    <td>{{$og->secondary}}</td>
                    <td>{{$og->ownership}}</td>
                    <td>{{$og->market_value}}</td>
                    <td>{{$og->fsv}}</td>
                    <td>{{$og->remarks}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif

@endsection

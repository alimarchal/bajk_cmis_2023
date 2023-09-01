@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Mark Up Details
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <form method="post" action="{{route('markUpDetails.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <div class="form-row">

            <div class="col-md-3 mb-2">
                <label for="date"><strong>Date</strong></label>
                <input type="date" class="form-control" id="date" name="date">
            </div>


            <div class="col-md-3 mb-2">
                <label for="markup_receivable_4600"><strong>Mark-Up Receivable (4600)</strong></label>
                <input type="number" step="0.01" class="form-control" id="markup_receivable_4600" name="markup_receivable_4600">
            </div>

            <div class="col-md-3 mb-2">
                <label for="markup_recovered_till_date"><strong>Mark-Up Recovered Till Date</strong></label>
                <input type="number" step="0.01" class="form-control" id="markup_recovered_till_date" name="markup_recovered_till_date">
            </div>

            <div class="col-md-3 mb-2">
                <label for="markup_recovered_ac_5008"><strong>Mark-Up Recoverable A/C (5008)</strong></label>
                <input type="number" step="0.01" class="form-control" id="markup_recovered_ac_5008" name="markup_recovered_ac_5008">
            </div>

            <div class="col-md-3 mb-2">
                <label for="markup_recovered_ac_2405"><strong>Mark-Up Reserve A/C (2305)</strong></label>
                <input type="number" step="0.01" class="form-control" id="markup_recovered_ac_2405" name="markup_recovered_ac_2405">
            </div>


        </div>
        <button class="btn btn-primary float-right" type="submit">Save</button>
    </form>


    <br>
    @if($customer->markup_details->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">
            Mark-Up Details
        </h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Mark-Up Receivable (4600)</th>
                <th scope="col">Mark-Up Recovered Till Date</th>
                <th scope="col">Markup Recoverable A/C (5008)</th>
                <th scope="col">Markup Reserve A/C (2305)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->markup_details as $co)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{\Carbon\Carbon::parse($co->date)->format('d-M-Y')}}</td>
                    <td>{{$co->markup_receivable_4600}}</td>
                    <td>{{$co->markup_recovered_till_date}}</td>
                    <td>{{$co->markup_recovered_ac_5008}}</td>
                    <td>{{$co->markup_recovered_ac_2405}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
@endsection


@section('customFooterScripts')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function (event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })

    </script>
@endsection

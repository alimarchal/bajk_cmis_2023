@extends('theme.main')
@section('breadcrumb')
    Borrower Profile / Interest
@endsection
@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    <form method="post" action="{{route('interest.store', $customer->id)}}">
        @csrf
        @include('theme.customer')

        <br>

        <div class="form-row">


            <div class="col-md-3 mb-2">
                <label for="date"><strong>Date</strong></label>
                <input type="date" required class="form-control" id="date" name="date">
            </div>

            <div class="col-md-3 mb-2">
                <label for="date"><strong>KIBOR / Fixed</strong></label>
                <input disabled class="form-control" value="@if($customer->kibor_or_fixed == "1") KIBOR @else Fixed @endif">
            </div>


            @if($customer->kibor_or_fixed == "1")
                <div class="col-md-3 mb-3">
                    <label for="kibor"><strong>KIBOR Rate</strong></label>
                    <input type="number" step="0.01" min="0.00" value="0.00" class="form-control" id="kibor" required name="kibor">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="bank_spread"><strong>Bank Spread Rate</strong></label>
                    <input type="number" step="0.01" min="0.00" class="form-control" value="0.00" id="bank_spread" required name="bank_spread">
                </div>
            @else
                <div class="col-md-3 mb-3">
                    <label for="bank_spread"><strong>Bank Spread Rate</strong></label>
                    <input type="number" step="0.01" min="0.00" class="form-control" value="0.00" id="bank_spread" required name="bank_spread">
                </div>
            @endif

        </div>
        <button class="btn btn-primary float-right" type="submit">Save</button>
    </form>


    <br>
    @if($customer->interest->isNotEmpty())
        <h2 class="text-center" style="border-top: 1px solid red; border-bottom: 1px solid red; padding: 10px; margin-bottom: 30px; margin-top: 30px;">
            Interest Rate</h2>
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">KIBOR / Fixed</th>
                <th scope="col">KIBOR</th>
                <th scope="col">Bank Spread </th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->interest as $co)
                <tr>
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{\Carbon\Carbon::parse($co->date)->format('d-m-Y')}}</td>
                    <td>@if($customer->kibor_or_fixed == "1") KIBOR @else Fixed @endif</td>
                    <td>{{number_format($co->kibor,2)}}</td>
                    <td>{{number_format($co->bank_spread,2)}}</td>
                    <td>{{number_format($co->total,2)}}</td>

                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
@endsection


@section('customFooterScripts')
    <script>


        $(document).ready(function () {
            $principal_amount = 0;
            $mark_up_amount = 0;
            $penalty_charges = 0;
            $total_principal_markup_penalty = 0;

            $("#principal_amount").change(function () {

                $principal_amount = parseFloat($(this).val(), 2);
                $mark_up_amount = parseFloat($("#mark_up_amount").val(), 2);
                $penalty_charges = parseFloat($("#penalty_charges").val(), 2);

                $total_principal_markup_penalty = $principal_amount + $mark_up_amount + $penalty_charges;

                $("#total_principal_markup_penalty").val(parseFloat($total_principal_markup_penalty));
            });


            $("#mark_up_amount").change(function () {

                $principal_amount = parseFloat($("#principal_amount").val(), 2);
                $mark_up_amount = parseFloat($(this).val(), 2);
                $penalty_charges = parseFloat($("#penalty_charges").val(), 2);

                $total_principal_markup_penalty = $principal_amount + $mark_up_amount + $penalty_charges;

                $("#total_principal_markup_penalty").val(parseFloat($total_principal_markup_penalty));
            });


            $("#penalty_charges").change(function () {

                $principal_amount = parseFloat($("#principal_amount").val(), 2);
                $mark_up_amount = parseFloat($("#mark_up_amount").val(), 2);
                $penalty_charges = parseFloat($(this).val(), 2);

                $total_principal_markup_penalty = $principal_amount + $mark_up_amount + $penalty_charges;

                $("#total_principal_markup_penalty").val(parseFloat($total_principal_markup_penalty));
            });


            $("#days_passed_overdue").change(function () {

                $days_passed_overdue = parseFloat($(this).val(), 0);
                if ($days_passed_overdue <= 30) {
                    $("#category_of_default").val('Regular');
                } else if ($days_passed_overdue > 30 && $days_passed_overdue <= 90) {
                    $("#category_of_default").val('Irregular');
                } else if ($days_passed_overdue >= 90 && $days_passed_overdue <= 180) {
                    $("#category_of_default").val('Doubtful');
                } else if ($days_passed_overdue > 180) {
                    $("#category_of_default").val('Loss');
                }

            });


            // $kibor_value = 0
            // $bank_spread_rate = 0
            // $total_value = $kibor_value + $bank_spread_rate;
            //
            // $("#kibor_rate").change(function() {
            //     $kibor_value = parseFloat($(this).val(),2);
            //     $bank_spread_rate = parseFloat($("#bank_spread_rate").val());
            //     $total_value = $kibor_value + $bank_spread_rate;
            //     $("#mark_up_rate").val(parseFloat($total_value));
            // });
            //
            // $("#bank_spread_rate").change(function() {
            //
            //     $bank_spread_rate = parseFloat($(this).val(),2);
            //     $kibor_value = parseFloat($("#kibor_rate").val());
            //     $total_value = $kibor_value + $bank_spread_rate;
            //     $("#mark_up_rate").val(parseFloat($total_value));
            //     // alert($total_value);
            // });
        });

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

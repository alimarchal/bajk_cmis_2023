@extends('theme.main')
@section('mainTitle')

@endsection
@section('breadcrumb')
    Borrowers
@endsection

@section('customHeaderScripts')
    <style>

        @media print {
            .table thead tr td, .table tbody tr td {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                /*padding:0px;*/
                -webkit-print-color-adjust: exact;
            }

            table.table-bordered > thead > tr > th {
                border: 1px solid #000 !important;
            }

            .rows-print-as-pages {
                page-break-before: always !important;
            }

        }


        @media screen {
            table.table-bordered {
                border: 1px solid #000;
            }

            table.table-bordered > thead > tr > th {
                border: 1px solid #000;
            }

            table.table-bordered > tbody > tr > td {
                border: 1px solid #000;
            }
        }

    </style>
@endsection

@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif


    <form method="get" action="{{route('report.creditGrowthPercentageShare')}}">
        <div class="filters" style="display:none;">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="month">Month</label>
                    <input type="date" class="form-control" id="month" name="month" value="{{ empty(request()->date) ? '' : request()->date }}">
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <button type="button" class="btn btn-danger hideModule" data-target="filters">Hide Filters
                    </button>
                </div>
            </div>
        </div>
        <div class="row d-print-none">
            <div class="col-md-12 p-3">
                <a href="javascript:;" class="btn btn-primary showModule float-right" data-target="filters">
                    Show Filters</a>
                {{--                <input type="submit" name="search" value="Export" class="btn btn-success float-right mr-2">--}}
            </div>
        </div>
    </form>
    {{--sss | {{ request()->input('filter[search_string]', old('filter[search_string]')) }}--}}

    <img class="w-48 h-auto" src="{{Storage::url('logo.png')}}" alt="Bank AJK Logo">
    <div class="col-md-12 d-print-none">
        <button onclick="window.print()" class="btn btn-success d-print-none float-right">
            <i class="fa fa-print" aria-hidden="true"></i>
        </button>
    </div>
    <h5 class="text-center font-weight-bold">The Bank of Azad Jammu & Kashmir
        <br> Percentage Share in Total Portfolio ({{$month->format('F - Y')}})
    </h5>
    <br>

    <table class="table table-bordered  ">
        <thead>
        <tr>
            <th scope="col" class="align-middle text-center" width="0.1%">S.No</th>
            <th scope="col" class="align-middle text-center" >Product</th>
            <th scope="col" class="align-middle text-center" >Amount</th>
            <th scope="col" class="align-middle text-center"  > % Share</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1; $percentage_total = 0;@endphp
        @foreach($data as $key => $value)
            <tr>
                <td class="text-center">{{$i}}</td>
                <td class="text-left">{{$key}}</td>
                <td class="text-right">{{number_format($value['amount'],2)}}</td>
                <td class="text-right">
                    @if($total_share <= 0)
                        0.00%
                    @else
                        {{round(($value['amount']/$total_share) * 100,2)}}%
                        @php $percentage_total = $percentage_total + (($value['amount']/$total_share) * 100); @endphp
                    @endif

                </td>
            </tr>
        @php $i++; @endphp
        @endforeach

        <tr class="font-weight-bold">
            <td class="text-center" colspan="2">Total</td>
            <td class="text-right">{{number_format($total_share,2)}}</td>
            <td class="text-right">{{number_format(round($percentage_total,2),2)}}%</td>
        </tr>

        </tbody>

    </table>



    <br>

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

            $(document).ready(function () {
                $(".showModule").click(function () {
                    $("." + $(this).data("target")).slideDown("slow");
                    $(this).hide()
                });
                $(".hideModule").click(function () {
                    $("." + $(this).data("target")).slideUp("slow");
                    $('.showModule').show()
                });
            });
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

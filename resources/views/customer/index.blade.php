@extends('theme.main')
@section('mainTitle')

@endsection
@section('breadcrumb')
    Borrowers
@endsection

@section('customHeaderScripts')
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css"  rel="stylesheet"/>--}}
    {{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>--}}
    {{--<link rel="stylesheet" href="{{url('AdminLTE/plugins/select2/css/select2.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{url('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">--}}
    <style>

        @media print {
            .table thead tr td,.table tbody tr td{
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                /*padding:0px;*/
                -webkit-print-color-adjust:exact ;
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


    <form method="get" action="{{route('customer.index')}}">
        <div class="filters"  style="display:none;">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search">Search</label>
                    <input type="text" class="form-control" id="search" name="filter[search_string]" value="{{ empty(request()->filter['search_string']) ? '' : request()->filter['search_string'] }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="cnic">CNIC</label>
                    <input type="text" class="form-control" id="cnic" name="filter[customer_cnic]" value="">
                </div>
                <div class="form-group col-md-3">
                    <label for="account_no">Account No</label>
                    <input type="text" class="form-control" id="account_no" name="filter[account_cd_saving]" value="">
                </div>
                <div class="form-group col-md-3">
                    <label for="manual_account">Manual Account No</label>
                    <input type="text" class="form-control" id="manual_account" name="filter[manual_account]" value="">
                </div>
                <div class="form-group col-md-3">
                    <label for="gender">Gender</label>
                    <select class="form-control select2bs4" id="gender" name="filter[gender]" style="width:100%">
                        <option value="">None</option>
                        <option value="Male" >Male</option>
                        <option value="Female" >Female</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="status">Adjusted/Non-Adjusted</label>
                    <select class="form-control select2bs4" id="status" name="filter[status]" style="width:100%">
                        <option value="">None</option>
                        <option value="0" >Adjusted</option>
                        <option value="1" >Non-Adjusted</option>
                    </select>
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
        <div class="row">
            <div class="col-md-12 p-3">
                <a href="javascript:;" class="btn btn-primary showModule float-right" data-target="filters">
                    Show Filters</a>
{{--                <input type="submit" name="search" value="Export" class="btn btn-success float-right mr-2">--}}
            </div>
        </div>
    </form>
{{--sss | {{ request()->input('filter[search_string]', old('filter[search_string]')) }}--}}


    <h3 class="text-center">The Bank of Azad Jammu & Kashmir</h3>
    <br>

@if($customers->isNotEmpty())
<table class="table table-bordered ">
   <thead>
   <tr>
       <th scope="col">#</th>
       <th scope="col">Name</th>
       <th scope="col">CNIC</th>
       <th scope="col">AC Number</th>
       <th scope="col">Facility</th>
       <th scope="col">Type</th>
       <th scope="col">Branch</th>
       <th scope="col" class="text-center">Action</th>
       <th scope="col" class="text-center">Installment</th>
   </tr>
   </thead>
   <tbody>
   @foreach($customers as $customer)
       <tr>
           <td scope="row"><strong>{{$loop->iteration}}</strong></td>
                <td>
                    <a href="{{route('customer.profile',$customer->id)}}">{{ucwords(strtolower($customer->name))}}</a>
                </td>
                <td>{{$customer->customer_cnic}}</td>
                <td>{{$customer->branch->code}}-{{$customer->account_cd_saving}}</td>
                <td>{{$customer->product_type->product_type}}</td>
                <td>{{$customer->secure_unsecure_loan}}</td>
                <td>{{$customer->branch->name}}</td>
                <td class="text-center">
                    <a href="{{route('customer.show', $customer->id)}}">
                        <span class="fas fa-edit"></span>
                    </a>
                </td>

               <td class="text-center">
                   <a href="{{route('installment.index', $customer->id)}}">
                       <span class="fas fa-money-bill"></span>
                   </a>
               </td>
            </tr>
        @endforeach
        </tbody>


    </table>
    @endif
    {{$customers->links()}}
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

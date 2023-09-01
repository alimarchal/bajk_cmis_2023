@extends('theme.main')
@section('mainTitle')
@endsection
@section('breadcrumb')
    Borrower Profile
@endsection

@section('customHeaderScripts')
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

@section('customHeaderScripts')
    {{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css"  rel="stylesheet"/>--}}
    {{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>--}}
    {{--<link rel="stylesheet" href="{{url('AdminLTE/plugins/select2/css/select2.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{url('AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">--}}
@endsection

@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    {{--    @include('theme.customer')--}}

    <div class="row ">
        <div class="col-md-12">
            <h4 class="text-center mt-2">
                The Bank of Azad Jammu and Kashmir<br>
                Credit Management Division <br>
                Head Office, Muzaffarabad<br>
                Branch: {{$customer->branch->code}} -
                Branch: {{$customer->branch->name}}
            </h4>
            @php date_default_timezone_set("Asia/Karachi"); @endphp
            <p style="float: right"><span class="font-weight-bold">Printed On:</span> {{date('d/m/Y h:i:sa')}}

                <button onclick="window.print()"  class="d-print-none">
                    <i class="fa fa-print" aria-hidden="true"></i>
                </button>

            </p>

        </div>
    </div>


    <table class="table table-bordered">

        <tbody>

        <tr>
            <td colspan="8" class="text-center font-weight-bold">Borrower Profile</td>
        </tr>
        <tr>
            <td  class="font-weight-bold">Region</td>
            <td  colspan="2">{{$customer->branch->region}}</td>
            <td class="font-weight-bold">Zone</td>
            <td  colspan="3">{{$customer->branch->zone}}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">District</td>
            <td  colspan="2">{{$customer->branch->district}}</td>
            <td class="font-weight-bold">Branch</td>
            <td  colspan="3">{{$customer->branch->code}}-{{$customer->branch->name}}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">Name</td>
            <td colspan="2">{{ucwords(strtolower($customer->name))}}</td>
            <td class="font-weight-bold">So/Do/Wo</td>
            <td>{{ucwords(strtolower($customer->son_daughter_wife))}}</td>
            <td class="font-weight-bold">Gender</td>
            <td >{{ucwords(strtolower($customer->gender))}}</td>

        </tr>

        <tr>
            <td class="font-weight-bold">Business/Department/Profession</td>
            <td colspan="3">{{ucwords(strtolower($customer->business_department_profession))}}</td>
            <td class="font-weight-bold" >Designation</td>
            <td  colspan="2">{{ucwords(strtolower($customer->designation))}}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">PP Number</td>
            <td colspan="3">{{$customer->pp_number}}</td>
            <td class="font-weight-bold">Date of Birth</td>
            <td colspan="2">{{\Carbon\Carbon::parse($customer->date_of_birth)->format('d-m-Y')}}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">Office/Business Address</td>
            <td colspan="6">{{ucwords(strtolower($customer->office_business_address))}}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">Present Address</td>
            <td colspan="6">{{ucwords(strtolower($customer->present_address))}}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">Permanent Address</td>
            <td colspan="6">{{ucwords(strtolower($customer->permanent_address))}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">CNIC</td>
            <td colspan="3" >{{$customer->customer_cnic}}</td>
            <td class="font-weight-bold">Contact Number</td>
            <td  colspan="2" >{{$customer->customer_contact_number}}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Ac Number/CD/Saving</td>
            <td colspan="3">{{$customer->account_cd_saving}}</td>
            <td class="font-weight-bold">Manual Account No</td>
            <td colspan="3">{{$customer->manual_account}}</td>
        </tr>


        <tr>
            <td colspan="8" class="text-center font-weight-bold">Facility Detail</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Nature of facility Availed</td>
            <td  colspan="3">{{ucwords(strtolower($customer->product->product_name))}}</td>
            <td class="font-weight-bold">Type of facility approved</td>
            <td colspan="3">{{ucwords(strtolower($customer->product_type->product_type))}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Renewal/Enhancement</td>
            <td  colspan="3">{{ucwords(strtolower($customer->renewal_enhancement_fresh_sanction))}}</td>
            <td class="font-weight-bold">Amount Sanctioned</td>
            <td colspan="3">{{ucwords(strtolower($customer->amount_sanctioned))}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Amount Enhanced (if any)</td>
            <td  colspan="3">{{$customer->amount_enhanced}}</td>
            <td class="font-weight-bold">Sanctioned Date</td>
            <td colspan="3">{{\Carbon\Carbon::parse($customer->sanction_date)->format('d-m-Y')}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Tenure of Loan in Months</td>
            <td  colspan="3">{{$customer->tenure_of_loan_in_months}}</td>
            <td class="font-weight-bold">Installment Type</td>
            <td colspan="3">{{$customer->installment_type}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">No of Installment</td>
            <td  colspan="3">{{$customer->no_of_installments}}</td>
            <td class="font-weight-bold">DAC Issuance Date</td>
            <td colspan="3">{{ $customer->dac_issuance_date }}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">DAC Disbursement Date</td>
            <td  colspan="3">{{\Carbon\Carbon::parse($customer->disbursement_date)->format('d-m-Y')}}</td>
            <td class="font-weight-bold">Amount Disbursed</td>
            <td colspan="3">{{$customer->amount_disbursed}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Expiry Date as per DAC</td>
            <td  colspan="3">{{\Carbon\Carbon::parse($customer->expiry_date_as_per_dac)->format('d-m-Y')}}</td>
            <td class="font-weight-bold">Facility (Secure/Unsecure Principal)</td>
            <td colspan="3">{{ucwords(strtolower($customer->secure_unsecure_loan))}}</td>
        </tr>

        <tr>
            <td  class="font-weight-bold">Branch Manager/Credit Officer</td>
            <td  colspan="3">{{ucwords(strtolower($customer->branch_manager_name_while_sanctioning))}}</td>
            <td  class="font-weight-bold">KIBOR/FIXED</td>
            <td  colspan="3">

                @if($customer->kibor_or_fixed == 0)
                    Fixed
                @elseif($customer->kibor_or_fixed == 1)
                    KIBOR
                @endif
            </td>

        </tr>

        <tr>

            <td  class="font-weight-bold">Total Markup Rate (KIBOR+SPREAD)</td>
            <td  colspan="3">{{number_format($customer->kibor_rate,2)}} + {{number_format($customer->bank_spread_rate,2)}} = {{number_format($customer->kibor_rate+$customer->bank_spread_rate,2)}}</td>
            <td  class="font-weight-bold">Principal Outstanding</td>
            <td  colspan="3">{{number_format($customer->principle_amount,2)}}</td>
        </tr>




        </tbody>
    </table>





    @if($customer->other_guarantee->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th colspan="6" class="text-center font-weight-bold">Security</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Primary</th>
                <th scope="col">Secondary</th>
                <th scope="col">Ownership</th>
                <th scope="col">Market Value</th>
                <th scope="col">FSV</th>
                <th scope="col">Description</th>
            </tr>
            </thead>

            <tbody>
            @foreach($customer->other_guarantee as $og)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$og->primary}}</td>
                    <td>{{$og->secondary}}</td>
                    <td>{{$og->ownership}}</td>
                    <td>{{$og->market_value}}</td>
                    <td>{{$og->fsv}}</td>
                    <td>{{$og->Remarks}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if($customer->guarantee->isNotEmpty())
        <table class="table table-bordered border-collapse rows-print-as-pages" >
            <thead>
            <tr>
                <th colspan="9" class="text-center font-weight-bold">Personal Guarantee</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">CNIC</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Department/Business</th>
                <th scope="col">Business/Dept/Address</th>
                <th scope="col">Address</th>
                <th scope="col">BPS</th>
                <th scope="col">PP#</th>
            </tr>
            </thead>

            <tbody style="font-size: 12px;">
            @foreach($customer->guarantee as $og)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$og->name}}</td>
                    <td>{{$og->cnic}}</td>
                    <td>{{$og->contact}}</td>
                    <td>{{$og->department_business}}</td>
                    <td>{{$og->business_department_address}}</td>
                    <td>{{$og->guarantor_address}}</td>
                    <td>{{$og->bps}}</td>
                    <td>{{$og->pp_no}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif



    @if($customer->insurance->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>

            <tr>
                <th colspan="6" class="text-center font-weight-bold">Insurance</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Insurance Company</th>
                <th scope="col">Date of Insurance</th>
                <th scope="col">Insured Amount</th>
                <th scope="col">Date of Expiry of Insurance</th>
                <th scope="col">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->insurance as $inu)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$inu->insurance_company}}</td>
                    <td>{{ $inu->date_of_insurance }}</td>
                    <td>{{$inu->insurance_amount}}</td>
                    <td>{{ $inu->date_of_expiry_of_insurance }}</td>
                    <td>{{$inu->remarks}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif


    @if($customer->insurance->isNotEmpty())

        <table class="table table-bordered border-collapse ">
            <thead>

            <tr>
                <th colspan="6" class="text-center font-weight-bold">Claim Outstanding</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Insurance Company</th>
                <th scope="col">Claim Amount</th>
                <th scope="col">Date of Claim</th>
                <th scope="col">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->claim_outstanding as $co)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{\App\Models\Insurance::find($co->insurance_id)->insurance_company}}</td>
                    <td>{{$co->claim_amount}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date_of_claim)->format('d-m-Y')}}</td>
                    <td>{{$co->remarks}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif


    @if($customer->valuation->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th colspan="6" class="text-center font-weight-bold">Valuation</th>
            </tr>
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
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$co->evaluator_company}}</td>
                    <td>{{$co->date_of_valuation}}</td>
                    <td>{{$co->date_of_valuation_expiry }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif


    @if($customer->litigation->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th colspan="6" class="text-center font-weight-bold">Litigation Status</th>
            </tr>
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
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$co->name_of_court}}</td>
                    <td>{{$co->recovery_status}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date_of_final_settlement)->format('d-m-Y')}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif


    @if($customer->installments->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th colspan="9" class="text-center font-weight-bold">Installments</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Principal</th>
                <th scope="col">Mark-Up</th>
                <th scope="col">Penalty</th>
                <th scope="col">Insurance</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->installments as $co)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date)->format('d-M-Y')}}</td>
                    <td>{{$co->principal_amount}}</td>
                    <td>{{$co->mark_up_amount}}</td>
                    <td>{{$co->penalty_charges}}</td>
                    <td>{{$co->penalty_charges}}</td>
                    <td>{{$co->insurance_charges}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif


    @if($customer->markup_details->isNotEmpty())
        <table class="table table-bordered border-collapse">
            <thead>
            <tr>
                <th colspan="6" class="text-center font-weight-bold">Mark-Up Details</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Mark-Up Receivable (4600)</th>
                <th scope="col">Mark-Up Recovered Till Date</th>
                <th scope="col">Mark-Up Recoverable A/C (5008)</th>
                <th scope="col">Mark-Up Reserve A/C (2305)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customer->markup_details as $co)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{\Carbon\Carbon::parse($co->date)->format('d-m-Y')}}</td>
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

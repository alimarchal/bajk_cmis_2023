@extends('theme.main')
@section('breadcrumb')
    test
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

    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('theme.generalCustomer')

    <form method="post" action="{{route('customer.store')}}">
        @csrf
        <br>
        {{--                @livewire('branch-list')--}}

        <div class="form-row">
            <div class="col-md-12 mb-2">
                <label for="branch"><strong>Please select branch</strong></label>
                <select class="form-control select2bs4" id="branch_id" style="width: 100%;" name="branch_id" required>
                    @if (Auth::user()->hasRole(['Credit Officer', 'Branch Manager']))
                        @foreach(\App\Models\Branch::where('id',auth()->user()->branch_id)->get() as $branch)
                            <option selected value="{{$branch->id}}">{{$branch->code}} - {{$branch->region}} - {{$branch->district}} - {{$branch->name}}</option>
                        @endforeach
                    @elseif (Auth::user()->hasRole('South Regional MIS Officer'))
                        @foreach(\App\Models\Branch::where('region','South Region')->get() as $branch)
                            <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->region}} - {{$branch->district}} - {{$branch->name}}</option>
                        @endforeach
                    @elseif (Auth::user()->hasRole('North Regional MIS Officer'))
                        @foreach(\App\Models\Branch::where('region','North Region')->get() as $branch)
                            <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->region}} - {{$branch->district}} - {{$branch->name}}</option>
                        @endforeach
                    @elseif (Auth::user()->hasRole(['Head Office', 'Super-Admin']))
                        @foreach(\App\Models\Branch::all() as $branch)
                            <option value="{{$branch->id}}">{{$branch->code}} - {{$branch->region}} - {{$branch->district}} - {{$branch->name}}</option>
                        @endforeach
                    @endif

                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-3 mb-2">
                <label for="name"><strong>Name</strong> <span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required>
                <div class="invalid-feedback">
                    Please provide a name.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="son_daughter_wife"><strong>So/Do/Wo</strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="son_daughter_wife" value="{{ old('son_daughter_wife') }}" required name="son_daughter_wife">
                <div class="invalid-feedback">
                    Please provide a So/Do/Wo.
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <label for="gender"><strong>Gender</strong> <span class="text-danger">*</span></label>
                <select class="form-control select2bs4" required id="gender" style="width: 100%;" name="gender">
                    <option value="">None</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <div class="invalid-feedback">
                    Please select a Gender.
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <label for="business_department_profession"><strong>Business/Department/Profession</strong> <span class="text-danger">*</span></label>
                <input name="business_department_profession" class="form-control" id="business_department_profession"
                       required value="{{ old('business_department_profession') }}">
                <div class="invalid-feedback">
                    Please provide a Business/Department/Profession.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="designation"><strong>Designation </strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="designation" title="" name="designation" required
                       value="{{ old('designation') }}">
                <div class="invalid-feedback">
                    Please provide a Designation.
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="pp_number"><strong>PP / Employee No</strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="pp_number" name="pp_number" required
                       value="{{ old('pp_number') }}">
                <div class="invalid-feedback">
                    Please provide a PP / Employee No.
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="date_of_birth"><strong>Date of Birth</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required
                       value="{{ old('date_of_birth') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="office_business_address"><strong>Office/Business Address</strong> <span class="text-danger">*</span></label>
                <input class="form-control" id="office_business_address" required
                       name="office_business_address" value="{{ old('office_business_address') }}">
            </div>

            <div class="col-md-3 mb-2">
                <label for="present_address"><strong>Present Address</strong> <span class="text-danger">*</span></label>
                <input class="form-control" id="present_address" required
                       name="present_address" value="{{ old('present_address') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="permanent_address"><strong>Permanent Address</strong> <span class="text-danger">*</span></label>
                <input class="form-control" id="permanent_address" required
                       name="permanent_address" value="{{ old('permanent_address') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="cnic"><strong>CNIC</strong> <span class="text-danger">*</span></label>
                <input type="text" name="customer_cnic" class="form-control" data-inputmask='"mask": "99999-9999999-9"' data-mask id="cnic"
                       value="{{ old('customer_cnic') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="customer_contact_number"><strong>Contact Number</strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="customer_contact_number" data-inputmask='"mask": "9999-9999999"' data-mask required name="customer_contact_number"
                       value="{{ old('customer_contact_number') }}">
            </div>

            <div class="col-md-3 mb-2">
                <label for="account_cd_saving"><strong>Ac Number/CD/Saving</strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="account_cd_saving" required name="account_cd_saving"
                       value="{{ old('account_cd_saving') }}">
            </div>

            <div class="form-group col-md-3">
                <label for="manual_account">Manual Account No</label>
                <input type="text" class="form-control" id="manual_account" name="manual_account" value="{{ old('manual_account') }}">
            </div>

        </div>


        <hr class="bg-danger">
        <h2 class="text-danger text-center">Facility Detail</h2>
        <hr class="bg-danger">

        @livewire('facility')


        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="sanction_date"><strong>Sanctioned Date</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="sanction_date" required name="sanction_date"
                       value="{{ old('sanction_date') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="tenure_of_loan_in_months"><strong>Tenure of Loan in Months</strong> <span class="text-danger">*</span></label>
                <select class="form-control select2bs4" required id="tenure_of_loan_in_months" style="width: 100%;" name="tenure_of_loan_in_months">
                    <option value="">None</option>
                    @for($i = 1; $i <= 60; $i++)
                        <option value="{{$i}}" {{ old('tenure_of_loan_in_months') == $i ? 'selected' : '' }}>{{$i}} Months</option>
                    @endfor
                </select>
            </div>


            <div class="col-md-3 mb-3">
                <label for="installment_type"><strong>Installment Type</strong> <span class="text-danger">*</span></label>
                <select class="form-control select2bs4" required id="installment_type" style="width: 100%;" name="installment_type">
                    <option value="">None</option>
                    <option value="Monthly" {{ old('installment_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Quarterly" {{ old('installment_type') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="Half Yearly" {{ old('installment_type') == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                    <option value="Lump sump" {{ old('installment_type') == 'Lump sump' ? 'selected' : '' }}>Lump sump</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="emi_amount"><strong>Installment Amount</strong> <span class="text-danger">*</span></label>
                <input type="number" class="form-control" step="0.01" min="0" id="emi_amount" required name="emi_amount"
                       value="{{ old('emi_amount') }}">
            </div>


            {{--            <div class="col-md-3 mb-3">--}}
            {{--                <label for="no_of_installments"><strong>No of Installment</strong></label>--}}
            {{--                <select class="form-control select2bs4" required id="no_of_installments" style="width: 100%;" name="no_of_installments">--}}
            {{--                    <option value="">None</option>--}}
            {{--                    @for($i = 1; $i <= 240; $i++)--}}
            {{--                        <option value="{{$i}}">{{$i}}</option>--}}
            {{--                    @endfor--}}
            {{--                </select>--}}
            {{--            </div>--}}


            <div class="col-md-3 mb-3">
                <label for="dac_issuance_date"><strong>DAC Issuance Date</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="dac_issuance_date" required
                       name="dac_issuance_date" value="{{ old('dac_issuance_date') }}">
                <div class="invalid-feedback">
                    Please provide a DAC Issuance Date.
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="loan_due_date"><strong> Installment Due Date</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="loan_due_date" required
                       name="loan_due_date" value="{{ old('loan_due_date') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="disbursement_date"><strong>DAC Disbursement Date</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="disbursement_date" required
                       name="disbursement_date" value="{{ old('disbursement_date') }}">
                <div class="invalid-feedback">
                    Please provide a DAC Disbursement Date.
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="amount_disbursed"><strong>Amount Disbursed</strong> <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="amount_disbursed" required
                       name="amount_disbursed" value="{{ old('amount_disbursed') }}">
                <div class="invalid-feedback">
                    Please provide an Amount Disbursed.
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="expiry_date_as_per_dac"><strong>Expiry Date as per DAC</strong> <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="expiry_date_as_per_dac" required
                       name="expiry_date_as_per_dac" value="{{ old('expiry_date_as_per_dac') }}">
                <div class="invalid-feedback">
                    Please provide a Sanctioned Date.
                </div>
            </div>

            <div class="col-md-3 mb-2">
                <label for="kibor_or_fixed"><strong>KIBOR / Fixed</strong></label>
                <select class="form-control select2bs4" required id="kibor_or_fixed" style="width: 100%;" name="kibor_or_fixed">
                    <option value="">None</option>
                    <option value="1" {{ old('kibor_or_fixed') == '1' ? 'selected' : '' }}>KIBOR</option>
                    <option value="0" {{ old('kibor_or_fixed') == '0' ? 'selected' : '' }}>Fixed</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="kibor_rate"><strong>KIBOR Rate</strong></label>
                <input type="number" step="0.01" min="0.00" value="0.00" class="form-control" id="kibor_rate" required name="kibor_rate"
                       value="{{ old('kibor_rate') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="bank_spread_rate"><strong>Bank Spread Rate</strong></label>
                <input type="number" step="0.01" min="0.00" class="form-control" value="0.00" id="bank_spread_rate" required name="bank_spread_rate"
                       value="{{ old('bank_spread_rate') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="mark_up_rate"><strong>Markup Rate <sub>(KIBOR+SPREAD)</sub> </strong></label>
                <input type="number" step="0.01" min="0.00" class="form-control" id="mark_up_rate" readonly required name="mark_up_rate"
                       value="{{ old('mark_up_rate') }}">
            </div>

            <div class="col-md-3 mb-2">
                <label for="secure_unsecure_loan"><strong>Facility (Secure/Unsecure Principal)</strong></label>
                <select class="form-control select2bs4" required id="secure_unsecure_loan" style="width: 100%;" name="secure_unsecure_loan">
                    <option value="">None</option>
                    <option value="Secure" {{ old('secure_unsecure_loan') == 'Secure' ? 'selected' : '' }}>Secure Principal</option>
                    <option value="Unsecure" {{ old('secure_unsecure_loan') == 'Unsecure' ? 'selected' : '' }}>Unsecure Principal</option>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="branch_manager_name_while_sanctioning"><strong>Sanctioning (Branch Manager)</strong></label>
                <input type="text" class="form-control" id="branch_manager_name_while_sanctioning" required
                       name="branch_manager_name_while_sanctioning" value="{{ old('branch_manager_name_while_sanctioning') }}">
            </div>


            <div class="col-md-3 mb-3">
                <label for="principle_amount"><strong>Principal Outstanding</strong></label>
                <input type="number" step="0.01" class="form-control" id="principle_amount" required
                       name="principle_amount" value="{{ old('principle_amount') }}">
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save & Next</button>
    </form>
@endsection


@section('customFooterScripts')
    <script src="https://emis.ajk.gov.pk/assets/js/jquery.mask.js" defer></script>
    <script>

        $(document).ready(function () {
            $kibor_value = 0
            $bank_spread_rate = 0
            $total_value = $kibor_value + $bank_spread_rate;

            $("#kibor_rate").change(function () {
                $kibor_value = parseFloat($(this).val(), 2);
                $bank_spread_rate = parseFloat($("#bank_spread_rate").val());
                $total_value = $kibor_value + $bank_spread_rate;
                $("#mark_up_rate").val(parseFloat($total_value));
            });

            $("#bank_spread_rate").change(function () {

                $bank_spread_rate = parseFloat($(this).val(), 2);
                $kibor_value = parseFloat($("#kibor_rate").val());
                $total_value = $kibor_value + $bank_spread_rate;
                $("#mark_up_rate").val(parseFloat($total_value));
                // alert($total_value);
            });
        });

        $(document).ready(function () {
            $('.select2').select2();
            $('.cnic_mask').mask('00000-0000000-0');
            $('.number_mask').mask('0000-0000000');
            $('.phone_mask').mask('00000-000000');
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

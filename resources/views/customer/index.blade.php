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
            .table thead tr td, .table tbody tr td {
                border-width: 1px !important;
                border-style: solid !important;
                border-color: black !important;
                /*padding:0px;*/
                -webkit-print-color-adjust: exact;
            }

            a.print_on_screen {
                text-decoration: none;
                color: black;
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


    <link rel="stylesheet" href="https://cms.ajkced.gok.pk/daterange/daterangepicker.min.css">
{{--    <script src="https://cms.ajkced.gok.pk/daterange/jquery-3.6.0.min.js"></script>--}}
    <script src="https://cms.ajkced.gok.pk/daterange/moment.min.js"></script>
    <script src="https://cms.ajkced.gok.pk/daterange/knockout-3.5.1.js" defer></script>
    <script src="https://cms.ajkced.gok.pk/daterange/daterangepicker.min.js" defer></script>
@endsection

@section('body')
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif


    <form method="get" action="{{route('customer.index')}}">
        <div class="filters" style="display:none;">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="search">Search</label>
                    <input type="text" class="form-control" id="search" name="filter[search_string]" value="{{ request()->input('filter.search_string') }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="cnic">CNIC</label>
                    <input type="text" class="form-control" id="cnic" name="filter[customer_cnic]" value="{{ request()->input('filter.customer_cnic') }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="guarantee_cnic">Guarantor CNIC</label>
                    <input type="text" class="form-control" id="guarantee_cnic" name="filter[guarantee.cnic]" value="{{ old('filter.guarantee.cnic', isset($_GET['filter']['guarantee.cnic']) ? $_GET['filter']['guarantee.cnic'] : '') }}">
                </div>


                <div class="form-group col-md-3">
                    <label for="account_no">Account No</label>
                    <input type="text" class="form-control" id="account_no" name="filter[account_cd_saving]" value="{{ request()->input('filter.account_cd_saving') }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="manual_account">Manual Account No</label>
                    <input type="text" class="form-control" id="manual_account" name="filter[manual_account]" value="{{ request()->input('filter.manual_account') }}">
                </div>

                <div class="form-group col-md-3">
                    <label for="product_type_id">Facility Type</label>
                    <select class="form-control select2bs4" id="product_type_id" name="filter[product_type_id]" style="width:100%">
                        <option value="">None</option>
                        @php
                            $selectedProductType = request()->input('filter.product_type_id');
                            $productTypes = \App\Models\ProductType::groupBy('product_type')->orderBy('product_type', 'asc')->get();
                        @endphp
                        @foreach($productTypes as $product_type)
                            <option value="{{ $product_type->id }}" {{ $selectedProductType == $product_type->id ? 'selected' : '' }}>
                                {{ $product_type->product_type }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-3">
                    <label for="gender">Gender</label>
                    <select class="form-control select2bs4" id="gender" name="filter[gender]" style="width:100%">
                        <option value="">None</option>
                        @php
                            $selectedGender = request()->input('filter.gender');
                        @endphp
                        <option value="Male" {{ $selectedGender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $selectedGender === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>


                <div class="form-group col-md-3">
                    <label for="status">Adjusted/Non-Adjusted</label>
                    <select class="form-control select2bs4" id="status" name="filter[status]" style="width:100%">
                        <option value="">None</option>
                        @php
                            $selectedStatus = request()->input('filter.status');
                        @endphp
                        <option value="0" {{ $selectedStatus === '0' ? 'selected' : '' }}>Adjusted</option>
                        <option value="1" {{ $selectedStatus === '1' ? 'selected' : '' }}>Non-Adjusted</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="per_page_count">Pages</label>
                    <select class="form-control select2bs4" id="per_page_count" name="per_page_count" style="width:100%">
                        <option value="">None</option>
                        <option value="20" {{ request()->input('per_page_count') === '20' ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request()->input('per_page_count') === '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request()->input('per_page_count') === '100' ? 'selected' : '' }}>100</option>
                        <option value="500" {{ request()->input('per_page_count') === '500' ? 'selected' : '' }}>500</option>
                        <option value="1000" {{ request()->input('per_page_count') === '1000' ? 'selected' : '' }}>1000</option>
                        <option value="10000" {{ request()->input('per_page_count') === '10000' ? 'selected' : '' }}>10000</option>
                        <option value="100000" {{ request()->input('per_page_count') === '100000' ? 'selected' : '' }}>100000</option>
                    </select>
                </div>


                <div class="form-group col-md-3">
                    <label for="customer_status"><strong>NPL Status</strong></label>
                    <select class="form-control select2bs4" id="customer_status" name="filter[customer_status]" style="width:100%">
                        <option value="">None</option>
                        <option value="Regular" {{ request()->input('filter.customer_status') === 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Irregular" {{ request()->input('filter.customer_status') === 'Irregular' ? 'selected' : '' }}>Irregular</option>
                        <option value="OAEM" {{ request()->input('filter.customer_status') === 'OAEM' ? 'selected' : '' }}>OAEM</option>
                        <option value="Substandard" {{ request()->input('filter.customer_status') === 'Substandard' ? 'selected' : '' }}>Substandard</option>
                        <option value="Doubtful" {{ request()->input('filter.customer_status') === 'Doubtful' ? 'selected' : '' }}>Doubtful</option>
                        <option value="Loss" {{ request()->input('filter.customer_status') === 'Loss' ? 'selected' : '' }}>Loss</option>
                    </select>
                </div>


                @role('Super-Admin|North Regional MIS Officer|South Regional MIS Officer')
                    <div class="form-group col-md-3">
                        <label for="branch_id"><strong>Branch Name</strong></label>
                        <select class="form-control select2bs4" id="branch_id" name="filter[branch_id]" style="width:100%">
                            <option value="">None</option>
                            @foreach(App\Models\Branch::all() as $branch)
                                <option value="{{ $branch->id }}" {{ request()->input('filter.branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endrole


                <div class="form-group col-md-3">
                    <label for="date_range">Date Range</label>
                    <input class="form-control" type="search" readonly name="filter[starts_before]" id="date_range">
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

                <a href="{{ route('customer.export', [
                            'filter' => [
                                'search_string' => request()->input('filter.search_string'),
                                'customer_cnic' => request()->input('filter.customer_cnic'),
                                'guarantee.cnic' => request()->input('filter.guarantee.cnic'),
                                'account_cd_saving' => request()->input('filter.account_cd_saving'),
                                'manual_account' => request()->input('filter.manual_account'),
                                'product_type_id' => request()->input('filter.product_type_id'),
                                'gender' => request()->input('filter.gender'),
                                'status' => request()->input('filter.status'),
                                'customer_status' => request()->input('filter.customer_status'),
                                'branch_id' => request()->input('filter.branch_id'),
                                'starts_before' => request()->input('filter.starts_before'),
                            ]]) }}" class="btn btn-primary">
                    Download
                </a>

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
                <th scope="col">Branch/AC No</th>
                <th scope="col">Facility</th>
                <th scope="col">Type</th>
                <th scope="col" class="text-center"><abbr title="Principal Outstanding">POS</abbr></th>
                <th scope="col" class="text-center"><abbr title=" Amount Disbursed ">AD</abbr></th>
                <th scope="col">Category</th>
                <th scope="col" class="text-center d-print-none">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td scope="row"><strong>{{$loop->iteration}}</strong></td>
                    <td>
                        <a href="{{ route('customer.profile', $customer->id) }}" class="print_on_screen">
                            {{ ucwords(strtolower($customer->name)) }}
                        </a>
                    </td>
                    <td>{{$customer->customer_cnic}}</td>
                    <td>{{$customer->branch->code}}-{{$customer->account_cd_saving}}</td>
                    <td>{{$customer->product_type->product_type}}</td>
                    <td>{{$customer->secure_unsecure_loan}}</td>
                    <td class="text-right">{{ number_format($customer->principle_amount,2) }}</td>
                    <td class="text-right">{{ number_format($customer->amount_disbursed,2) }}</td>
                    <td>{{$customer->customer_status}}</td>
                    <td class="text-center d-print-none">
                        <a href="{{route('customer.show', $customer->id)}}">
                            <span class="fas fa-edit"></span>
                        </a>

                        <a href="{{route('installment.index', $customer->id)}}">
                            <span class="fas fa-money-bill"></span>
                        </a>
                    </td>
                </tr>
            @endforeach

            <tr>
                <td scope="row" class="text-bold text-right" colspan="6"><strong>Total:</strong></td>
                <td class="text-right">{{ number_format($customers->sum('principle_amount'),2) }}</td>
                <td class="text-right">{{ number_format($customers->sum('amount_disbursed'),2) }}</td>
            </tr>
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


            $("#date_range").daterangepicker({
                minDate: moment().subtract(10, 'years'),
                orientation: 'left',
                callback: function (startDate, endDate, period) {
                    $(this).val(startDate.format('L') + ' – ' + endDate.format('L'));
                }
            });

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

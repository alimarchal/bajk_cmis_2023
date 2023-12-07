<!-- Preloader -->
{{--<div class="preloader flex-column justify-content-center align-items-center">--}}
{{--    <img class="animation__shake" src="{{Storage::url('favicon.png')}}" alt="BAJK LOGO" height="60" width="60">--}}
{{--</div>--}}
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">

            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                {{--                    <span class="badge badge-warning navbar-badge">15</span>--}}
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Account</span>
                <div class="dropdown-divider"></div>
                <a href="{{route('profile.show')}}" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <a href="{{route('logout')}}" @click.prevent="$root.submit();" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> Logout
                    </a>
                </form>
                <div class="dropdown-divider"></div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            {{--                <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">--}}
            {{--                    <i class="fas fa-th-large"></i>--}}
            {{--                </a>--}}
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        {{--            img-circle elevation-3--}}
        <img src="{{Storage::url('favicon.png')}}" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-light">CFMIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item @if(request()->routeIs('dashboard')) menu-open @endif ">
                    <a href="{{route('dashboard')}}" class="nav-link  @if(request()->routeIs('dashboard')) active @endif ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item @if(request()->routeIs(['customer.index','customer.create','customer.profile']))  menu-open @endif">
                    <a href="#" class="nav-link @if(request()->routeIs(['customer.index','customer.create','customer.profile'])) active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Borrower
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @role('Branch Manager|Credit Officer|Head Office|Super-Admin')
                        <li class="nav-item">
                            <a href="{{route('customer.create')}}" class="nav-link @if(request()->routeIs('customer.create')) active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create New Borrower</p>
                            </a>
                        </li>
                        @endrole

                        <li class="nav-item">
                            <a href="{{route('customer.index')}}" class="nav-link   @if(request()->routeIs(['customer.index','customer.profile'])) active @endif ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search Borrower</p>
                            </a>
                        </li>
                    </ul>
                </li>


                @can('Full Access')
                    <li class="nav-item  @if(request()->routeIs(['users.index','users.create'])) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->routeIs(['users.index','users.create'])) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Management
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('users.create')}}" class="nav-link @if(request()->routeIs('users.create')) active @endif">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Create New User</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('users.index')}}" class="nav-link   @if(request()->routeIs('users.index')) active @endif ">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Search User</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('Full Access')
                    <li class="nav-item @if(request()->routeIs(['report.branch-wise-position','report.overall-bank-position','report.creditGrowth','report.creditGrowthPercentageShare','report.bankPosition','report.branchWisePositionLoans','report.outstandingAdvancesProductWise'])) menu-open @endif">
                        <a href="#"
                           class="nav-link @if(request()->routeIs(['report.branch-wise-position','report.overall-bank-position','report.creditGrowth','report.creditGrowthPercentageShare','report.bankPosition','report.branchWisePositionLoans','report.outstandingAdvancesProductWise'])) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Primary Reports
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('report.overall-bank-position')}}" class="nav-link @if(request()->routeIs('report.overall-bank-position')) active @endif">
                                    <p><span style="font-size: 14px;">Overall Bank Position</span></p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('report.branch-wise-position')}}" class="nav-link @if(request()->routeIs('report.branch-wise-position')) active @endif">
                                    <p><span style="font-size: 14px;">Branch Wise Position Advances</span></p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('report.bankPosition')}}" class="nav-link @if(request()->routeIs('report.bankPosition')) active @endif">
                                    <p><span style="font-size: 14px;">Bank Position</span></p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('report.branchWisePositionLoans')}}" class="nav-link @if(request()->routeIs('report.branchWisePositionLoans')) active @endif">
                                    <p><span style="font-size: 14px;">Branch Wise Position - Loans </span></p>
                                </a>
                            </li>

{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('report.outstandingAdvancesProductWise')}}" class="nav-link @if(request()->routeIs('report.outstandingAdvancesProductWise')) active @endif">--}}
{{--                                    <p><span style="font-size: 14px;"> Summary Outstanding Advances Product Wise </span></p>--}}
{{--                                </a>--}}
{{--                            </li>--}}

                            <li class="nav-item">
                                <a href="{{route('report.creditGrowth')}}" class="nav-link @if(request()->routeIs('report.creditGrowth')) active @endif">
                                    <p><span style="font-size: 14px;"> Product Wise Credit Growth </span></p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{route('report.creditGrowthPercentageShare')}}" class="nav-link @if(request()->routeIs('report.creditGrowthPercentageShare')) active @endif">
                                    <p>
                                        <span style="font-size: 14px;"> Product Credit Growth Percentage </span>
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item @if(request()->routeIs(['report.branchWiseNplPosition','report.branchWiseNplToAdvances','report.productWiseNplToAdvances','report.productWiseContributionInTotalPortfolio'])) menu-open @endif">
                        <a href="#" class="nav-link @if(request()->routeIs(['report.branchWiseNplPosition','report.branchWiseNplToAdvances','report.productWiseNplToAdvances','report.productWiseContributionInTotalPortfolio'])) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Secondary Reports
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('report.branchWiseNplPosition')}}" class="nav-link @if(request()->routeIs('report.branchWiseNplPosition')) active @endif">
                                    <p><span style="font-size: 14px;">Branch Wise NPL Position</span></p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{route('report.branchWiseNplToAdvances')}}" class="nav-link @if(request()->routeIs('report.branchWiseNplToAdvances')) active @endif">
                                    <p><span style="font-size: 14px;">Branch Wise NPL To Advance Ratio</span></p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('report.productWiseNplToAdvances')}}" class="nav-link @if(request()->routeIs('report.productWiseNplToAdvances')) active @endif">
                                    <p><span style="font-size: 14px;">Product Wise NPL To Advance Ratio </span></p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('report.productWiseContributionInTotalPortfolio')}}" class="nav-link @if(request()->routeIs('report.productWiseContributionInTotalPortfolio')) active @endif">
                                    <p><span style="font-size: 14px;">Product Wise Contribution In Total Portfolio </span></p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endcan
                {{--                <li class="nav-item">--}}
                {{--                    <a href="#" class="nav-link">--}}
                {{--                        <i class="nav-icon fas fa-tree"></i>--}}
                {{--                        <p>--}}
                {{--                            UI Elements--}}
                {{--                            <i class="fas fa-angle-left right"></i>--}}
                {{--                        </p>--}}
                {{--                    </a>--}}
                {{--                    <ul class="nav nav-treeview">--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/general.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>General</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/icons.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Icons</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/buttons.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Buttons</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/sliders.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Sliders</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/modals.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Modals & Alerts</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/navbar.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Navbar & Tabs</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/timeline.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Timeline</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/UI/ribbons.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Ribbons</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item">--}}
                {{--                    <a href="#" class="nav-link">--}}
                {{--                        <i class="nav-icon fas fa-edit"></i>--}}
                {{--                        <p>--}}
                {{--                            Forms--}}
                {{--                            <i class="fas fa-angle-left right"></i>--}}
                {{--                        </p>--}}
                {{--                    </a>--}}
                {{--                    <ul class="nav nav-treeview">--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/forms/general.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>General Elements</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/forms/advanced.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Advanced Elements</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/forms/editors.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Editors</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/forms/validation.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Validation</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item">--}}
                {{--                    <a href="#" class="nav-link">--}}
                {{--                        <i class="nav-icon fas fa-table"></i>--}}
                {{--                        <p>--}}
                {{--                            Tables--}}
                {{--                            <i class="fas fa-angle-left right"></i>--}}
                {{--                        </p>--}}
                {{--                    </a>--}}
                {{--                    <ul class="nav nav-treeview">--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/tables/simple.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>Simple Tables</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/tables/data.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>DataTables</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a href="pages/tables/jsgrid.html" class="nav-link">--}}
                {{--                                <i class="far fa-circle nav-icon"></i>--}}
                {{--                                <p>jsGrid</p>--}}
                {{--                            </a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}


            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{asset('public')}}/assets/"
    data-template="vertical-menu-template-no-customizer-starter" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Deven Health Care | Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('public')}}/assets/images/logo.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/fonts/remixicon/remixicon.css" />
    <!-- <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/fonts/flag-icons.css" /> -->

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
	<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
	<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css" />
    <link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/flatpickr/flatpickr.css" />
	@yield('css')
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('public')}}/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('public')}}/assets/js/config.js"></script>
    <style>
        #kt_datatable_length label{
            padding-left: 20px;
        }
        .menu-header .menu-header-text {
            color: #4cb7e5;
        }
        .table > :not(caption) > * > * {
            padding: 10px;
        }
        .table thead tr th {
            padding-block: 10px 10px;
        }
        select {
            padding:0 35px 0 10px !important;
            -webkit-padding-end: 35px !important;
            -webkit-padding-start: 10px !important;
        }
          /* Scrollbar track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }

        /* Scrollbar handle */
        ::-webkit-scrollbar-thumb {
            background: #7fcaea; 
            border-radius: 10px;
        }

        /* Scrollbar handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #4cb7e5; 
            cursor: pointer;
        }

        /* Scrollbar itself */
        ::-webkit-scrollbar {
            width: 5px; /* Width of the scrollbar */
            height: 5px; /* Height of the scrollbar, if horizontal */
        }
        .loader {
            display: block; 
            position: fixed;
            left: 55%;
            top: 50%;
            width: 50px;
            height: 50px;
            margin-left: -25px; 
            margin-top: -25px; 
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #DATAAA {
            display: none; /* Hide content by default */
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{route('dashboard')}}" class="app-brand-link">
                        {{-- <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png"
                            style="height: 55px!important;" /> --}}
                        <img alt="Logo" src="{{asset('public')}}/assets/images/logo_svg.svg"
                            style="height: 45px!important;" />
                        <span class="app-brand-text demo menu-text fw-semibold ms-2" style="color: #4CB7E5;">Deven Health<br>Care</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                                fill-opacity="0.9" />
                            <path
                                d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                                fill-opacity="0.4" />
                        </svg>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                @php
                    $permissions = Auth::user() ? Auth::user()->permissions() : [];
                @endphp
                <ul class="menu-inner py-1">
                    @if(in_array('dashboard',$permissions) || in_array('dhc_dashboard',$permissions) || in_array('hsp_dashboard',$permissions) || in_array('crp_dashboard',$permissions))
                    <li class="menu-item @if (Route::currentRouteName() == 'dashboard' || Route::currentRouteName() == 'dhc_dashboard' || Route::currentRouteName() == 'hsp_dashboard' || Route::currentRouteName() == 'crp_dashboard') open @endif">
                        <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                            <div>Dashboard</div>
                        </a>
                        <ul class="menu-sub">
                            @if(in_array('dashboard',$permissions) && Auth::user()->type == "ALL")
                            <li class="menu-item  @if (Route::currentRouteName() == 'dashboard') active @endif">
                                <a href="{{route('dashboard')}}" class="menu-link">
                                    <div>All</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('dhc_dashboard',$permissions) && Auth::user()->type == "DHC" ||  Auth::user()->type == "ALL")
                            <li class="menu-item  @if (Route::currentRouteName() == 'dhc_dashboard') active @endif">
                                <a href="{{route('dhc_dashboard')}}" class="menu-link">
                                    <div>DHC</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('hsp_dashboard',$permissions) && Auth::user()->type == "HSP" ||  Auth::user()->type == "ALL")
                            <li class="menu-item  @if (Route::currentRouteName() == 'hsp_dashboard') active @endif">
                                <a href="{{route('hsp_dashboard')}}" class="menu-link">
                                    <div>HSP</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('crp_dashboard',$permissions) && Auth::user()->type == "CRP" ||  Auth::user()->type == "ALL")
                            <li class="menu-item  @if (Route::currentRouteName() == 'crp_dashboard') active @endif">
                                <a href="{{route('crp_dashboard')}}" class="menu-link">
                                    <div>CRP</div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <!-- Page -->
                    {{-- @if(in_array('dashboard',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'dashboard') active @endif">
                        <a href="{{route('dashboard')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                            <div>Dashboard</div>
                        </a>
                    </li>
                    @endif --}}
                    @if(in_array('analytics',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'analytics') active @endif">
                        <a href="{{route('analytics')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-line-chart-line"></i>
                            <div>Analytics</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('bookings',$permissions) || in_array('assign_bookings',$permissions) || in_array('staff_attendance',$permissions) || in_array('create_booking',$permissions) || in_array('closed_bookings',$permissions) || in_array('booking_reviews',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Bookings</span>
                    </li>
                    @endif
                    @if(in_array('create_booking',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'add_booking') active @endif">
                        <a href="{{route('add_booking')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-calendar-schedule-line"></i>
                            <div>Create Booking</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('assign_bookings',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'assign_bookings') active @endif">
                        <a href="{{route('assign_bookings')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-user-follow-line"></i>
                            <div>Assign Booking</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('bookings',$permissions) || in_array('closed_bookings',$permissions))
                    <li class="menu-item @if (Route::currentRouteName() == 'bookings' || Route::currentRouteName() == 'closed_bookings') open @endif">
                        <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                            <i class="menu-icon tf-icons ri-calendar-todo-line"></i>
                            <div>Bookings</div>
                        </a>
                        <ul class="menu-sub">
                            @if(in_array('bookings',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'bookings') active @endif">
                                <a href="{{route('bookings')}}" class="menu-link">
                                    <div>Active Bookings</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('closed_bookings',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'closed_bookings') active @endif">
                                <a href="{{route('closed_bookings')}}" class="menu-link">
                                    <div>Closed Bookings</div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(in_array('booking_reviews',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'booking_reviews') active @endif">
                        <a href="{{route('booking_reviews')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-star-line"></i>
                            <div>Booking Reviews</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('staff_attendance',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'staff_attendance') active @endif">
                        <a href="{{route('staff_attendance')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-calendar-check-line"></i>
                            <div>Staff Attendance</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('active_invoice',$permissions) || in_array('closed_invoice',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Invoice</span>
                    </li>
                    @endif
                    @if(in_array('active_invoice',$permissions) || in_array('closed_invoice',$permissions))
                    <li class="menu-item @if (Route::currentRouteName() == 'active_invoice' || Route::currentRouteName() == 'closed_invoice') open @endif">
                        <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                            <i class="menu-icon tf-icons ri-file-list-3-line"></i>
                            <div>Invoice</div>
                        </a>
                        <ul class="menu-sub">
                            @if(in_array('active_invoice',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'active_invoice') active @endif">
                                <a href="{{route('active_invoice')}}" class="menu-link">
                                    <div>Active Invoice</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('closed_invoice',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'closed_invoice') active @endif">
                                <a href="{{route('closed_invoice')}}" class="menu-link">
                                    <div>Closed Invoice</div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if(in_array('advance_salary',$permissions) || in_array('salary',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Payments</span>
                    </li>
                    @endif
                    @if(in_array('salary',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'salary') active @endif">
                        <a href="{{route('salary')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-secure-payment-line"></i>
                            <div>Salary</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('advance_salary',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'advance_salary') active @endif">
                        <a href="{{route('advance_salary')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-money-rupee-circle-line"></i>
                            <div>Advance Salary</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('staff',$permissions) || in_array('doctors',$permissions)|| in_array('patients',$permissions) || in_array('corporates',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Menus</span>
                    </li>
                    @endif
                    @if(in_array('staff',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'staff') active @endif">
                        <a href="{{route('staff')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-nurse-line"></i>
                            <div>Staff</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('doctors',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'doctors') active @endif">
                        <a href="{{route('doctors')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-stethoscope-line"></i>
                            <div>Doctors</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('patients',$permissions) && Auth::user()->type == "DHC" || Auth::user()->type == "HSP" || Auth::user()->type == "ALL")
                    <li class="menu-item  @if (Route::currentRouteName() == 'patients') active @endif">
                        <a href="{{route('patients')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-wheelchair-line"></i>
                            <div>Patients</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('corporates',$permissions) && Auth::user()->type == "CRP" ||  Auth::user()->type == "ALL")
                    <li class="menu-item  @if (Route::currentRouteName() == 'corporates') active @endif">
                        <a href="{{route('corporates')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-building-line"></i>
                            <div>Corporates</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('users',$permissions) || in_array('roles',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Users</span>
                    </li>
                    <li
                        class="menu-item @if (Route::currentRouteName() == 'users' || Route::currentRouteName() == 'roles') open @endif">
                        <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                            <i class="menu-icon tf-icons ri-user-line"></i>
                            <div>User Management</div>
                        </a>
                        <ul class="menu-sub">
                            @if(in_array('users',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'users') active @endif">
                                <a href="{{route('users')}}" class="menu-link">
                                    <div>Users</div>
                                </a>
                            </li>
                            @endif
                            @if(in_array('roles',$permissions))
                            <li class="menu-item  @if (Route::currentRouteName() == 'roles') active @endif">
                                <a href="{{route('roles')}}" class="menu-link">
                                    <div>Roles</div>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if(in_array('staff_salary_report',$permissions) || in_array('paused_booking_report',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Reports</span>
                    </li>
                    @endif
                    @if(in_array('staff_salary_report',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'staff_salary_report') active @endif">
                        <a href="{{route('staff_salary_report')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-file-list-line"></i>
                            <div>Staff Salary</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('started_booking_report',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'started_booking_report') active @endif">
                        <a href="{{route('started_booking_report')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-file-list-line"></i>
                            <div>Services</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('paused_booking_report',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'paused_booking_report') active @endif">
                        <a href="{{route('paused_booking_report')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-file-list-line"></i>
                            <div>Paused Bookings</div>
                        </a>
                    </li>
                    @endif

                    @if(in_array('hospitals',$permissions) || in_array('shifts',$permissions) || in_array('equipments',$permissions) || in_array('ambulance',$permissions) || in_array('staff_type',$permissions) || in_array('states',$permissions) || in_array('cities',$permissions) || in_array('area',$permissions))
                    <li class="menu-header mt-5">
                        <span class="menu-header-text">Masters</span>
                    </li>
                    @endif
                    @if(in_array('hospitals',$permissions) && Auth::user()->type == "HSP" || Auth::user()->type == "ALL")
                    <li class="menu-item  @if (Route::currentRouteName() == 'hospitals') active @endif">
                        <a href="{{route('hospitals')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-hospital-line"></i>
                            <div>Hospitals</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('shifts',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'shifts') active @endif">
                        <a href="{{route('shifts')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-time-line"></i>
                            <div>Shifts</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('equipments',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'equipments') active @endif">
                        <a href="{{route('equipments')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-syringe-line"></i>
                            <div>Equipments</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('ambulance',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'ambulance') active @endif">
                        <a href="{{route('ambulance')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-taxi-line"></i>
                            <div>Ambulance</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('staff_type',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'staff_type') active @endif">
                        <a href="{{route('staff_type')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-user-search-line"></i>
                            <div>Staff Type</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('states',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'states') active @endif">
                        <a href="{{route('states')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-road-map-line"></i>
                            <div>States</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('cities',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'cities') active @endif">
                        <a href="{{route('cities')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-building-line"></i>
                            <div>Cities</div>
                        </a>
                    </li>
                    @endif
                    @if(in_array('area',$permissions))
                    <li class="menu-item  @if (Route::currentRouteName() == 'area') active @endif">
                        <a href="{{route('area')}}" class="menu-link">
                            <i class="menu-icon tf-icons ri-compass-line"></i>
                            <div>Area</div>
                        </a>
                    </li>
                    @endif
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="ri-menu-fill ri-22px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-danger" style="font-size: 26px;">{{ substr(Auth::user() ? Auth::user()->name : "DHC", 0, 1) }}</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">
                                                        {{-- <img src="{{asset('public')}}/assets/img/avatars/1.png" alt
                                                            class="rounded-circle" /> --}}
                                                            <span class="avatar-initial rounded-circle bg-danger" style="font-size: 26px;">{{ substr(Auth::user() ? Auth::user()->name : "DHC", 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-medium d-block">{{ Auth::user() ? Auth::user()->name : "DHC" }}</span>
                                                    <small class="text-muted">{{ Auth::user()->role ? Auth::user()->role->name : "NA" }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="ri-shut-down-line me-3"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div id="loader" class="loader">
                            <img src="{{asset('public')}}/assets/images/logo.png" alt="Loading...">
                        </div>
                        <div id="DATAAA">
                            @yield('content')
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
							
                                <div class="text-body mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    <a href="{{route('dashboard')}}" target="_blank" class="footer-link">Deven Health Care</a>
                                </div>
                                {{-- <div class="d-none d-lg-inline-block">
                                    <a href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>
                                </div> --}}
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('public')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{asset('public')}}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/hammer/hammer.js"></script>

    <script src="{{asset('public')}}/assets/vendor/js/menu.js"></script>
	<script src="{{asset('public')}}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/select2/select2.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="{{asset('public')}}/assets/js/extended-ui-sweetalert2.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('public')}}/assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            dataTable = $('#kt_datatable').DataTable();
        });
        $(window).on('load', function() {
            $("#loader").fadeOut("slow", function() {
                $("#DATAAA").fadeIn("slow");
                dataTable.columns.adjust().draw();
            });
        });
    </script>
	@yield('javascript')

</body>

</html>
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
            /* border: 10px solid #f3f3f3; 
            border-top: 10px solid #4cb7e5; 
            border-radius: 50%;
            animation: spin 2s linear infinite; */
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

<div class="row">
    <div class="col-12">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-12 mb-md-0 mb-6">
              <div class="card invoice-preview-card" >
                <div class="card-body invoice-preview-header rounded-4 p-6" style="background-color: rgba(38, 43, 67, .06);">
                  <div
                    class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">
                    <div>
                        <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                          <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png" style="height: 80px!important;" />
                        </div>
                        
                      </div>
                      <div>
                        <p class="mb-1">FF-2, 1ST Floor Block A in Malabar County -2,</p>
                        <p class="mb-1">Nirma University cirket ground,</p>
                        <p class="mb-1">off SG road Chhatrodi, Ahmedabad.</p>
                        <p class="mb-1">+91 8866451769</p>
                        <p class="mb-1">devenhealthcare202@gmail.com</p>
                        <p class="mb-0"> www.devenhealthcare.com</p>
                      </div>
                  </div>
                </div>
                <div class="card-body py-6 px-3">
                  <div class="d-flex justify-content-between flex-wrap gap-6">
                    <div style="flex: 1; min-width: 45%;">
                      <h6>Invoice To:</h6>
                      @if($booking->booking_type == "Patient")
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (@if($booking->customer_details->h_type != "DHC") HSP @else DHC @endif)</p>
                        @if($booking->customer_details->h_type != "DHC")
                          <p class="mb-1">{{$booking->customer_details->h_type ?? ""}}</p>
                        @endif
                      @else
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (<b>{{$booking->booking_type ?? ""}}</b>)</p>
                      @endif
                      <p class="mb-1">{{$booking->customer_details->address ?? ""}}</p>
                      <p class="mb-1">{{$booking->area ?? ""}}, {{$booking->city ?? ""}}, {{$booking->state ?? ""}}</p>
                    </div>
                    <div style="flex: 1; min-width: 45%; padding-left:10rem;">
                      <h6>Booking & Invoice</h6>
                      <table>
                        <tbody>
                            <tr>
                                <td class="pe-4">Invoice No.:</td>
                                <td>{{$booking->unique_id ?? ""}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Date Issues:</td>
                                <td>{{date('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Service Period:</td>
                                <td>{{date('d/m/Y',strtotime($booking->start_date))}} To {{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Invoice Start Date:</td>
                                <td id="DataStartDate">{{date('d/m/Y',strtotime($booking->start_date))}}</td>
                            </tr>
                            <tr>
                              <td class="pe-4">Invoice End Date:</td>
                              <td id="DataEndDate">{{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="table-responsive border rounded-4 border-bottom-0 mx-3">
                  <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                    <thead>
                      <tr>
                        <th>Sr No.</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Days/Qty</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody id="table-body">
            
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive px-3">
                  <table class="table m-0 table-borderless">
                    <tbody>
                      <tr>
                        <td class="align-top px-0 py-6">
                          <p class="mb-1">
                            <span class="me-2 fw-medium text-heading">Signature:</span>
                          </p>
                        </td>
                        <td class="pe-0 py-6 w-px-100">
                          <p class="mb-1 border-bottom pb-2">Subtotal:</p>
                          <p class="mb-0 pt-2">Total:</p>
                        </td>
                        <td class="text-end px-0 py-6 w-px-100">
                          <p class="fw-medium mb-1 border-bottom pb-2" id="grand-sub-total">₹{{$booking->sub_total ?? "00"}}</p>
                          <p class="fw-medium mb-0 pt-2" id="grand-total">₹{{$booking->total ?? "00"}}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /Invoice -->
        </div>
    </div>
</div>

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

    <script src="{{asset('public')}}/assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

</body>

</html>
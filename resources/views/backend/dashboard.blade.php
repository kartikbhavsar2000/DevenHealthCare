@extends('backend.components.header')

@section('css')
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/pages/app-logistics-dashboard.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<style>
  th{
    font-size: 16px!important;
    /* font-weight: 600!important;
    color: #fff!important;
    background-color: #4cb7e5!important;*/
    text-transform: capitalize!important;
    padding: 16px 10px!important; 
    /* text-align: center!important; */
  }
  th,td{
    border: 1px solid #dfdfe2;
    text-align: center!important;
  }
  .nav .nav-link:not(.active):hover {
      color: #ffffff!important;
  }
  .nav-tabs .nav-link.active, .nav-tabs .nav-link.active:hover, .nav-tabs .nav-link.active:focus {
      background: #ffffff!important;
      color: #4cb7e5!important;
      border:5px solid #4cb7e5;
  }
</style>
@endsection

@section('content')
@if(session()->has('success'))
    <div class="alert alert-success d-flex align-items-center p-3 mt-4" role="alert">
        <span>{{ session()->get('success') }}</span>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger d-flex align-items-center p-3 mt-4" role="alert">
        <span>{{ session()->get('error') }}</span>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
@endif
<div class="row g-6">
  <div class="col-12">
      <h4 class="mb-1">Dashboard</h4>
      <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Dashboard</p>
  </div>
  <div class="col-sm-12 col-lg-12">
    <div class="card text-center mb-4">
      <div class="card-header p-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs nav-fill" role="tablist" style="height: 60px;">
            @if(!empty($dates))
              @foreach($dates as $key => $date)
                <li class="nav-item" role="presentation">
                  <button type="button" style="height: 60px; background: #4cb7e5; color:#c5eeff; border:2px solid #4cb7e5;" class="nav-link d-flex flex-column gap-1 waves-effect  @if($key == 0)active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-card-{{$key}}" aria-controls="navs-profile-{{$key}}" aria-selected="@if($key == 0) true @else false @endif" @if($key != 0) tabindex="-1" @endif>{{date('M d', strtotime($date))}}</button>
                </li>
              @endforeach
            @endif
          </ul>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="tab-content p-0 pb-0">
          @if(!empty($dates))
            @foreach($dates as $key => $date)
              <div class="tab-pane fade text-start @if($key == 0)active show @endif" id="navs-card-{{$key}}" role="tabpanel">
                <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                  <thead>
                      <tr>
                        <th rowspan="2" style="border:1px solid #4cb7e5; background:#c5eeff; max-width:20%;">Customer Name</th>
                        <th colspan="{{count($staff_type)}}" style="border-bottom:1px solid #dfdfe2; max-width:20%;">Staff</th>
                        <th rowspan="2" style="border-bottom:1px solid #dfdfe2; max-width:20%;">Doctor</th>
                      </tr>
                      <tr>
                        @if(!empty($staff_type))
                          @foreach($staff_type as $st)
                            <th colspan="1" style="border-bottom:1px solid #dfdfe2;">{{$st->title}}</th>
                          @endforeach
                        @endif
                      </tr>
                  </thead>
                  <tbody>
                      @if(!empty($bookings))
                        @foreach($bookings as $booking)
                          @if($date >= date('Y-m-d', strtotime($booking->start_date)) && $date <= date('Y-m-d', strtotime($booking->end_date)))
                          <tr>
                            <td style="background: #c5eeff;  border:1px solid #4cb7e5; text-align:center;">
                              {{$booking->customer_details->name}}
                              <b style="font-size: 12px;">
                                @if($booking->booking_type == "Patient")
                                  @if($booking->customer_details->h_type == "DHC")
                                    (DHC)
                                  @else
                                    (HSP)
                                  @endif
                                @else
                                  (CRP)
                                @endif
                                <br>{{$booking->unique_id}}<br>
                                <button class="badge badge-center bg-primary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Customer Details" data-bs-custom-class="tooltip-dark" onclick="openCustomerDetailsModal('{{$booking}}')" type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>
                              </b>
                            </td>
                            @if(!empty($staff_type))
                              @foreach($staff_type as $st)
                                <td>
                                  @if(!empty($booking->staff_data))
                                    @php
                                      $staff_found = false;
                                    @endphp
                                    @foreach($booking->staff_data as $stf)
                                      @if($stf->staff_details)
                                        @if($stf->type == $st->title && $date == date('Y-m-d', strtotime($stf->date)))
                                          <div class="row p-1">
                                            <div class="col-8 text-start">
                                                {{$stf->staff_details->f_name}} {{$stf->staff_details->m_name}} {{$stf->staff_details->l_name}}<br>
                                                <b style="font-size: 12px;"> {{$stf->shiftt->name}}</b>
                                            </div>
                                            <div class="col-4">
                                              <button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Staff" data-bs-custom-class="tooltip-dark" onclick="openStaffAssignModal('{{$stf->id}}','{{date('Y-m-d', strtotime($stf->date))}}','{{$st->id}}', {{$stf->shiftt->id}}, {{$stf->sell_rate}})" type="button" style="line-height: 10px;"><i class="ri-pencil-line"></i></button>
                                              <button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Staff Details" data-bs-custom-class="tooltip-dark" onclick="openStaffDetailsModal('{{$stf->staff_details}}')" type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>
                                            </div>
                                          </div>
                                          @php
                                            $staff_found = true;
                                          @endphp
                                        @endif
                                      @else
                                        @if($stf->type == $st->title && $date == date('Y-m-d', strtotime($stf->date)))
                                          <div class="row p-1">
                                            <div class="col-8 pt-2 text-start">
                                              <b style="font-size: 12px;"> {{$stf->shiftt->name}}</b>
                                            </div>
                                            <div class="col-4">
                                              <button class="badge badge-center bg-warning border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Assign Staff" data-bs-custom-class="tooltip-dark" onclick="openStaffAssignModal('{{$stf->id}}','{{date('Y-m-d', strtotime($stf->date))}}','{{$st->id}}', {{$stf->shiftt->id}}, {{$stf->sell_rate}})" type="button" style="line-height: 0px;"><i class="ri-user-follow-line"></i></button>
                                            </div>
                                          </div>
                                          @php
                                            $staff_found = true;
                                          @endphp
                                        @endif
                                      @endif
                                    @endforeach
                                    @if(!$staff_found)
                                    __
                                    @endif
                                  @else
                                  __
                                  @endif
                                </td>
                              @endforeach
                            @else
                              <td> __</td>
                            @endif
                            <td>
                              @if(!empty($booking->doctor_data))
                                @php
                                  $doctor_found = false;
                                @endphp
                                @foreach($booking->doctor_data as $dct)
                                  @if($dct->staff_details)
                                    @if($date == date('Y-m-d', strtotime($dct->date)))
                                      <div class="row p-1">
                                        <div class="col-8 text-start">
                                          {{$dct->staff_details->name}}<br><b style="font-size: 12px;">{{$dct->shiftt->name}}</b>
                                        </div>
                                        <div class="col-4">
                                          @php
                                              $staffDetailsJson = json_encode($dct->staff_details);
                                          @endphp
                                          <button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Doctor" data-bs-custom-class="tooltip-dark" onclick="openDoctorAssignModal('{{$dct->id}}','{{date('Y-m-d', strtotime($dct->date))}}','Doctor', {{$dct->shiftt->id}}, {{$dct->sell_rate}})"  style="line-height: 10px;"><i class="ri-pencil-line"></i></button>
                                          <button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Doctor Details" data-bs-custom-class="tooltip-dark" onclick="openDoctorDetailsModal('{{ addslashes($staffDetailsJson) }}')" type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>
                                        </div>
                                      </div>
                                      @php
                                        $doctor_found = true;
                                      @endphp
                                    @endif
                                  @else
                                    @if($date == date('Y-m-d', strtotime($dct->date)))
                                      <div class="row p-1">
                                        <div class="col-8 pt-2 text-start">
                                          <b style="font-size: 12px;"> {{$dct->shiftt->name}}</b>
                                        </div>
                                        <div class="col-4">
                                          <button class="badge badge-center bg-warning border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Assign Doctor" data-bs-custom-class="tooltip-dark" onclick="openDoctorAssignModal('{{$dct->id}}','{{date('Y-m-d', strtotime($dct->date))}}','Doctor', {{$dct->shiftt->id}}, {{$dct->sell_rate}})"  style="line-height: 0px;"><i class="ri-user-follow-line"></i></button>
                                        </div>
                                      </div>
                                      @php
                                        $doctor_found = true;
                                      @endphp
                                    @endif
                                  @endif
                                @endforeach
                              @endif
                              <div class="text-center mt-2 py-3" style="background:#c5eeff;">
                                <button class="badge badge-center bg-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add Doctor" data-bs-custom-class="tooltip-dark" onclick="openAddDoctorAssignModal('{{$booking->id}}','{{date('Y-m-d', strtotime($date))}}')" style="line-height: 0px;"><i class="ri-add-line"></i></button>
                              </div>
                            </td>
                          </tr>
                          @endif
                        @endforeach
                      @endif
                  </tbody>
                </table>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="staffDetailsCanvas" tabindex="-1" aria-labelledby="staffDetailsCanvasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staffDetailsCanvasLabel">Staff Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <div class="mt-1">
              Staff Id
            </div>
            <div class="mt-1">
              Staff Name
            </div>
            <div class="mt-1">
              Type
            </div>
            <div class="mt-1">
              Email Address
            </div>
            <div class="mt-1">
              Contact Number
            </div>
            <div class="mt-1">
              Alternet Contact Number
            </div>
            <div class="mt-1">
              Date Of Birth
            </div>
            <div class="mt-1">
              Age
            </div>
            <div class="mt-1">
              Gender
            </div>
            <div class="mt-1">
              Address
            </div>
            <div class="mt-1">
              State
            </div>
            <div class="mt-1">
              City
            </div>
            <div class="mt-1">
              Area
            </div>
          </div>
          <div class="col-8">
            <div class="mt-1">
              : <span id="st_Id">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Name">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Type">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Email">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Mobile">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Mobile2">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Dob">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Age">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Gender">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Address">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_State">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_City">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Area">-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="doctorDetailsCanvas" tabindex="-1" aria-labelledby="doctorDetailsCanvasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorDetailsCanvasLabel">Doctor Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <div class="mt-1">
              Doctor Id
            </div>
            <div class="mt-1">
              Doctor Name
            </div>
            <div class="mt-1">
              Type
            </div>
            <div class="mt-1">
              Email Address
            </div>
            <div class="mt-1">
              Contact Number
            </div>
            <div class="mt-1">
              Date Of Birth
            </div>
            <div class="mt-1">
              Age
            </div>
            <div class="mt-1">
              Gender
            </div>
            <div class="mt-1">
              Address
            </div>
            <div class="mt-1">
              State
            </div>
            <div class="mt-1">
              City
            </div>
            <div class="mt-1">
              Area
            </div>
          </div>
          <div class="col-8">
            <div class="mt-1">
              : <span id="doc_Id">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Name">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Type">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Email">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Mobile">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Dob">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Age">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Gender">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Address">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_State">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_City">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Area">-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="customerDetailsCanvas" tabindex="-1" aria-labelledby="customerDetailsCanvasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customerDetailsCanvasLabel"><i class="ri-wheelchair-line ri-22px me-2"></i>Patient Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Patient Id</b>
              </div>
              <div class="col-8">
                : <span id="cust_Id">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Type</b>
              </div>
              <div class="col-8">
                : <span id="cust_Type">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Patient Name</b>
              </div>
              <div class="col-8">
                : <span id="cust_Name">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Email Address</b>
              </div>
              <div class="col-8">
                : <span id="cust_Email">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Contact Number</b>
              </div>
              <div class="col-8">
                : <span id="cust_Mobile">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Date Of Birth</b>
              </div>
              <div class="col-8">
                : <span id="cust_Dob">-</span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Age</b>
              </div>
              <div class="col-8">
                : <span id="cust_Age">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Gender</b>
              </div>
              <div class="col-8">
                : <span id="cust_Gender">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Address</b>
              </div>
              <div class="col-8">
                : <span id="cust_Address">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>State</b>
              </div>
              <div class="col-8">
                : <span id="cust_State">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>City</b>
              </div>
              <div class="col-8">
                : <span id="cust_City">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Area</b>
              </div>
              <div class="col-8">
                : <span id="cust_Area">-</span>
              </div>
            </div>
          </div>
          <h5 class="modal-title my-4"><i class="ri-calendar-schedule-line ri-22px me-2"></i>Booking Details</h5>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Booking Id</b>
              </div>
              <div class="col-8">
                : <span id="cust_BookingId">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Start Date</b>
              </div>
              <div class="col-8">
                : <span id="cust_BookingStart">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>End Date</b>
              </div>
              <div class="col-8">
                : <span id="cust_BookingEnd">-</span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Type</b>
              </div>
              <div class="col-8">
                : <span id="cust_BookingType">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Total</b>
              </div>
              <div class="col-8">
                : <span id="cust_BookingTotal">-</span>
              </div>
            </div>
          </div>
          <div class="col-12 mt-5">
            <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Shift</th>
                  <th>Qnt</th>
                  <th>Rate</th>
                </tr>
              </thead>
              <tbody id="cust_BookingData">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="corporationDetailsCanvas" tabindex="-1" aria-labelledby="corporationDetailsCanvasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="corporationDetailsCanvasLabel"><i class="ri-building-line ri-22px me-2"></i>Corporation Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Corporation Name</b>
              </div>
              <div class="col-8">
                : <span id="corp_Name">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Contact Number 1</b>
              </div>
              <div class="col-8">
                : <span id="corp_Mobile">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Contact Number 2</b>
              </div>
              <div class="col-8">
                : <span id="corp_Mobile2">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Address</b>
              </div>
              <div class="col-8">
                : <span id="corp_Address">-</span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>State</b>
              </div>
              <div class="col-8">
                : <span id="corp_State">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>City</b>
              </div>
              <div class="col-8">
                : <span id="corp_City">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Area</b>
              </div>
              <div class="col-8">
                : <span id="corp_Area">-</span>
              </div>
            </div>
          </div>
          <h5 class="modal-title my-4"><i class="ri-calendar-schedule-line ri-22px me-2"></i>Booking Details</h5>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Booking Id</b>
              </div>
              <div class="col-8">
                : <span id="corp_BookingId">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Start Date</b>
              </div>
              <div class="col-8">
                : <span id="corp_BookingStart">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>End Date</b>
              </div>
              <div class="col-8">
                : <span id="corp_BookingEnd">-</span>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="mt-1 row">
              <div class="col-4">
                <b>Type</b>
              </div>
              <div class="col-8">
                : <span id="corp_BookingType">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-4">
                <b>Total</b>
              </div>
              <div class="col-8">
                : <span id="corp_BookingTotal">-</span>
              </div>
            </div>
          </div>
          <div class="col-12 mt-5">
            <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Shift</th>
                  <th>Qnt</th>
                  <th>Rate</th>
                </tr>
              </thead>
              <tbody id="corp_BookingData">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="AssignStaffCanvas" aria-labelledby="AssignStaffCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AssignStaffCanvasLabel">Assign Staff</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('assign_single_staff')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
              <input type="text" class="form-control d-none" name="id" id="Staff_Assign_Id">
              <input type="text" class="form-control" name="date" placeholder="DD-MM-YYYY" id="AssignDate" readonly/>
              <label for="AssignDate">Assign Date</label>
          </div>
          @error('date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="StaffTypeSelect select2 form-select" name="staff_type" id="Type" disabled>
                <option disabled selected>Select type</option>
                @if(!empty($staff_type))
                    @foreach($staff_type as $type)
                        <option value="{{$type->id}}">{{$type->title}}</option>
                    @endforeach
                @endif
            </select>
              <label for="AssignDate">Type</label>
            </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="ShiftSelect select2 form-select" name="shift" id="Shift" disabled>
                <option disabled selected>Select shift</option>
                @if(!empty($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                    @endforeach
                @endif
            </select>
            <label>Shift</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="CustomerRate" disabled>
              <label>Customer Rate</label>
          </div>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="StaffSelect select2 form-select" name="staff_id" id="Staff" required onchange="changeStaffRate()">
                <option></option>
                {{-- @if(!empty($staffs))
                    @foreach($staffs as $st)
                      <option value="{{$st->id}}" data-details="{{$st}}">{{$st->f_name}} {{$st->m_name}} {{$st->l_name}} - {{$st->staff_id}}</option>
                    @endforeach
                @endif --}}
            </select>
            <label>Select Staff</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text">₹</span>
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="rate" placeholder="00" required id="CostRate" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                <label>Cost Rate</label>
            </div>
          </div>
        </div>
        <div class="col-12 mt-8">
          <button type="submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="AssignDoctorCanvas" aria-labelledby="AssignDoctorCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AssignDoctorCanvasLabel">Assign Doctor</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('assign_single_doctor')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
              <input type="text" class="form-control d-none" name="id" id="Doctor_Assign_Id">
              <input type="text" class="form-control" name="date" placeholder="DD-MM-YYYY" id="DocAssignDate" readonly/>
              <label for="AssignDate">Assign Date</label>
          </div>
          @error('date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control d-none" name="staff_type" value="Doctor">
            <input type="text" class="form-control" value="Doctor" disabled/>
              <label for="AssignDate">Type</label>
            </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="ShiftSelect1 select2 form-select" name="shift" id="DocShift" disabled>
                <option disabled selected>Select shift</option>
                @if(!empty($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                    @endforeach
                @endif
            </select>
            <label>Shift</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="DocCustomerRate" disabled>
              <label>Customer Rate</label>
          </div>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="DoctorSelect select2 form-select" name="staff_id" id="Doctor" required onchange="changeDoctorRate()">
                <option></option>
                {{-- @if(!empty($doctors))
                    @foreach($doctors as $doc)
                      <option value="{{$doc->id}}" data-details="{{$doc}}">{{$doc->name}} - {{$doc->doctor_id}}</option>
                    @endforeach
                @endif --}}
            </select>
            <label>Select Doctor</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text">₹</span>
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="rate" placeholder="00" required id="DocCostRate" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                <label>Cost Rate</label>
            </div>
          </div>
        </div>
        <div class="col-12 mt-8">
          <button type="submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
        </div>
      </div>
    </form> 
  </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="AddAssignDoctorCanvas" aria-labelledby="AddAssignDoctorCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AddAssignDoctorCanvasLabel">Add & Assign Doctor</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('add_assign_single_doctor')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
              <input type="text" class="form-control d-none" name="booking_id" id="Doctor_Booking_Id">
              <input type="text" class="form-control" name="date" placeholder="DD-MM-YYYY" id="DocAddAssignDate" readonly/>
              <label for="DocAddAssignDate">Assign Date</label>
          </div>
          @error('date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" name="staff_type" value="Doctor" readonly>
            <label>Type</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="ShiftSelect2 select2 form-select" name="shift" id="DocAddShift" onchange="filterAndSetDoctor(this)" required>
                <option value="" disabled selected>Select shift</option>
                @if(!empty($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                    @endforeach
                @endif
            </select>
            <label>Shift</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text text-secondary">₹</span>
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" name="sell_rate" placeholder="00" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
              <label>Customer Rate</label>
          </div>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="DoctorSelect2 select2 form-select" name="staff_id" id="Doctor2" required onchange="changeDoctorRate2()">
                <option></option>
                {{-- @if(!empty($doctors))
                    @foreach($doctors as $doc)
                      <option value="{{$doc->id}}" data-details="{{$doc}}">{{$doc->name}} - {{$doc->doctor_id}}</option>
                    @endforeach
                @endif --}}
            </select>
            <label>Select Doctor</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text">₹</span>
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="cost_rate" placeholder="00" required id="DocAddCostRate" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                <label>Cost Rate</label>
            </div>
          </div>
        </div>
        <div class="col-12 mt-8">
          <button type="submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{asset('public')}}/assets/js/app-logistics-dashboard.js"></script>
<script>
  $('.kt_datatable').DataTable({
    dom:'',
    columnDefs: [{
        "defaultContent": "-",
        "targets": "_all",
    }],
  });
</script>
<script>
  function openCustomerDetailsModal(customer) {
    var data = JSON.parse(customer);
    console.log(data);
    if(data.customer_details.dob){
      var date = moment(data.customer_details.dob).format('DD/MM/YYYY');
    }else{
      var date = "";
    }
    if(data.booking_type == "Patient"){
      $('#cust_Id').text(data.customer_details.patient_id || '');
      $('#cust_Type').text((data.customer_details.h_type || ''));
      $('#cust_Name').text((data.customer_details.name || ''));
      $('#cust_Email').text(data.customer_details.email || '');
      $('#cust_Mobile').text(data.customer_details.mobile || '');
      $('#cust_Dob').text(date);
      $('#cust_Age').text(data.customer_details.age + " Years" || '');
      $('#cust_Gender').text(data.customer_details.gender || '');
      $('#cust_Address').text(data.customer_details.address || '');
      $('#cust_State').text(data.customer_details.state.name || '');
      $('#cust_City').text(data.customer_details.city.name || '');
      $('#cust_Area').text(data.customer_details.area.name || '');

      $('#cust_BookingId').text(data.unique_id || '');
      $('#cust_BookingType').text(data.booking_type || '');
      $('#cust_BookingStart').text(data.start_date || '');
      $('#cust_BookingEnd').text(data.end_date || '');
      $('#cust_BookingTotal').text(data.total || '');

      var bookingData = "";
      $.each(data.booking_details, function(index, item) {
          var srno = index + 1;
          var type = "-";
          if(item.type == 1){
              type = "Staff";
          } else if(item.type == 2){
              type = "Equipment";
          } else if(item.type == 3){
              type = "Doctor";
          } else if(item.type == 4){
              type = "Ambulance";
          }

          bookingData += `<tr>
                              <td>`+ srno +`</td>
                              <td>`+ (item.name ?? "-") +`</td>
                              <td>`+ type +`</td>
                              <td>`+ (item.shift_name ?? "-") +`</td>
                              <td>`+ (item.qnt ?? "-") +`</td>
                              <td>`+ (item.sell_rate ?? "-") +`</td>
                          </tr>`;
      });
      $('#cust_BookingData').html(bookingData);

      
      $('#customerDetailsCanvas').modal('show');
    }else{
      $('#corp_Name').text((data.customer_details.name || ''));
      $('#corp_Mobile').text(data.customer_details.mobile1 || '');
      $('#corp_Mobile2').text(data.customer_details.mobile2 || '');
      $('#corp_Address').text(data.customer_details.address || '');
      $('#corp_State').text(data.customer_details.state.name || '');
      $('#corp_City').text(data.customer_details.city.name || '');
      $('#corp_Area').text(data.customer_details.area.name || '');

      $('#corp_BookingId').text(data.unique_id || '');
      $('#corp_BookingType').text(data.booking_type || '');
      $('#corp_BookingStart').text(data.start_date || '');
      $('#corp_BookingEnd').text(data.end_date || '');
      $('#corp_BookingTotal').text(data.total || '');

      var bookingData = "";
      $.each(data.booking_details, function(index, item) {
          var srno = index + 1;
          var type = "-";
          if(item.type == 1){
              type = "Staff";
          } else if(item.type == 2){
              type = "Equipment";
          } else if(item.type == 3){
              type = "Doctor";
          } else if(item.type == 4){
              type = "Ambulance";
          }

          bookingData += `<tr>
                              <td>`+ srno +`</td>
                              <td>`+ (item.name ?? "-") +`</td>
                              <td>`+ type +`</td>
                              <td>`+ (item.shift_name ?? "-") +`</td>
                              <td>`+ (item.qnt ?? "-") +`</td>
                              <td>`+ (item.sell_rate ?? "-") +`</td>
                          </tr>`;
      });
      $('#corp_BookingData').html(bookingData);


      $('#corporationDetailsCanvas').modal('show');
    }
  }
  function openStaffDetailsModal(staff) {
    var data = JSON.parse(staff);
    if(data.dob){
      var date = moment(data.dob).format('DD/MM/YYYY');
    }else{
      var date = "";
    }
    if(data.age){
      var age = data.age + " Years"
    }else{
      var age = "";
    }
    $('#st_Id').text(data.staff_id || '');
    $('#st_Name').text((data.f_name || '') + ' ' + (data.m_name || '') + ' ' + (data.l_name || ''));
    $('#st_Type').text(data.types.title || '');
    $('#st_Email').text(data.email || '');
    $('#st_Mobile').text(data.mobile || '');
    $('#st_Mobile2').text(data.mobile2 || '');
    $('#st_Dob').text(date);
    $('#st_Age').text(age);
    $('#st_Gender').text(data.gender || '');
    $('#st_Address').text(data.address || '');
    $('#st_State').text(data.state.name || '');
    $('#st_City').text(data.city.name || '');
    $('#st_Area').text(data.area.name || '');
    $('#staffDetailsCanvas').modal('show');
  }
  function openDoctorDetailsModal(doctor) {
    var data = JSON.parse(doctor);
    if(data.dob){
      var date = moment(data.dob).format('DD/MM/YYYY');
    }else{
      var date = "";
    }
    if(data.age){
      var age = data.age + " Years"
    }else{
      var age = "";
    }
    $('#doc_Name').text((data.name || ''));
    $('#doc_Id').text(data.doctor_id || '');
    $('#doc_Type').text('Doctor');
    $('#doc_Email').text(data.email || '');
    $('#doc_Mobile').text(data.mobile || '');
    $('#doc_Dob').text(date);
    $('#doc_Age').text(age);
    $('#doc_Gender').text(data.gender || '');
    $('#doc_Address').text(data.address || '');
    $('#doc_State').text(data.state.name || '');
    $('#doc_City').text(data.city.name || '');
    $('#doc_Area').text(data.area.name || '');
    $('#doctorDetailsCanvas').modal('show');
  }
  function changeStaffRate(){
    var dataStr = $('#Staff').find(':selected').attr('data-details');
    if(dataStr){
        var data = JSON.parse(dataStr);
        var rateInput = $('#CostRate'); 
        var shiftInput = $('#Shift');

        if(shiftInput.val() == 1){
            rateInput.val(data.day_cost);
        }
        if(shiftInput.val() == 2){
            rateInput.val(data.night_cost);
        }
        if(shiftInput.val() == 3){
            rateInput.val(data.full_cost);
        }
    }
  }
  function changeDoctorRate(){
    var dataStr = $('#Doctor').find(':selected').attr('data-details');
    if(dataStr){
        var data = JSON.parse(dataStr);
        var rateInput = $('#DocCostRate'); 
        var shiftInput = $('#DocShift');

        if(shiftInput.val() == 1){
            rateInput.val(data.day_cost);
        }
        if(shiftInput.val() == 2){
            rateInput.val(data.night_cost);
        }
        if(shiftInput.val() == 3){
            rateInput.val(data.full_cost);
        }
    }
  }
  function changeDoctorRate2(){
    var dataStr = $('#Doctor2').find(':selected').attr('data-details');
    if(dataStr){
        var data = JSON.parse(dataStr);
        var rateInput = $('#DocAddCostRate'); 
        var shiftInput = $('#DocAddShift');

        if(shiftInput.val() == 1){
            rateInput.val(data.day_cost);
        }
        if(shiftInput.val() == 2){
            rateInput.val(data.night_cost);
        }
        if(shiftInput.val() == 3){
            rateInput.val(data.full_cost);
        }
    }
  }
  function openStaffAssignModal(id,date,type,shift,sell_rate){
    $('#Staff').val('').trigger('change');
    $('#CostRate').val('');

    $('#Staff_Assign_Id').val(id);
    $('#AssignDate').flatpickr({
      minDate: date,
      maxDate: date
    }).setDate(date, true);
    $('#Type').val(type).trigger('change');
    $('#Shift').val(shift).trigger('change');
    $('#CustomerRate').val(sell_rate);
    
    filterAndSetStaffOptions(type,shift,date);

    $('#AssignStaffCanvas').offcanvas('show');
  }
  function openDoctorAssignModal(id,date,type,shift,sell_rate){
    $('#Doctor').val('').trigger('change');
    $('#DocCostRate').val('');

    $('#Doctor_Assign_Id').val(id);
    $('#DocAssignDate').flatpickr({
      minDate: date,
      maxDate: date
    }).setDate(date, true);
    $('#DocShift').val(shift).trigger('change');
    $('#DocCustomerRate').val(sell_rate);

    filterAndSetDoctorOptions(shift,date,"Assign");

    $('#AssignDoctorCanvas').offcanvas('show');
  }
  function openAddDoctorAssignModal(booking_id,date){
    $('#Doctor2').val('').trigger('change');
    $('#DocAddCostRate').val('');

    $('#Doctor_Booking_Id').val(booking_id);
    $('#DocAddAssignDate').flatpickr({
      minDate: date,
      maxDate: date
    }).setDate(date, true);

    $('#AddAssignDoctorCanvas').offcanvas('show');
  }
  function filterAndSetDoctor(thiss){
    var select = $(thiss);
    var date = $('#DocAddAssignDate').val();
    var shift = select.find(':selected').val();
    if(date && shift){
      filterAndSetDoctorOptions(shift,date,"Create");
    }else{
      alert("Please select Shift");
    }
  }
  function filterAndSetStaffOptions(type,shift,date) {
    // Get the staff select element
      var staffSelect = $('#Staff');

      // Clear current options
      staffSelect.empty();

      // Add a default empty option
      staffSelect.append(new Option('', '', true, true)).trigger('change');

      $.ajax({
        url:"{{route('check_staff_availability')}}",
        method:"POST",
        data:{'type':type,'shift':shift,'date':date,_token:"{{ csrf_token() }}"},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(result)
        {
            console.log(result);
            $.each(result, function(index, item) {
              var optionText = `${item.f_name || ""}${item.m_name ? " " + item.m_name : ""}${item.l_name ? " " + item.l_name : ""} - ${item.staff_id}`;
              var option = new Option(optionText, item.id);
              $(option).attr('data-details', JSON.stringify(item)); // Store item details as JSON string
              staffSelect.append(option);
            });
            staffSelect.trigger('change');
        }
      }); 
  }
  function filterAndSetDoctorOptions(shift,date,type) {
    // Get the staff select element
      if(type == "Create"){
        var doctorSelect = $('#Doctor2');
      }else{
        var doctorSelect = $('#Doctor');
      }

      // Clear current options
      doctorSelect.empty();

      // Add a default empty option
      doctorSelect.append(new Option('', '', true, true)).trigger('change');

      $.ajax({
        url:"{{route('check_doctor_availability')}}",
        method:"POST",
        data:{'shift':shift,'date':date,_token:"{{ csrf_token() }}"},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(result)
        {
            console.log(result);
            $.each(result, function(index, item) {
              var optionText = item.name + " - " + item.doctor_id;
              var option = new Option(optionText, item.id);
              $(option).attr('data-details', JSON.stringify(item)); // Store item details as JSON string
              doctorSelect.append(option);
            });
            doctorSelect.trigger('change');
        }
      }); 
  }
  $('.StaffSelect').select2({
      placeholder: 'Select a staff',
      dropdownParent: $('#AssignStaffCanvas')
  });
  $('.DoctorSelect').select2({
      placeholder: 'Select a doctor',
      dropdownParent: $('#AssignDoctorCanvas')
  });
  $('.DoctorSelect2').select2({
      placeholder: 'Select a doctor',
      dropdownParent: $('#AddAssignDoctorCanvas')
  });
  $('.StaffTypeSelect').select2({
      placeholder: 'Select a staff type',
      dropdownParent: $('#AssignStaffCanvas')
  });
  $('.ShiftSelect').select2({
      placeholder: 'Select a shift',
      dropdownParent: $('#AssignStaffCanvas')
  });
  $('.ShiftSelect1').select2({
      placeholder: 'Select a shift',
      dropdownParent: $('#AssignDoctorCanvas')
  });
  $('.ShiftSelect2').select2({
      placeholder: 'Select a shift',
      dropdownParent: $('#AddAssignDoctorCanvas'),
      allowClear: true
  });
  $('#AssignDate').flatpickr({
        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d'
  });
</script>
@endsection
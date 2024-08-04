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
  #SelectCustomerType + .select2-container{
    width: 15%!important;
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
  <div class="col-6">
      <h4 class="mb-1">CRP</h4>
      <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Dashboard / CRP</p>
  </div>
  <div class="col-6 text-end pt-3">
    {{-- <select class="form-select" id="SelectCustomerType" onchange="changeCustomerType(this)">
      <option value="All" {{ session()->has('customerType') && session('customerType') === 'All' ? 'selected' : '' }}>All</option>
      <option value="DHC" {{ session()->has('customerType') && session('customerType') === 'DHC' ? 'selected' : '' }}>DHC</option>
      <option value="HSP" {{ session()->has('customerType') && session('customerType') === 'HSP' ? 'selected' : '' }}>HSP</option>
      <option value="CRP" {{ session()->has('customerType') && session('customerType') === 'CRP' ? 'selected' : '' }}>CRP</option>
    </select> --}}
  </div>
  @php
      $permissions = Auth::user() ? Auth::user()->permissions() : [];
  @endphp

  @if(!in_array('dashboard',$permissions))
  <div class="col-12">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-md-6 order-2 order-md-1">
          <div class="card-body">
            <h2 class="card-title mb-4">Welcome,<br><span class="fw-bold">{{Auth::user()->name ?? ""}}</span> 👋</h2>
            <h3>{{Auth::user()->role->name ?? ""}}</h3>
            <p class="mb-0">Sorry! You do not have the access in viewing the rest fortes as disciplined by the Super Admin.</p>
          </div>
        </div>
        <div class="col-md-6 text-center text-md-end order-1 order-md-2">
          <div class="card-body pb-0 px-0 pt-2">
            <img src="{{asset('public')}}/assets/img/illustrations/illustration-john-light.png" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="col-sm-12 col-lg-12">
    <div class="card text-center mb-4">
      <div class="card-header p-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs nav-fill" role="tablist" style="height: 60px;">
            @if(!empty($dates))
              @foreach($dates as $key => $date)
                <li class="nav-item" role="presentation">
                  <button type="button" style="height: 60px; background: #4cb7e5; color:#c5eeff; border:2px solid #4cb7e5;" class="nav-link d-flex flex-column gap-1 waves-effect  @if($key == 6)active @endif" onclick="getBookingDetailsByDate('{{$date}}','{{date('Y-m-d')}}')" role="tab" data-bs-toggle="tab" data-bs-target="#navs-card" aria-controls="navs-profile" aria-selected="true" tabindex="-1">{{date('M d', strtotime($date))}}</button>
                </li>
              @endforeach
            @endif
          </ul>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="tab-content p-0 pb-0">
          <div class="tab-pane fade text-start active show" id="navs-card" role="tabpanel">
            <table class="kt_datatable_main table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
              <thead>
                  <tr>
                    <th rowspan="2" style="border:1px solid #4cb7e5; background:#c5eeff; width:15%!important;">Customer Name</th>
                    <th colspan="{{count($staff_type)}}" style="border-bottom:1px solid #dfdfe2;">Staff</th>
                    <th rowspan="2" style="border-bottom:1px solid #dfdfe2; width:15%!important;">Doctor</th>
                  </tr>
                  <tr>
                    @if(!empty($staff_type))
                      @foreach($staff_type as $st)
                        <th colspan="1" style="border-bottom:1px solid #dfdfe2;">{{$st->title}}</th>
                      @endforeach
                    @endif
                  </tr>
              </thead>
              <tbody id="BookingsTable">
                  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
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
              Area
            </div>
            <div class="mt-1">
              City
            </div>
            <div class="mt-1">
              State
            </div>
            <div class="mt-1">
              Address
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
              : <span id="st_Area">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_City">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_State">-</span>
            </div>
            <div class="mt-1">
              : <span id="st_Address">-</span>
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
              Area
            </div>
            <div class="mt-1">
              City
            </div>
            <div class="mt-1">
              State
            </div>
            <div class="mt-1">
              Address
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
              : <span id="doc_Area">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_City">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_State">-</span>
            </div>
            <div class="mt-1">
              : <span id="doc_Address">-</span>
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
        <h5 class="modal-title" id="customerDetailsCanvasLabel" style="color:#4cb7e5;"><i class="ri-wheelchair-line ri-22px me-2"></i>Patient Details</h5>
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
                <b>Contact Number 2</b>
              </div>
              <div class="col-8">
                : <span id="cust_Mobile_2">-</span>
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
              <div class="col-2">
                <b>Age</b>
              </div>
              <div class="col-10">
                : <span id="cust_Age">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>Gender</b>
              </div>
              <div class="col-10">
                : <span id="cust_Gender">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>Address</b>
              </div>
              <div class="col-10">
                : <span id="cust_Address">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>Area</b>
              </div>
              <div class="col-10">
                : <span id="cust_Area">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>City</b>
              </div>
              <div class="col-10">
                : <span id="cust_City">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>State</b>
              </div>
              <div class="col-10">
                : <span id="cust_State">-</span>
              </div>
            </div>
          </div>
          <h5 class="modal-title my-4" style="color:#4cb7e5;"><i class="ri-calendar-schedule-line ri-22px me-2"></i>Booking Details</h5>
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
              <div class="col-2">
                <b>Type</b>
              </div>
              <div class="col-10">
                : <span id="cust_BookingType">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>Total</b>
              </div>
              <div class="col-10">
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
                  <th>Days/Qnt</th>
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
        <h5 class="modal-title" id="corporationDetailsCanvasLabel" style="color:#4cb7e5;"><i class="ri-building-line ri-22px me-2"></i>Corporation Details</h5>
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
              <div class="col-2">
                <b>Area</b>
              </div>
              <div class="col-10">
                : <span id="corp_Area">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>City</b>
              </div>
              <div class="col-10">
                : <span id="corp_City">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>State</b>
              </div>
              <div class="col-10">
                : <span id="corp_State">-</span>
              </div>
            </div>
          </div>
          <h5 class="modal-title my-4" style="color:#4cb7e5;"><i class="ri-calendar-schedule-line ri-22px me-2"></i>Booking Details</h5>
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
              <div class="col-2">
                <b>Type</b>
              </div>
              <div class="col-10">
                : <span id="corp_BookingType">-</span>
              </div>
            </div>
            <div class="mt-1 row">
              <div class="col-2">
                <b>Total</b>
              </div>
              <div class="col-10">
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
                  <th>Days/Qnt</th>
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
              <input type="text" class="form-control" placeholder="DD-MM-YYYY" id="AssignDateShow" readonly/>
              <input type="text" class="form-control d-none" name="date" placeholder="DD-MM-YYYY" id="AssignDate" readonly/>
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
              <input type="text" class="form-control" name="date" placeholder="DD-MM-YYYY" id="DocAssignDateShow" readonly/>
              <input type="text" class="form-control d-none" name="date" placeholder="DD-MM-YYYY" id="DocAssignDate" readonly/>
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
              <input type="text" class="form-control" placeholder="DD-MM-YYYY" id="DocAddAssignDateShow" readonly/>
              <input type="text" class="form-control d-none" name="date" placeholder="DD-MM-YYYY" id="DocAddAssignDate" readonly/>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="AddAssignStaffCanvas" aria-labelledby="AddAssignStaffCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AddAssignStaffCanvasLabel">Add & Assign Staff</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('add_assign_single_staff')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
              <input type="text" class="form-control d-none" name="booking_id" id="Staff_Booking_Id">
              <input type="text" class="form-control" placeholder="DD-MM-YYYY" id="StaffAddAssignDateShow" readonly/>
              <input type="text" class="form-control d-none" name="date" placeholder="DD-MM-YYYY" id="StaffAddAssignDate" readonly/>
              <label for="StaffAddAssignDate">Assign Date</label>
          </div>
          @error('date')
              <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <input type="hidden" class="form-control" name="staff_type_id" id="StaffTypeId" readonly>
            <input type="text" class="form-control" name="staff_type" id="StaffType" readonly>
            <label>Type</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="ShiftSelect4 select2 form-select" name="shift" id="StaffAddShift" onchange="filterAndSetStaff(this)" required>
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
              <input type="text" class="form-control" name="sell_rate" placeholder="00" id="StaffAddSellRate" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
              <label>Customer Rate</label>
          </div>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="StaffSelect2 select2 form-select" name="staff_id" id="Staff2" required onchange="changeStaffRate2()">
                <option></option>
            </select>
            <label>Select Staff</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="input-group input-group-merge">
            <span class="input-group-text">₹</span>
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="cost_rate" placeholder="00" required id="StaffAddCostRate" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="AddEquipmentsCanvas" aria-labelledby="AddEquipmentsCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AddEquipmentsCanvasLabel">Add Equipment</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('add_single_equipment')}}" method="POST">
      @csrf
      <div class="row">
        <div class="mb-2 col-12 mb-6">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control d-none" name="booking_id" id="Equipment_Booking_Id" value="">
                <input type="text" class="form-control d-none" name="date" id="Equipment_Booking_Date" value="">
                <select class="EquipmentSelect select2 form-select equipment-select" name="name" id="SelectEquipment" onchange="addEquipmentRate(this)" required>
                  <option value="" disabled selected>Select equipment</option>
                  @if(!empty($equipments))
                      @foreach($equipments as $equipment)
                          <option value="{{$equipment->id}}" data-rate="{{$equipment->sell_price ?? 0}}" data-type="{{$equipment->type ?? ""}}">{{$equipment->name}}</option>
                      @endforeach
                  @endif
                </select>
                <label for="form-repeater-1-1">Type</label>
            </div>
        </div>
        <div class="col-12 mb-6 d-none">
          <div class="input-group input-group-merge">
            <span class="input-group-text">₹</span>
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" name="cost_rate" id="Equipment_Cost_Price" readonly placeholder="00" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                <label>Cost Rate</label>
            </div>
          </div>
        </div>
        <div class="mb-2 col-12 mb-6">
            <div class="form-floating form-floating-outline">
                <select class="form-select equipment-qnt-input" id="EquipmentQnt" name="qnt" onchange="multiplyEquipmentRate(this)" required disabled>
                    <option value="" disabled selected>Select quantity</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                <label for="EquipmentQnt" id="Equipment_Label">Quantity / Rental Days</label>
            </div>
        </div>
        <div class="col-12">
          <div class="input-group input-group-merge">
            <span class="input-group-text text-secondary">₹</span>
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" name="sell_rate" id="Equipment_Sell_Price" value="" placeholder="00" readonly>
              <label>Customer Rate</label>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="AddAmbulanceCanvas" aria-labelledby="AddAmbulanceCanvasLabel">
  <div class="offcanvas-header">
    <h5 id="AddAmbulanceCanvasLabel">Add Ambulance</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{route('add_single_ambulance')}}" method="POST">
      @csrf
      <div class="row">
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control d-none" name="booking_id" id="Ambulance_Booking_Id" value="">
            <input type="text" class="form-control d-none" name="date" id="Ambulance_Booking_Date" value="">
            <input type="text" class="form-control" name="type" value="Ambulance" readonly>
            <label>Type</label>
          </div>
        </div>
        <div class="col-12 mt-5">
          <div class="form-floating form-floating-outline">
            <select class="ShiftSelect3 select2 form-select" name="shift" required onchange="addAmbulanceRate(this)">
                <option value="" disabled selected>Select shift</option>
                @if(!empty($shifts))
                    @foreach($shifts as $shift)
                        <option value="{{$shift->id}}" data-details="{{$ambulance ?? ""}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
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
              <input type="text" class="form-control" name="sell_rate" id="AmbulanceRate" readonly placeholder="00" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
              <label>Customer Rate</label>
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
   $(document).ready(function() {
    var date = new Date();

    // Helper function to pad single digit numbers with leading zero
    function pad(number) {
        return number < 10 ? '0' + number : number;
    }

    // Extract year, month, and day
    var year = date.getFullYear();
    var month = pad(date.getMonth() + 1); // getMonth() is zero-based
    var day = pad(date.getDate());

    // Format date as yyyy-mm-dd
    var formattedDate = year + '-' + month + '-' + day;
    getBookingDetailsByDate(formattedDate, formattedDate);
  });
  var table = $('.kt_datatable_main').DataTable({
      dom:'',
      paging: false,
      // processing: true,
      // lengthMenu: [[ 5, 15, 25, 100, -1 ], [ 5, 15, 25, 100, "All" ]],
      columnDefs: [{
          "defaultContent": "-",
          "targets": "_all",
      }],
      deferRender: true,
  });
  $('.kt_datatable').DataTable({
    dom:'',
    columnDefs: [{
        "defaultContent": "-",
        "targets": "_all",
    }],
  });
 
  function getBookingDetailsByDate(date, today){
    $("#loader").fadeIn("slow");
    $("#DATAAA").fadeOut("slow");
    table.clear().draw();
    console.log(date);
    $.ajax({
        url:"{{route('get_crp_dashboard_booking_data')}}",
        method:"POST",
        data:{'date':date,_token:"{{ csrf_token() }}"},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(result)
        {
          table.clear().draw();
          console.log(result);
          populateTable(result.bookings, result.staff_type, date, today, table);
          $("#loader").fadeOut("slow");
          $("#DATAAA").fadeIn("slow");
        }
    }); 
  }
  function populateTable(bookings, staff_type, date, today, table) {

    var permissions = @json($permissions);
    // Check if bookings are available
    if (bookings && bookings.length > 0) {
        $.each(bookings, function(index, booking) {
            if (date >= booking.start_date && date <= booking.end_date) {
                var row = '<tr>';

                // Customer details column
                var customerDetails = '<td style="background: #c5eeff; border:1px solid #4cb7e5; text-align:center; width:15%!important;">';
                customerDetails += '<div class="row">';
                customerDetails += '<div class="col-12">';
                customerDetails += '<div class="row">';
                customerDetails += '<div class="col-8 text-start">';
                customerDetails += booking.customer_details.name;

                // Booking type
                customerDetails += '<br><b style="font-size: 12px;">';
                if (booking.booking_type == "Patient") {
                    if (booking.customer_details.h_type == "DHC") {
                        customerDetails += '(DHC)';
                    } else {
                        customerDetails += '(HSP)';
                    }
                } else {
                    customerDetails += '(CRP)';
                }
                customerDetails += '</b><br><span style="font-size: 12px;">' + booking.unique_id + '</span><br>';
                customerDetails += '</div>';

                // Customer details button
                customerDetails += '<div class="col-4 d-flex justify-content-center align-items-center">';
                customerDetails += '<button class="badge badge-center bg-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Customer Details" data-bs-custom-class="tooltip-dark" onclick=\'openCustomerDetailsModal(' + JSON.stringify(booking) + ')\'' + ' type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>';
                customerDetails += '</div>';
                customerDetails += '</div>';
                customerDetails += '</div>';

                // Add Ambulance and Equipments buttons
                if ($.inArray('bookings', permissions) !== -1) {
                    if (date >= today) {
                        customerDetails += '<div class="col-12 text-center mt-2">';
                        customerDetails += `<button class="badge badge-center bg-white border border-primary text-primary me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add Ambulance" data-bs-custom-class="tooltip-dark" onclick="addAmbulanceCanvas('` + booking.id + `', '` + date + `')" type="button" style="line-height: 10px;"><i class="ri-taxi-line"></i></button>`;
                        customerDetails += `<button class="badge badge-center bg-white border border-primary text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add Equipments" data-bs-custom-class="tooltip-dark" onclick="addEquipmentsCanvas('` + booking.id + `', '` + date + `')" type="button" style="line-height: 10px;"><i class="ri-syringe-line"></i></button>`;
                        customerDetails += '</div>';
                    }
                }
                customerDetails += '</div>';
                customerDetails += '</td>';
                row += customerDetails;

                // Staff details columns
                if (staff_type && staff_type.length > 0) {
                  $.each(staff_type, function(stIndex, st) {
                    var staffDetails = '<td style="width:' + (70 / staff_type.length) + '%!important;">';
                    if (booking.staff_data && booking.staff_data.length > 0) {
                        var staff_found = false;
                        $.each(booking.staff_data, function(stfIndex, stf) {
                          if(stf.is_cancled == 0 ){
                            if(stf.staff){
                              if (stf.type == st.title && date == stf.date) {
                                  staffDetails += '<div class="row p-1">';
                                  staffDetails += '<div class="col-8 text-start">';
                                  if (stf.staff) {
                                      staffDetails += `${stf.staff.f_name || ""}${stf.staff.m_name ? " " + stf.staff.m_name : ""}${stf.staff.l_name ? " " + stf.staff.l_name : ""}` + '<br>';
                                  }
                                  staffDetails += '<b style="font-size: 12px;" class="me-1">' + stf.shiftt.name + '</b>';
                                  if (stf.att_marked == 0) {
                                      staffDetails += '<span class="badge bg-label-secondary" style="font-size: 10px;">Not Marked</span>';
                                  } else {
                                      if (stf.status == 0) {
                                          staffDetails += '<span class="badge bg-label-primary" style="font-size: 10px;">Marked</span>';
                                      } else if (stf.status == 1) {
                                          staffDetails += '<span class="badge bg-label-success" style="font-size: 10px;">Approved</span>';
                                      } else if (stf.status == 2) {
                                          staffDetails += '<span class="badge bg-label-danger" style="font-size: 10px;">Rejected</span>';
                                      }
                                  }
                                  staffDetails += '</div>';
                                  staffDetails += '<div class="col-4">';
                                  if ($.inArray('assign_bookings', permissions) !== -1) {
                                      staffDetails += `<button class="badge badge-center bg-label-secondary border-none mt-1 me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Staff" data-bs-custom-class="tooltip-dark" onclick="openStaffAssignModal('`+ stf.id +`','`+ stf.date +`','`+ st.id +`', '`+ stf.shiftt.id +`' , '`+ stf.sell_rate +`')" type="button" style="line-height: 10px;"><i class="ri-pencil-line"></i></button>`;
                                  }
                                  if (date < today && stf.att_marked == 0) {
                                      staffDetails += `<button class="badge badge-center bg-label-primary border-none mt-1  me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mark Attendance" data-bs-custom-class="tooltip-dark" onclick="markAttendance('` + stf.id + `', '`+ date +`','`+ today +`')" type="button" style="line-height: 10px;"><i class="ri-calendar-check-line"></i></button>`;
                                  }
                                  staffDetails += '<button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Staff Details" data-bs-custom-class="tooltip-dark" onclick=\'openStaffDetailsModal(' + JSON.stringify(stf.staff) + ')\'' + ' type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>';
                                  staffDetails += '</div>';
                                  staffDetails += '</div>';
                                  staff_found = true;
                              }
                            }else{
                              if(stf.type == st.title && date == stf.date && stf.booking_status == 0){
                                staffDetails += `<div class="row p-1">
                                    <div class="col-8 pt-2 text-start">
                                      <b style="font-size: 12px;"> ` + stf.shiftt.name + `</b>
                                    </div>
                                    <div class="col-4">`;
                                      if ($.inArray('assign_bookings', permissions) !== -1) {
                                        staffDetails += `<button class="badge badge-center bg-warning border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Assign Staff" data-bs-custom-class="tooltip-dark" onclick="openStaffAssignModal('`+ stf.id +`','`+ stf.date +`','`+ st.id +`', '`+ stf.shiftt.id +`' , '`+ stf.sell_rate +`')" type="button" style="line-height: 0px;"><i class="ri-user-follow-line"></i></button>`;
                                      }
                                    staffDetails += `</div></div>`
                                  staff_found = true;
                              }
                            }
                          }
                        });
                        if ($.inArray('assign_bookings', permissions) !== -1 && $.inArray('bookings', permissions) !== -1) {
                            staffDetails += '<div class="text-center mt-2 py-3" style="background:#c5eeff;">';
                            staffDetails += `<button class="badge badge-center bg-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add ` + st.title + `" data-bs-custom-class="tooltip-dark" onclick="openAddStaffAssignModal('`+ booking.id +`', '`+ date +`', '`+ st.title +`', '`+ st.id +`')" type="button" style="line-height: 0px;"><i class="ri-add-line"></i></button>`;
                            staffDetails += '</div>';
                        }
                    }
                    staffDetails += '</td>';
                    row += staffDetails;
                  });
                } else {
                    row += '<td> __</td>';
                }

                // Doctor details column
                var doctorDetails = '<td style="width:15%!important;">';
                if (booking.doctor_data && booking.doctor_data.length > 0) {
                  var doctor_found = false;
                  $.each(booking.doctor_data, function(dctIndex, dct) {
                    if(dct.doctor){
                      if (dct.is_cancled == 0 && date == dct.date) {
                        doctorDetails += '<div class="row p-1">';
                        doctorDetails += '<div class="col-8 text-start">';
                        if (dct.doctor) {
                            doctorDetails += dct.doctor.name + '<br>';
                        }
                        doctorDetails += '<b style="font-size: 12px;">' + dct.shiftt.name + '</b>';
                        if (dct.att_marked == 0) {
                            doctorDetails += '<span class="badge bg-label-secondary" style="font-size: 10px;">Not Marked</span>';
                        } else {
                            if (dct.status == 0) {
                                doctorDetails += '<span class="badge bg-label-primary" style="font-size: 10px;">Marked</span>';
                            } else if (dct.status == 1) {
                                doctorDetails += '<span class="badge bg-label-success" style="font-size: 10px;">Approved</span>';
                            } else if (dct.status == 2) {
                                doctorDetails += '<span class="badge bg-label-danger" style="font-size: 10px;">Rejected</span>';
                            }
                        }
                        doctorDetails += '</div>';
                        doctorDetails += '<div class="col-4">';
                        if ($.inArray('assign_bookings', permissions) !== -1) {
                            doctorDetails += `<button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit Staff" data-bs-custom-class="tooltip-dark" onclick="openDoctorAssignModal('`+ dct.id +`','`+ dct.date +`','Doctor', '`+ dct.shiftt.id +`', '`+ dct.sell_rate +`')" type="button" style="line-height: 10px;"><i class="ri-pencil-line"></i></button>`;
                        }
                        if (date < booking.start_date && dct.att_marked == 0) {
                            doctorDetails += `<button class="badge badge-center bg-label-primary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Mark Attendance" data-bs-custom-class="tooltip-dark" onclick="markDoctorAttendance('` + dct.id + `')" type="button" style="line-height: 10px;"><i class="ri-calendar-check-line"></i></button>`;
                        }
                        doctorDetails += '<button class="badge badge-center bg-label-secondary border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Staff Details" data-bs-custom-class="tooltip-dark" onclick=\'openDoctorDetailsModal(' + JSON.stringify(dct.doctor) + ')\'' + ' type="button" style="line-height: 10px;"><i class="ri-eye-line"></i></button>';
                        doctorDetails += '</div>';
                        doctorDetails += '</div>';
                        doctor_found = true;
                      }
                    }else{
                      if(date == dct.date && dct.booking_status == 0){
                        doctorDetails += `<div class="row p-1">
                          <div class="col-8 pt-2 text-start">
                            <b style="font-size: 12px;">`+ dct.shiftt.name + `</b>
                          </div>
                          <div class="col-4">`;
                            if ($.inArray('assign_bookings', permissions) !== -1) {
                              doctorDetails += `<button class="badge badge-center bg-warning border-none mt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Assign Doctor" data-bs-custom-class="tooltip-dark" onclick="openDoctorAssignModal('`+ dct.id +`','`+ dct.date +`','Doctor', '`+ dct.shiftt.id +`', '`+ dct.sell_rate +`')"  style="line-height: 0px;"><i class="ri-user-follow-line"></i></button>`;
                            }
                        doctorDetails += `</div></div>`;
                        doctor_found = true;
                      }
                    }
                  });
                }
                if ($.inArray('assign_bookings', permissions) !== -1 && $.inArray('bookings', permissions) !== -1) {
                  doctorDetails += '<div class="text-center mt-2 py-3" style="background:#c5eeff;">';
                  doctorDetails += `<button class="badge badge-center bg-primary border-none" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add Doctor" data-bs-custom-class="tooltip-dark" onclick="openAddDoctorAssignModal('` + booking.id + `','` + date + `')" type="button" style="line-height: 0px;"><i class="ri-add-line"></i></button>`;
                  doctorDetails += '</div>';
                }
                doctorDetails += '</td>';
                row += doctorDetails;
                row += '</tr>';

                // Append row to DataTable
                table.row.add($(row));
              }
        });

        // Redraw the table
        table.draw();
    } else {
        table.row.add(['<tr><td colspan="100%">No bookings found for this date.</td></tr>']);
    }

    // Redraw the table
    // table.draw();
  }
  // function changeCustomerType(thiss){
  //   var select = $(thiss);
  //   var type = select.find(':selected').val();

  //   $.ajax({
  //       url:"{{route('change_customer_type')}}",
  //       method:"POST",
  //       data:{'type':type,_token:"{{ csrf_token() }}"},
  //       headers: {
  //           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //       },
  //       success:function(result)
  //       {
  //         location.reload();
  //       }
  //   }); 
  // }
  function openCustomerDetailsModal(data) {
    // var data = JSON.parse(customer);
    console.log(data);
    if(data.customer_details.dob){
      var date = moment(data.customer_details.dob).format('DD/MM/YYYY');
    }else{
      var date = "-";
    }
    if(data.booking_type == "Patient"){
      $('#cust_Id').text(data.customer_details.patient_id || '-');
      $('#cust_Type').text((data.customer_details.h_type || '-'));
      $('#cust_Name').text((data.customer_details.name || '-'));
      $('#cust_Email').text(data.customer_details.email || '-');
      $('#cust_Mobile').text(data.customer_details.mobile || '-');
      $('#cust_Mobile_2').text(data.customer_details.mobile2 || '-');
      $('#cust_Dob').text(date);
      $('#cust_Age').text((data.customer_details.age ? data.customer_details.age + " Years" : '-'));
      $('#cust_Gender').text(data.customer_details.gender || '-');
      $('#cust_Address').text(data.customer_details.address || '-');
      $('#cust_State').text(data.customer_details.state.name || '-');
      $('#cust_City').text(data.customer_details.city.name || '-');
      $('#cust_Area').text(data.customer_details.area.name || '-');

      $('#cust_BookingId').text(data.unique_id || '-');
      $('#cust_BookingType').text(data.booking_type || '-');
      $('#cust_BookingStart').text(moment(data.start_date).format('DD/MM/YYYY') || '-');
      $('#cust_BookingEnd').text(moment(data.end_date).format('DD/MM/YYYY') || '-');
      $('#cust_BookingTotal').text('₹'+ parseInt(data.total,10).toLocaleString() || '-');

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
          var rate = item.sell_rate;
          if(item.type == 1){
            rate *= item.qnt;
          }
          if(item.shift){
            var shift_name = item.shift.name;
          }else{
            var shift_name = "-";
          }
          bookingData += `<tr>
                              <td>`+ srno +`</td>
                              <td>`+ (item.name ?? "-") +`</td>
                              <td>`+ type +`</td>
                              <td>`+ (shift_name ?? "-") +`</td>
                              <td>`+ (item.qnt ?? "-") +`</td>
                              <td>`+ ('₹'+  parseInt(rate,10).toLocaleString() ?? "-") +`</td>
                          </tr>`;
      });
      $('#cust_BookingData').html(bookingData);

      
      $('#customerDetailsCanvas').modal('show');
    }else{
      $('#corp_Name').text((data.customer_details.name || '-'));
      $('#corp_Mobile').text(data.customer_details.mobile1 || '-');
      $('#corp_Mobile2').text(data.customer_details.mobile2 || '-');
      $('#corp_Address').text(data.customer_details.address || '-');
      $('#corp_State').text(data.customer_details.state.name || '-');
      $('#corp_City').text(data.customer_details.city.name || '-');
      $('#corp_Area').text(data.customer_details.area.name || '-');

      $('#corp_BookingId').text(data.unique_id || '-');
      $('#corp_BookingType').text(data.booking_type || '-');
      $('#corp_BookingStart').text(moment(data.start_date).format('DD/MM/YYYY') || '-');
      $('#corp_BookingEnd').text(moment(data.end_date).format('DD/MM/YYYY') || '-');
      $('#corp_BookingTotal').text('₹'+ parseInt(data.total,10).toLocaleString() || '-');

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
          var rate = item.sell_rate;
          if(item.type == 1){
            rate *= item.qnt;
          }

          bookingData += `<tr>
                              <td>`+ srno +`</td>
                              <td>`+ (item.name ?? "-") +`</td>
                              <td>`+ type +`</td>
                              <td>`+ (item.shift.name ?? "-") +`</td>
                              <td>`+ (item.qnt ?? "-") +`</td>
                              <td>`+ ('₹'+ parseInt(rate,10).toLocaleString() ?? "-") +`</td>
                          </tr>`;
      });
      $('#corp_BookingData').html(bookingData);


      $('#corporationDetailsCanvas').modal('show');
    }
  }
  function addAmbulanceRate(thiss) {
    var select = $(thiss);
    var data = select.find(':selected').data('details');
    var rateInput = $('#AmbulanceRate');
    var rate = 0;
    if(data){
        if(select.val() == 1){
            rate = data.day_cost || 0;
        }else if(select.val() == 2){
            rate = data.night_cost || 0;
        }else if(select.val() == 3){
            rate = data.full_cost || 0;
        }
    }
    rateInput.val(rate);
    rateInput.prop("readonly", false);
  }
  function multiplyEquipmentRate(thiss){
    var select = $(thiss);
    var qnt = select.find(':selected').val();
    var selectInput = $('#SelectEquipment');
    var oldrate = selectInput.find(':selected').data('rate');
    var sellRateInput = $('#Equipment_Sell_Price');
    var rate = parseInt(oldrate) * parseInt(qnt);
    sellRateInput.val(rate);
  }
  function addEquipmentRate(thiss) {
    var select = $(thiss);
    var rate = select.find(':selected').data('rate');
    var type = select.find(':selected').data('type');
    var costRateInput = $('#Equipment_Cost_Price');
    var sellRateInput = $('#Equipment_Sell_Price');
    var qutInput = $('#EquipmentQnt');
    if(type == "Rent"){
        var label = "Rental Days";
    }else{
        var label = "Quantity";
    }
    console.log(label);
    $('#Equipment_Label').text(label);
    costRateInput.val(rate);
    sellRateInput.val(rate);
    qutInput.val(1);
    qutInput.prop("disabled", false);
    sellRateInput.prop("readonly", false);
  }
  function openStaffDetailsModal(data) {
    console.log(data);
    // var data = JSON.parse(staff);
    // var data = $.parseJSON(JSON.stringify(staff));
    if(data.dob){
      var date = moment(data.dob).format('DD/MM/YYYY');
    }else{
      var date = "-";
    }
    if(data.age){
      var age = data.age + " Years"
    }else{
      var age = "-";
    }
    $('#st_Id').text(data.staff_id || '-');
    $('#st_Name').text((data.f_name || '-') + ' ' + (data.m_name || '') + ' ' + (data.l_name || ''));
    $('#st_Type').text(data.types.title || '-');
    $('#st_Email').text(data.email || '-');
    $('#st_Mobile').text(data.mobile || '-');
    $('#st_Mobile2').text(data.mobile2 || '-');
    $('#st_Dob').text(date);
    $('#st_Age').text(age);
    $('#st_Gender').text(data.gender || '-');
    $('#st_Address').text(data.address || '-');
    $('#st_State').text(data.state.name || '-');
    $('#st_City').text(data.city.name || '-');
    $('#st_Area').text(data.area.name || '-');
    $('#staffDetailsCanvas').modal('show');
  }
  function openDoctorDetailsModal(data) {
    // var data = JSON.parse(doctor);
    if(data.dob){
      var date = moment(data.dob).format('DD/MM/YYYY');
    }else{
      var date = "-";
    }
    if(data.age){
      var age = data.age + " Years"
    }else{
      var age = "-";
    }
    $('#doc_Name').text((data.name || '-'));
    $('#doc_Id').text(data.doctor_id || '-');
    $('#doc_Type').text('Doctor');
    $('#doc_Email').text(data.email || '-');
    $('#doc_Mobile').text(data.mobile || '-');
    $('#doc_Dob').text(date);
    $('#doc_Age').text(age);
    $('#doc_Gender').text(data.gender || '-');
    $('#doc_Address').text(data.address || '-');
    $('#doc_State').text(data.state.name || '-');
    $('#doc_City').text(data.city.name || '-');
    $('#doc_Area').text(data.area.name || '-');
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
  function changeStaffRate2(){
    var dataStr = $('#Staff2').find(':selected').attr('data-details');
    if(dataStr){
        var data = JSON.parse(dataStr);
        var rateInput = $('#StaffAddCostRate'); 
        var shiftInput = $('#StaffAddShift');

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

    var date2 = moment(new Date(date)).format("DD-MM-YYYY");
    console.log(date2);
    $('#AssignDateShow').flatpickr({
      minDate: date,
      maxDate: date,
      altInput: true,
      altFormat: 'd-m-Y',
      dateFormat: 'd-m-Y'
    }).setDate(date2, true);

    $('#Type').val(type).trigger('change');
    $('#Shift').val(shift).trigger('change');
    $('#CustomerRate').val(sell_rate);
    
    filterAndSetStaffOptions(type,shift,date,'Assign');

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

    var date2 = moment(new Date(date)).format("DD-MM-YYYY");
    console.log(date2);
    $('#DocAssignDateShow').flatpickr({
      minDate: date,
      maxDate: date,
      altInput: true,
      altFormat: 'd-m-Y',
      dateFormat: 'd-m-Y'
    }).setDate(date2, true);

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

    var date2 = moment(new Date(date)).format("DD-MM-YYYY");
    console.log(date2);
    $('#DocAddAssignDateShow').flatpickr({
      minDate: date,
      maxDate: date,
      altInput: true,
      altFormat: 'd-m-Y',
      dateFormat: 'd-m-Y'
    }).setDate(date2, true);

    $('#AddAssignDoctorCanvas').offcanvas('show');
  }
  function openAddStaffAssignModal(booking_id,date,type,type_id){
    $('#Staff2').empty().trigger('change');
    $('#StaffAddShift').val('').trigger('change');
    $('#StaffAddCostRate').val('');
    $('#StaffAddSellRate').val('');
    $('#StaffType').val(type);
    $('#StaffTypeId').val(type_id);

    $('#Staff_Booking_Id').val(booking_id);

    $('#StaffAddAssignDate').flatpickr({
      minDate: date,
      maxDate: date
    }).setDate(date, true);

    var date2 = moment(new Date(date)).format("DD-MM-YYYY");
    console.log(date2);
    $('#StaffAddAssignDateShow').flatpickr({
      minDate: date,
      maxDate: date,
      altInput: true,
      altFormat: 'd-m-Y',
      dateFormat: 'd-m-Y'
    }).setDate(date2, true);

    $('#AddAssignStaffCanvas').offcanvas('show');
  }
  function addEquipmentsCanvas(booking_id,date){
    $('#Equipment_Booking_Id').val(booking_id);
    $('#Equipment_Booking_Date').val(date);
    $('#AddEquipmentsCanvas').offcanvas('show');
  }
  function addAmbulanceCanvas(booking_id,date){
    $('#Ambulance_Booking_Id').val(booking_id);
    $('#Ambulance_Booking_Date').val(date);
    $('#AddAmbulanceCanvas').offcanvas('show');
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
  function filterAndSetStaff(thiss){
    var select = $(thiss);
    var type = $('#StaffTypeId').val();
    var date = $('#StaffAddAssignDate').val();
    var shift = select.find(':selected').val();
    if(date && shift){
      filterAndSetStaffOptions(type,shift,date,"Create");
    }
  }
  function filterAndSetStaffOptions(type,shift,date,type2) {
      if(type2 == "Create"){
        var staffSelect = $('#Staff2');
      }else{
        var staffSelect = $('#Staff');
      }

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
  function markAttendance(id,date,today){
    Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    customClass: {
      confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
      cancelButton: 'btn btn-outline-secondary waves-effect'
    },
    buttonsStyling: false
    }).then(function(result) {
        if(result.dismiss != 'cancel'){
            $.ajax({
                url:"{{route('mark_attandance')}}",
                method:"POST",
                data:{'id':id,_token:"{{ csrf_token() }}"},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(result)
                {
                    Swal.fire({
                        title: 'Marked!',
                        text: "The attendance marked successfully!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        },
                        buttonsStyling: false
                    }); 
                    getBookingDetailsByDate(date, today)
                    // setTimeout(function(){ window.location.reload(); }, 500);
                }
            }); 
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
  $('#SelectCustomerType').select2({
      placeholder: 'Select a type',
  });
  $('.StaffSelect').select2({
      placeholder: 'Select a staff',
      dropdownParent: $('#AssignStaffCanvas')
  });
  $('.StaffSelect2').select2({
      placeholder: 'Select a staff',
      dropdownParent: $('#AddAssignStaffCanvas')
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
  $('.ShiftSelect3').select2({
      placeholder: 'Select a shift',
      dropdownParent: $('#AddAmbulanceCanvas'),
      allowClear: true
  });
  $('.ShiftSelect4').select2({
      placeholder: 'Select a shift',
      dropdownParent: $('#AddAssignStaffCanvas'),
      allowClear: true
  });
  $('#AssignDate').flatpickr({
        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d'
  });
</script>
@endsection
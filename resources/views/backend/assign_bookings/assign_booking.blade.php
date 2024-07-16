@extends('backend.components.header')

@section('css')
<style>
    #CustomerDetails {
      display: none; /* Ensure it's hidden initially */
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
@if(session()->has('bulk_error'))
    @foreach(session()->get('bulk_error') as $error)
    <div class="alert alert-danger d-flex align-items-center p-3 mt-4" role="alert">
        <span>{{ $error }}</span>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ri-close-line text-danger"></i>
        </button>
    </div>
    @endforeach
@endif
<div class="row">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5 row">
                <div class="col-6 p-0 pt-1">
                    <h5 class="mb-0"><i class="ri-information-line fs-3"></i> Assign Booking | {{$booking->unique_id}}</h5>
                </div>
                <div class="col-6 text-end p-0">
                    <button class="btn btn-primary waves-effect waves-light me-2" id="showHideDetails"><span class="me-1"><i class="ri-eye-line me-1"></i> View</span>{{$booking->booking_type}} Details</button>
                </div>
            </div>
            <hr>
            <form id="Form" action="{{route('store_assign_booking',$booking->id)}}" method="post">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div id="CustomerDetails">
                            @if($booking->booking_type == "Patient")
                            <h6 ><i class="ri-information-2-line ri-24px"></i> Patient Details :</h6>
                            <div class="row mx-5">
                                <div class="col-2">
                                    <p class="text-nowrap mb-2"><i class="ri-hospital-line ri-20px me-2"></i>Hospital</p>
                                    <p class="text-nowrap mb-2"><i class="ri-user-line ri-20px me-2"></i>Full Name</p>
                                    <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Mobile</p>
                                    <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Mobile 2</p>
                                    <p class="text-nowrap mb-2"><i class="ri-mail-line ri-20px me-2"></i>Email</p>
                                    <p class="text-nowrap mb-2"><i class="ri-calendar-event-line ri-20px me-2"></i>DOB</p>
                                    <p class="text-nowrap mb-0"><i class="ri-calendar-schedule-line ri-20px me-2"></i>Age</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->h_type ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->name ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->mobile ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->mobile2 ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->email ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{date('d/m/Y',strtotime($booking->customer_details->dob)) ?? "-"}}</p>
                                    <p class="text-nowrap mb-0"><span class="me-5">:</span> {{$booking->customer_details->age ?? "-"}}</p>
                                </div>
                                <div class="col-2">
                                    <p class="text-nowrap mb-2"><i class="ri-men-line ri-20px me-2"></i>Gender</p>
                                    <p class="text-nowrap mb-2"><i class="ri-home-2-line ri-20px me-2 ms-50"></i>Address</p>
                                    <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State</p>
                                    <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City</p>
                                    <p class="text-nowrap mb-0"><i class="ri-compass-line ri-20px me-2"></i>Area</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->gender ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->address ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->state ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->city ?? "-"}}</p>
                                    <p class="text-nowrap mb-0"><span class="me-5">:</span> {{$booking->area ?? "-"}}</p>
                                </div>
                            </div>
                            @endif
                            @if($booking->booking_type == "Corporate")
                            <h6 ><i class="ri-information-2-line ri-24px"></i> Corporate Details :</h6>
                            <div class="row mx-5">
                                <div class="col-2">
                                    <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2"></i>Corporate Name</p>
                                    <p class="text-nowrap mb-2"><i class="ri-map-pin-line ri-20px me-2"></i>Address</p>
                                    <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 1</p>
                                    <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 2</p>
                                    <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State</p>
                                    <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City</p>
                                    <p class="text-nowrap mb-0"><i class="ri-compass-line ri-20px me-2"></i>Area</p>
                                </div>
                                <div class="col-4">
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->name ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->address ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->mobile1 ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->customer_details->mobile2 ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->state ?? "-"}}</p>
                                    <p class="text-nowrap mb-2"><span class="me-5">:</span> {{$booking->city ?? "-"}}</p>
                                    <p class="text-nowrap mb-0"><span class="me-5">:</span> {{$booking->area ?? "-"}}</p>
                                </div>
                            </div>
                            @endif
                            <hr class="mt-5">
                        </div>
                        <h6><i class="ri-calendar-line ri-22px"></i> Booking Date</h6>
                        <div class="row mb-4">
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control d-none" name="booking_id" value="{{$booking->id}}"/>
                                    <input type="text" class="form-control Date" value="{{$booking->start_date}}"  disabled/>
                                    <label>Start Date</label>
                                </div>
                               
                            </div>
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control Date" value="{{$booking->end_date}}" disabled/>
                                    <label>End Date</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-repeater">
                            <div class="mb-6 d-none justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-calendar-event-line ri-22px"></i> Assign Dates</h6>
                            </div>
                            <div data-repeater-list="data">
                                <div data-repeater-item>
                                    <hr class="mb-12 d-none">
                                    <div class="d-none">
                                        <div class="row">
                                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control StartDate" name="start_date" id="BookingStartDate" value="{{$booking->start_date}}" placeholder="DD-MM-YYYY" readonly/>
                                                    <label for="BookingStartDate">Start Date</label>
                                                </div>
                                                @error('start_date')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control EndDate" name="end_date" id="BookingEndDate" value="{{$booking->end_date}}" placeholder="DD-MM-YYYY" readonly />
                                                    <label for="BookingEndDate">End Date</label>
                                                </div>
                                                @error('end_date')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                            {{-- <div class="mb-2 col-lg-1 col-xl-1 col-12  text-end pe-12">
                                               
                                            </div>
                                            <div class="mb-2 col-lg-1 col-xl-1 col-12  text-end pe-12">
                                                <p class="rounded btn-icon border border-danger mt-1" style="cursor: pointer;" data-repeater-delete>
                                                    <i class="ri-delete-bin-line text-danger"></i>
                                                </p>
                                            </div> --}}
                                        </div>
                                    </div>
                                    @if(!empty($staff_data))
                                    <div class="form-repeater">
                                        <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                            <h6 class="mb-0"><i class="ri-nurse-line ri-22px"></i>Assign Staff</h6>
                                        </div>
                                        <div data-repeater-list="staff_data">
                                            <div class="row mb-3">
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Type
                                                </div>
                                                <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Shift
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Customer Rate
                                                </div>
                                                <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Staff
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Cost Rate
                                                </div>
                                            </div>
                                            @foreach($staff_data as $staff)
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" class="form-control d-none" name="type" value="{{$staff->name ?? ""}}">
                                                            <input type="text" class="form-control" value="{{$staff->name ?? ""}}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0">
                                                        <div class="form-floating form-floating-outline">
                                                            <select class="form-select d-none" name="shift">
                                                                <option disabled selected>Select shift</option>
                                                                @if(!empty($shifts))
                                                                    @foreach($shifts as $shift)
                                                                        <option value="{{$shift->id}}" @if($shift->id == $staff->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <select class="ShiftSelect select2 form-select" disabled>
                                                                <option disabled selected>Select shift</option>
                                                                @if(!empty($shifts))
                                                                    @foreach($shifts as $shift)
                                                                        <option value="{{$shift->id}}" @if($shift->id == $staff->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control" value="{{$staff->sell_rate ?? "00"}}" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 col-lg-3 col-xl-3 col-12">
                                                        <div class="form-floating form-floating-outline">
                                                            <select class="StaffSelect select2 form-select" name="staff_id" onchange="changeStaffRate(this)" required>
                                                                <option value="" selected disabled></option>
                                                                @if(!empty($staff->staffs))
                                                                    @foreach($staff->staffs as $st)
                                                                        @if($staff->staff_type == $st->type)
                                                                            <option value="{{$st->id}}" data-details="{{$st}}">{{$st->f_name}} {{$st->m_name}} {{$st->l_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text">₹</span>
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control staff-rate-input" name="rate" value="00" required onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    {{-- @if(!empty($doctor_data))
                                    <hr>
                                    <div class="form-repeater">
                                        <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                            <h6 class="mb-0"><i class="ri-stethoscope-line ri-22px"></i> Assign Doctor</h6>
                                        </div>
                                        <div data-repeater-list="doctor_data">
                                            <div class="row mb-3">
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Type
                                                </div>
                                                <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Shift
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Customer Rate
                                                </div>
                                                <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Doctor
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Cost Rate
                                                </div>
                                            </div>
                                            @foreach($doctor_data as $doctor)
                                                <div data-repeater-item>
                                                    <div class="row">
                                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control d-none" name="type" value="{{$doctor->name ?? ""}}">
                                                                <input type="text" class="form-control" value="{{$doctor->name ?? ""}}" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0">
                                                            <div class="form-floating form-floating-outline">
                                                                <select class="form-select d-none" name="shift">
                                                                    <option disabled selected>Select shift</option>
                                                                    @if(!empty($shifts))
                                                                        @foreach($shifts as $shift)
                                                                            <option value="{{$shift->id}}"  @if($shift->id == $doctor->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <select class="ShiftSelect select2 form-select" disabled>
                                                                    <option disabled selected>Select shift</option>
                                                                    @if(!empty($shifts))
                                                                        @foreach($shifts as $shift)
                                                                            <option value="{{$shift->id}}"  @if($shift->id == $doctor->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
                                                                <div class="form-floating form-floating-outline">
                                                                    <input type="text" class="form-control" value="{{$doctor->sell_rate ?? "00"}}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 col-lg-3 col-xl-3 col-12">
                                                            <div class="form-floating form-floating-outline">
                                                                <select class="DoctorSelect select2 form-select" name="doctor_id" onchange="changeDoctorRate(this)">
                                                                    <option value="" disabled selected>Select Doctor</option>
                                                                    @if(!empty($doctors))
                                                                        @foreach($doctors as $doc)
                                                                            <option value="{{$doc->id}}" data-details="{{$doc}}">{{$doc->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                            <div class="input-group input-group-merge">
                                                                <span class="input-group-text">₹</span>
                                                                <div class="form-floating form-floating-outline">
                                                                    <input type="text" class="form-control doctor-rate-input" name="rate" value="00" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                            {{-- @if(!empty($equipment_data))
                                <hr class="mt-3">
                                <div class="form-repeater">
                                    <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                        <h6 class="mb-0"><i class="ri-syringe-line ri-22px"></i>Equipments</h6>
                                    </div>
                                    @foreach($equipment_data as $equipment)
                                    <div data-repeater-list="equipment_data">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="mb-2 col-lg-7 col-xl-7 col-12 mb-0">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" value="{{$equipment->name ?? ""}}" disabled>
                                                        <label for="StaffRate">Equipment Type</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0">
                                                    <div class="form-floating form-floating-outline mb-6">
                                                        <input type="text" class="form-control" value="{{$equipment->qnt ?? 1}}"  disabled>
                                                        <label for="EquipmentQnt">Quantity</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" class="form-control equipment-rate-input" value="{{$equipment->sell_rate ?? "00"}}" disabled>
                                                            <label for="StaffRate">Customer Rate</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                            @if(!empty($ambulance_data))
                                <hr class="mt-3">
                                <div class="form-repeater">
                                    <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                        <h6 class="mb-0"><i class="ri-taxi-line ri-22px"></i> Ambulance</h6>
                                    </div>
                                    @foreach($ambulance_data as $ambulance)
                                    <div data-repeater-list="ambulance_data">
                                        <div data-repeater-item>
                                            <div class="row">
                                                <div class="mb-2 col-lg-5 col-xl-5 col-12 mb-0">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" name="ambulance_name" value="{{$ambulance->name ?? ""}}" disabled>
                                                        <label for="form-repeater-1-1">Type</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-lg-5 col-xl-5 col-12 mb-0">
                                                    <div class="form-floating form-floating-outline">
                                                        <select class="ShiftSelect select2 form-select" name="doctor_shift" disabled>
                                                            <option disabled selected>Select shift</option>
                                                            @if(!empty($shifts))
                                                                @foreach($shifts as $shift)
                                                                    <option value="{{$shift->id}}" @if($shift->id == $ambulance->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label for="StaffRate">Shift</label>
                                                    </div>
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text text-secondary" style="border-color:#e5e6e8;">₹</span>
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" class="form-control ambulance-rate-input" value="{{$ambulance->sell_rate ?? "00"}}" disabled>
                                                            <label for="StaffRate">Customer Rate</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
                <hr class="mt-12">
                {{-- <div class="">
                    <h6 class="mb-5"><i class="ri-file-list-3-line ri-22px"></i> Booking Summary</h6>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="datatables-order-details table dataTable no-footer dtr-column" style="margin-bottom: 0px!important;" id="DataTables_Table_0"
                            style="width: 913px;">
                            <thead>
                                <tr>
                                    <th class="w-50 sorting_disabled" rowspan="1" colspan="1" style="width: 416px;" aria-label="products">
                                        products</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 95px;" aria-label="price">price</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 76px;" aria-label="qty">qty</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 112px;" aria-label="total">total</th>
                                </tr>
                            </thead>
                            <tbody id="ShowItemsTable">
                                @if(!empty($staff_data))
                                    @foreach($staff_data as $staff)
                                        @php
                                            $shift = '';
                                            if ($staff->shift == 1) {
                                                $shift = "Day Shift (12 Hours)";
                                            } elseif ($staff->shift == 2) {
                                                $shift = "Night Shift (12 Hours)";
                                            } elseif ($staff->shift == 3) {
                                                $shift = "Full Day Shift (24 Hours)";
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $staff->name ?? '' }}<br><span style="font-size: 12px;">{{ $shift }}</span></td>
                                            <td>₹{{ $staff->sell_rate ?? '00' }}</td>
                                            <td>{{ $staff->qnt ?? '1' }}</td>
                                            <td>₹{{ $staff->sell_rate ?? '00' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(!empty($equipment_data))
                                    @foreach($equipment_data as $equipment)
                                        <tr>
                                            <td>{{ $equipment->name ?? '' }}</td>
                                            <td>₹{{ $equipment->cost_rate ?? '00' }}</td>
                                            <td>{{ $equipment->qnt ?? '1' }}</td>
                                            <td>₹{{ $equipment->sell_rate ?? '00' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(!empty($doctor_data))
                                    @foreach($doctor_data as $doctor)
                                        @php
                                            $shift = '';
                                            if ($doctor->shift == 1) {
                                                $shift = "Day Shift (12 Hours)";
                                            } elseif ($doctor->shift == 2) {
                                                $shift = "Night Shift (12 Hours)";
                                            } elseif ($doctor->shift == 3) {
                                                $shift = "Full Day Shift (24 Hours)";
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $doctor->name ?? '' }}<br><span style="font-size: 12px;">{{ $shift }}</span></td>
                                            <td>₹{{ $doctor->sell_rate ?? '00' }}</td>
                                            <td>{{ $doctor->qnt ?? '1' }}</td>
                                            <td>₹{{ $doctor->sell_rate ?? '00' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(!empty($ambulance_data))
                                    @foreach($ambulance_data as $ambulance)
                                        @php
                                            $shift = '';
                                            if ($ambulance->shift == 1) {
                                                $shift = "Day Shift (12 Hours)";
                                            } elseif ($ambulance->shift == 2) {
                                                $shift = "Night Shift (12 Hours)";
                                            } elseif ($ambulance->shift == 3) {
                                                $shift = "Full Day Shift (24 Hours)";
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $ambulance->name ?? '' }}<br><span style="font-size: 12px;">{{ $shift }}</span></td>
                                            <td>₹{{ $ambulance->sell_rate ?? '00' }}</td>
                                            <td>{{ $ambulance->qnt ?? '1' }}</td>
                                            <td>₹{{ $ambulance->sell_rate ?? '00' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @if(empty($staff_data) && empty($equipment_data) && empty($doctor_data) && empty($ambulance_data))
                        <div class="d-flex justify-content-center align-items-center p-5" style="background-color: #fcfcfc;" id="NoData">
                            Nothing Added!
                        </div>
                        @endif
                        <div style="width: 1%;"></div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center m-4 px-5 py-1 mb-0 pb-0">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-start gap-4">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0" id="SubTotal">₹{{$booking->sub_total ?? "00.00"}}</h6>
                            </div>
                            <div class="d-flex justify-content-start gap-4">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0" id="Total">₹{{$booking->total ?? "00.00"}}</h6>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('assign_bookings')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>

<script>
    function changeStaffRate(thiss){
        var select = $(thiss);
        var data = select.find(':selected').data('details');
        var repeaterItem = select.closest('[data-repeater-item]');
        var rateInput = repeaterItem.find('.staff-rate-input'); 
        var shiftInput = repeaterItem.find('.ShiftSelect');
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
    function changeDoctorRate(thiss){
        var select = $(thiss);
        var data = select.find(':selected').data('details');
        var repeaterItem = select.closest('[data-repeater-item]');
        var rateInput = repeaterItem.find('.doctor-rate-input'); 
        var shiftInput = repeaterItem.find('.ShiftSelect');
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
    function initializePlugins(context) {
        var start_date = @json($booking->start_date);
        var end_date = @json($booking->end_date);
        console.log("Start Date:", start_date);
        console.log("End Date:", end_date);

        $(context).find('.StaffSelect').select2({
            placeholder: 'Select a staff'
        });
        $(context).find('.DoctorSelect').select2({
            placeholder: 'Select a doctor'
        });
        $(context).find('.Date').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: start_date,
            maxDate: end_date
        });
    }

    $(function () {
        var maxlengthInput = $('.bootstrap-maxlength-example'),
            formRepeater = $('.form-repeater');
    
        // Bootstrap Max Length
        if (maxlengthInput.length) {
            maxlengthInput.each(function () {
                $(this).maxlength({
                    warningClass: 'label label-success bg-success text-white',
                    limitReachedClass: 'label label-danger',
                    separator: ' out of ',
                    preText: 'You typed ',
                    postText: ' chars available.',
                    validate: true,
                    threshold: +this.getAttribute('maxlength')
                });
            });
        }
    
        // Form Repeater
        if (formRepeater.length) {
            var row = 2;
            var col = 1;
            formRepeater.on('submit', function (e) {
                e.preventDefault();
            });
            formRepeater.repeater({
                show: function () {
                    var fromControl = $(this).find('.form-control, .form-select');
                    var formLabel = $(this).find('.form-label');
        
                    fromControl.each(function (i) {
                        var id = 'form-repeater-' + row + '-' + col;
                        $(fromControl[i]).attr('id', id);
                        $(formLabel[i]).attr('for', id);
                        col++;
                    });

                    // Initialize select2 and flatpickr for the new elements
                    initializePlugins(this);
        
                    row++;
                    $(this).slideDown();
                },
                hide: function (e) {
                    $(this).slideUp(e);
                }
            });
        }
    });

    $(document).ready(function() {
        var start_date = @json($booking->start_date);
        var end_date = @json($booking->end_date);

        $('#showHideDetails').click(function() {
            var icon = $(this).find('i');
            if (icon.hasClass('ri-eye-line')) {
                icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
                $(this).find('span').contents().filter(function() {
                    return this.nodeType === 3;
                })[0].nodeValue = " Hide";
                $('#CustomerDetails').slideDown('slow');
            } else {
                icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
                $(this).find('span').contents().filter(function() {
                    return this.nodeType === 3;
                })[0].nodeValue = " View";
                $('#CustomerDetails').slideUp('slow');
            }
        });

        // Initial plugin initialization on page load
        initializePlugins(document);

        $('.StaffTypeSelect').select2({
            placeholder: 'Select a staff type'
        });
        $('.StaffSelect').select2({
            placeholder: 'Select a staff'
        });
        $('.DoctorSelect').select2({
            placeholder: 'Select a doctor'
        });
        $('.ShiftSelect').select2({
            placeholder: 'Select a shift'
        });
        $('#Patient-Select').select2({
            placeholder: 'Select a patient'
        });
        $('#Hospital-Select').select2({
            placeholder: 'Select a hospital'
        });
        $('#Gender').select2({
            placeholder: 'Select a gender',
            dropdownParent: $('#addPatientModal')
        });
        $('#State').select2({
            placeholder: 'Select a state',
            dropdownParent: $('#addPatientModal')
        });
        $('#City').select2({
            placeholder: 'Select a city',
            dropdownParent: $('#addPatientModal')
        });
        $('#Area').select2({
            placeholder: 'Select an area',
            dropdownParent: $('#addPatientModal')
        });
        $('#dob').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            maxDate: new Date()
        });
        $('.Date').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: start_date,
            maxDate: end_date
        });
        $('#BookingStartDate').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: start_date,
            maxDate: end_date
        });
        $('#BookingStartDate').on('change', function(){
            var mindate = $('#BookingStartDate').val();
            $('#BookingEndDate').attr('disabled',false)
            $('#BookingEndDate').flatpickr({
                altInput: true,
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: mindate,
                maxDate: end_date
            });
        });
    });
</script>
@endsection
@extends('backend.components.header')

@section('css')

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
<div class="row">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0">Create Booking</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_booking')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <h6 class="mb-0"><i class="ri-radio-button-line ri-22px"></i> Select Booking Type</h6>
                        <div class="row mb-4 mx-1">
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="radio" value="Patient" name="booking_type" id="patientradio" onclick="checkBookingType()">
                                    <label class="form-check-label" for="patientradio">
                                        Patient
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="radio" value="Corporate" name="booking_type" id="hospitalradio" onclick="checkBookingType()">
                                    <label class="form-check-label" for="hospitalradio">
                                        Corporate
                                    </label>
                                </div>
                            </div>
                            @error('booking_type')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                            <div class="col-sm-12">
                                <input class="form-control d-none" type="text" name="customer_id" id="customerId">
                            </div>
                        </div>
                        <h6 class="d-none PatientCheck"><i class="ri-wheelchair-line ri-24px"></i> Select Patient</h6>
                        <div class="row mb-4 d-none PatientCheck">
                            <div class="col-sm-11">
                                <div class="form-floating form-floating-outline">
                                    <select id="Patient-Select" class="select2 form-select" onchange="showPatientDetails(this)">
                                        <option></option>
                                        @if(!empty($data['patients']))
                                            @foreach($data['patients'] as $patient)
                                                <option value="{{$patient->id}}" data-details="{{$patient}}">{{$patient->name}} - {{$patient->patient_id}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="Patient-Select">Patients</label>
                                </div>
                                @error('customer_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="container py-4 d-none" id="PatientDetails">
                                    <h6>Patient Details :</h6>
                                    <div class="d-flex flex-wrap row-gap-2">
                                        <div class="me-12">
                                            <p class="text-nowrap mb-2"><i class="ri-hospital-line ri-20px me-2"></i>Hospital : <span id="P-HType"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-user-line ri-20px me-2"></i>Full Name : <span id="P-Name"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Mobile : <span id="P-Mobile"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Mobile 2 : <span id="P-Mobile2"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-mail-line ri-20px me-2"></i>Email : <span id="P-Email"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-calendar-event-line ri-20px me-2"></i>DOB : <span id="P-DOB"></span></p>
                                            <p class="text-nowrap mb-0"><i class="ri-calendar-schedule-line ri-20px me-2"></i>Age : <span id="P-Age"></span></p>
                                        </div>
                                        <div class="me-12">
                                            <p class="text-nowrap mb-2"><i class="ri-men-line ri-20px me-2"></i>Gender : <span id="P-Gender"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-home-2-line ri-20px me-2 ms-50"></i>Address : <span id="P-Address"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State : <span id="P-State"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City: <span id="P-City"></span></p>
                                            <p class="text-nowrap mb-0"><i class="ri-compass-line ri-20px me-2"></i>Area : <span id="P-Area"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1 pt-1 text-end pe-6">
                                <button type="button" class="btn btn-icon btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                                    <span class="tf-icons ri-add-line ri-22px"></span>
                                </button>
                            </div>
                        </div>
                        <h6 class="d-none CorporateCheck"><i class="ri-building-line ri-22px"></i> Select Corporate</h6>
                        <div class="row mb-4 d-none CorporateCheck">
                            <div class="col-sm-11">
                                <div class="form-floating form-floating-outline">
                                    <select id="Corporate-Select" class="select2 form-select" onchange="showCorporateDetails(this)">
                                        <option></option>
                                        @if(!empty($data['corporates']))
                                            @foreach($data['corporates'] as $corporate)
                                                <option value="{{$corporate->id}}" data-details="{{$corporate}}">{{$corporate->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="Corporate-Select">Corporates</label>
                                </div>
                                @error('customer_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <div class="container py-4 d-none" id="CorporateDetails">
                                    <h6>Corporate Details :</h6>
                                    <div class="d-flex flex-wrap row-gap-2">
                                        <div class="me-12">
                                            <p class="text-nowrap mb-2"><i class="ri-hospital-line ri-20px me-2"></i>Corporate Name : <span id="H-Name"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-map-pin-2-line ri-20px me-2 ms-50"></i>Address : <span id="H-Address"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 1 : <span id="H-Mobile1"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 2 : <span id="H-Mobile2"></span></p>
                                        </div>
                                        <div class="me-12">
                                            <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State : <span id="H-State"></span></p>
                                            <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City: <span id="H-City"></span></p>
                                            <p class="text-nowrap mb-0"><i class="ri-compass-line ri-20px me-2"></i>Area : <span id="H-Area"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1 pt-1 text-end pe-6">
                                <button type="button" class="btn btn-icon btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#addCorporateModal">
                                    <span class="tf-icons ri-add-line ri-22px"></span>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <h6><i class="ri-calendar-line ri-22px"></i> Select Date</h6>
                        <div class="row mb-4">
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="start_date" placeholder="DD-MM-YYYY" id="BookingStartDate" readonly onchange="changeBillingRate()"/>
                                    <label for="BookingStartDate">Start Date</label>
                                </div>
                                @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="end_date" placeholder="DD-MM-YYYY" id="BookingEndDate" readonly onchange="changeBillingRate()"/>
                                    <label for="BookingEndDate">End Date</label>
                                </div>
                                @error('end_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <h6 class="mb-0"><i class="ri-checkbox-line ri-22px"></i> Check Your Requirements</h6>
                        <div class="row mb-4 mx-1">
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_staff" id="staffcheckbox" onclick="StaffCheck(this)">
                                    <label class="form-check-label" for="staffcheckbox">
                                        Staff
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_equipment" id="equipmentcheckbox" onclick="EquipmentCheck(this)">
                                    <label class="form-check-label" for="equipmentcheckbox">
                                        Equipment
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_doctor" id="doctorcheckbox" onclick="DoctorCheck(this)">
                                    <label class="form-check-label" for="doctorcheckbox">
                                        Doctor
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="checkbox" value="1" name="is_ambulance" id="ambulancecheckbox" onclick="AmbulanceCheck(this)">
                                    <label class="form-check-label" for="ambulancecheckbox">
                                        Ambulance
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr class="d-none StaffCheck">
                        <div class="form-repeater d-none StaffCheck">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-nurse-line ri-22px"></i> Add Staff</h6>
                                <p class="btn btn-icon btn-outline-primary waves-effect mb-0" data-repeater-create>
                                    <i class="ri-add-line"></i>
                                </p>
                            </div>
                            <div data-repeater-list="staff_data">
                                <div data-repeater-item class="StaffRow">
                                    <div class="row">
                                        <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <select class="StaffTypeSelect select2 form-select" name="staff_type" onchange="ShowItemsInTable()">
                                                    <option disabled selected>Select type</option>
                                                    @if(!empty($data['staff_type']))
                                                        @foreach($data['staff_type'] as $type)
                                                            <option value="{{$type->id}}">{{$type->title}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="staff_shift" onchange="ShowItemsInTable()">
                                                    <option disabled selected>Select shift</option>
                                                    @if(!empty($data['shifts']))
                                                        @foreach($data['shifts'] as $shift)
                                                            <option value="{{$shift->id}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="form-repeater-1-3">Shift</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control staff-rate-input" name="staff_rate" onkeyup="changeBillingRate()" id="StaffRate" placeholder="00" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <label for="StaffRate">Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 text-end pe-12">
                                            <p class="rounded btn-icon border border-dark mt-1" style="cursor: pointer;" onclick="StaffCopyData(this)">
                                                <i class="ri-file-copy-line "></i>
                                            </p>
                                            <p class="rounded btn-icon border border-danger mt-1" style="cursor: pointer;" data-repeater-delete>
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="ShowCopiedStaff">

                                </div>
                            </div>
                        </div>
                        <hr class="mt-3 d-none EquipmentCheck">
                        <div class="form-repeater d-none EquipmentCheck">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-syringe-line ri-22px"></i> Add Equipment</h6>
                                <p class="btn btn-icon btn-outline-primary waves-effect mb-0" data-repeater-create>
                                    <i class="ri-add-line"></i>
                                </p>
                            </div>
                            <div data-repeater-list="equipment_data">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <select class="EquipmentSelect select2 form-select equipment-select" name="equipment_name" onchange="addEquipmentRate(this)">
                                                    <option disabled selected>Select equipment</option>
                                                    @if(!empty($data['equipments']))
                                                        @foreach($data['equipments'] as $equipment)
                                                            <option value="{{$equipment->id}}" data-rate="{{$equipment->sell_price ?? 0}}" data-type="{{$equipment->type ?? ""}}">{{$equipment->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="form-floating form-floating-outline mb-6">
                                                {{-- <input type="number" class="form-control" id="EquipmentQnt" min="1" max="10" value="1"> --}}
                                                <select class="form-select equipment-qnt-input" disabled id="EquipmentQnt" name="equipment_qnt" onchange="multiplyEquipmentRate(this)">
                                                    <option disabled selected>Select quantity</option>
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
                                                <label for="EquipmentQnt" class="equipment-days-qnt-label">Quantity / Rental Days</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control equipment-rate-input" name="equipment_rate" onkeyup="changeBillingRate()" readonly placeholder="00" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <label>Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12  text-end pe-12">
                                            <p class="btn btn-icon btn-outline-danger waves-effect m-1 mx-0" data-repeater-delete>
                                                <i class="ri-delete-bin-line "></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="d-none DoctorCheck">
                        <div class="form-repeater d-none DoctorCheck">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-stethoscope-line ri-22px"></i> Add Doctor</h6>
                                {{-- <p class="btn btn-icon btn-outline-primary waves-effect mb-0" data-repeater-create>
                                    <i class="ri-add-line"></i>
                                </p> --}}
                            </div>
                            <div data-repeater-list="doctor_data">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control DoctorSelect" name="doctor_name" value="Doctor" readonly>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-3 col-xl-3 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="doctor_shift" onchange="ShowItemsInTable()">
                                                    <option disabled selected>Select shift</option>
                                                    @if(!empty($data['shifts']))
                                                        @foreach($data['shifts'] as $shift)
                                                            <option value="{{$shift->id}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="form-repeater-1-3">Shift</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control mb-1 Doc_Date" value="{{old('date')}}" onchange="ShowItemsInTable()" name="date" placeholder="DD-MM-YYYY" readonly />
                                                <label for="form-repeater-1-3">Date</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control doctor-rate-input" name="doctor_rate" placeholder="00" onkeyup="changeBillingRate()" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <label>Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12  text-end pe-12">
                                            <p class="rounded btn-icon border border-dark mt-1" style="cursor: pointer;" onclick="DoctorCopyData(this)">
                                                <i class="ri-file-copy-line "></i>
                                            </p>
                                            <p class="rounded btn-icon border border-danger mt-1" style="cursor: pointer;" data-repeater-delete>
                                                <i class="ri-delete-bin-line text-danger"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div id="ShowCopiedDoctor">

                                </div>
                            </div>
                        </div>
                        <hr class="d-none AmbulanceCheck">
                        <div class="form-repeater d-none AmbulanceCheck">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-taxi-line ri-22px"></i> Add Ambulance</h6>
                            </div>
                            <div data-repeater-list="ambulance_data">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control" name="ambulance_name" value="Ambulance" readonly>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="ambulance_shift" onchange="addAmbulanceRate(this)">
                                                    <option disabled selected>Select shift</option>
                                                    @if(!empty($data['shifts']))
                                                        @foreach($data['shifts'] as $shift)
                                                            <option value="{{$shift->id}}" data-details="{{$data['ambulance'] ?? ""}}">{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="form-repeater-1-3">Shift</label>
                                            </div>
                                        </div>
                                        {{-- <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control mb-1 Amb_Date" value="{{old('amb_date')}}" onchange="ShowItemsInTable()" name="amb_date" placeholder="DD-MM-YYYY" readonly />
                                                <label for="form-repeater-1-3">Date</label>
                                            </div>
                                        </div> --}}
                                        <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control ambulance-rate-input" name="ambulance_rate" placeholder="00" readonly onkeyup="changeBillingRate()" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                                    <label>Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="container">
                    <h6 class="mb-5"><i class="ri-file-list-3-line ri-22px"></i> Booking Summary</h6>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <table class="datatables-order-details table dataTable no-footer dtr-column" style="margin-bottom: 0px!important;" id="DataTables_Table_0"
                            style="width: 913px;">
                            <thead>
                                <tr>
                                    <th class="w-50 sorting_disabled" rowspan="1" colspan="1" style="width: 416px;" aria-label="products">
                                        products</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 95px;" aria-label="price">price</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 76px;" aria-label="qty">Days/qty</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 112px;" aria-label="total">total</th>
                                </tr>
                            </thead>
                            <tbody id="ShowItemsTable">
                                
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center align-items-center p-5" style="background-color: #fcfcfc;" id="NoData">
                            Nothing Added!
                        </div>
                        <div style="width: 1%;"></div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center m-4 px-5 py-1 mb-0 pb-0">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-start gap-4">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0" id="SubTotal">₹00</h6>
                            </div>
                            {{-- <div class="d-flex justify-content-start gap-4">
                                <span class="w-px-100 text-heading">Tax:</span>
                                <h6 class="mb-0" id="Tax">₹00.00</h6>
                            </div> --}}
                            <div class="d-flex justify-content-start gap-4">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0" id="Total">₹00</h6>
                            </div>
                            <div class="col-sm-12">
                                <input class="form-control d-none" type="text" name="sub_total" id="subTotalInput">
                            </div>
                            <div class="col-sm-12">
                                <input class="form-control d-none" type="text" name="total" id="totalInput">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1"  onclick="storeBookingType('Main')">Submit</button>
                    {{-- <a href="{{route('bookings')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Extra Large Modal -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Add Patient</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="AddPatientForm" action="{{route('create_patient')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-4">
                                    <label class="form-label">Hospital Type <span class="text-danger">*</span></label><br>
                                    <div class="form-check form-check-inline mt-4 me-12">
                                        <input class="form-check-input" type="radio" value="DHC" name="h_type" @if(old('h_type') == "DHC") checked @endif id="dhcradio" onclick="checkHospitalType()">
                                        <label class="form-check-label" for="dhcradio">
                                            DHC
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline mt-4 me-12">
                                        <input class="form-check-input" type="radio" value="Other" @if(old('h_type') == "Other") checked @endif name="h_type" id="otherradio" onclick="checkHospitalType()">
                                        <label class="form-check-label" for="otherradio">
                                            Other
                                        </label>
                                    </div>
                                    @error('h_type')
                                        <br><span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-9 mb-3 d-none OthersCheck">
                                <div class="mb-4">
                                    <label class="form-label">Select Hospital Type <span class="text-danger">*</span></label>
                                    <select id="Hospital-Select-2" class="select2 form-select" name="h_other_type">
                                        <option></option>
                                        @if(!empty($data['hospitals']))
                                            @foreach($data['hospitals'] as $hospital)
                                                <option value="{{$hospital->name}}">{{$hospital->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('h_other_type')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr class="mt-3">
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1" value="{{old('name')}}" name="name"  placeholder="Enter full name"/>
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control mb-1" value="{{old('email')}}" name="email"  placeholder="Enter email address"/>
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile')}}" name="mobile"  placeholder="Enter contact number"/>
                                    @error('mobile')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Alternet Contact Number</label>
                                    <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile2')}}" name="mobile2"  placeholder="Enter alternet contact number"/>
                                    @error('mobile2')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="select2 form-select mb-1" name="gender" id="Gender">
                                        <option></option>
                                        <option value="Male" @if(old('gender') == "Male") selected @endif>Male</option>
                                        <option value="Female" @if(old('gender') == "Female") selected @endif>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="text" class="form-control mb-1" value="{{old('dob')}}"  name="dob" placeholder="DD-MM-YYYY" id="dob" readonly />
                                    @error('dob')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Age</label>
                                    <input type="number" class="form-control mb-1" value="{{old('age')}}" name="age"  placeholder="Enter age"/>
                                    @error('age')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1" value="{{old('address')}}" name="address" placeholder="Enter address"/>
                                    @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label" for="State">State<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="state" id="State" onchange="selectState()">
                                        <option value=""></option>
                                        @if(!empty($data['states']))
                                            @foreach($data['states'] as $state)
                                                <option value="{{$state->id}}" @if(old('state') == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label" for="City">City<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="city" id="City" onchange="selectCity()">
                                        <option value=""></option>
                                    </select>
                                    @error('city')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Area<span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <select class="form-control mb-1" name="area" id="Area">
                                            <option value=""></option>
                                        </select>
                                        <a class="ms-2 btn btn-label-primary" onclick="openCenteredWindow('{{ route('add_area') }}', 'MyWindow', 600, 600);"><i class="ri-add-line"></i></a>
                                    </div>
                                    @error('area')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Area<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="area" id="Area">
                                        <option value=""></option>
                                    </select>
                                    @error('area')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Reference</label>
                                    <input type="text" class="form-control mb-1" value="{{old('reference')}}" name="reference" placeholder="Enter reference">
                                    @error('reference')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="storeBookingType('Patient')">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addCorporateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Add Corporate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="AddDoctorForm" action="{{route('create_corporate')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Corporate Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1" value="{{old('name')}}" name="name"  placeholder="Enter full name"/>
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Contact Number 1<span class="text-danger">*</span></label>
                                    <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile1')}}" name="mobile1"  placeholder="Enter contact number 1"/>
                                    @error('mobile1')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Contact Number 2<span class="text-danger">*</span></label>
                                    <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile2')}}" name="mobile2"  placeholder="Enter contact number 2"/>
                                    @error('mobile2')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-1" value="{{old('address')}}" name="address" placeholder="Enter address"/>
                                    @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">State<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="state" id="State2" onchange="selectState2()">
                                        <option value=""></option>
                                        @if(!empty($data['states']))
                                            @foreach($data['states'] as $state)
                                                <option value="{{$state->id}}" @if(old('state') == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">City<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="city" id="City2" onchange="selectCity2()">
                                        <option value=""></option>
                                    </select>
                                    @error('city')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Area<span class="text-danger">*</span></label>
                                    <select class="form-control mb-1" name="area" id="Area2">
                                        <option value=""></option>
                                    </select>
                                    @error('area')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="storeBookingType('Corporate')">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>
<script>
$(function () {
    
  var maxlengthInput = $('.bootstrap-maxlength-example'),
    formRepeater = $('.form-repeater');

  // Bootstrap Max Length
  // --------------------------------------------------------------------
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
  // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
  // -----------------------------------------------------------------------------------------------------------------

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

        row++;

        $(this).slideDown();
      },
      hide: function (e) {
        $(this).slideUp(e);
        setTimeout( function(){ 
            changeBillingRate();
        }  , 500 );
      }
    });
  }
});
</script>

<script>
    checkHospitalType();
    selectState();
    selectState2();
    function openCenteredWindow(url, windowName, width, height) {
        $('#State').val("").trigger('change');
        $('#City').val("").trigger('change');
        // Calculate the position of the window to be centered
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;

        // Define window options
        var options = 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;

        // Open the window
        window.open(url, windowName, options);

        // Prevent the default behavior of the anchor tag
        return false;
    }
    function checkHospitalType(){
        $('#Hospital-Select-2').val(null).trigger("change"); 
        var value = $('input[name="h_type"]:checked').val();
        if(value == "DHC"){
            $('.OthersCheck').addClass('d-none');
        }else if(value == "Other"){
            $('.OthersCheck').removeClass('d-none');
        }
    }
    function ShowItemsInTable(){
        var BookingStartDate = $('#BookingStartDate').val();
        var BookingEndDate = $('#BookingEndDate').val();

        var staff_rates = $('.staff-rate-input');
        var equipment_rates = $('.equipment-rate-input');
        var doctor_rates = $('.doctor-rate-input');
        var ambulance_rates = $('.ambulance-rate-input');

        var staffchecked = $('#staffcheckbox');
        var equipmentchecked = $('#equipmentcheckbox');
        var doctorchecked = $('#doctorcheckbox');
        var ambulancechecked = $('#ambulancecheckbox');

        var tableData = '';

        if(BookingStartDate && BookingEndDate){
            var startDate = new Date(BookingStartDate);
            var endDate = new Date(BookingEndDate);

            var allDates = getDates(startDate, endDate);
        }else{
            var today = new Date();
            var allDates = getDates(today, today);
        }

        for (var i = 0; i < staff_rates.length; i++) {
            var repeaterItem = $(staff_rates[i]).closest('[data-repeater-item]');
            var staffType = repeaterItem.find('.StaffTypeSelect :selected').text() || "-";
            var staffShift = repeaterItem.find('.ShiftSelect :selected').text();
            var staffRate = repeaterItem.find('.staff-rate-input').val() || "00";

            if (staffShift === "Select shift" || staffShift === "") {
                staffShift = "";
            } else {
                staffShift = `<span style="font-size:12px;">` + staffShift + `</span>`;
            }
            var days = 0;
            allDates.forEach(function(date) {
                days++;
            });

            if(staffchecked.prop('checked') == true){
                tableData += `<tr>
                                <td>`+staffType+`<br>`+staffShift+`</td>
                                <td>`+parseInt(staffRate,10).toLocaleString()+`</td>
                                <td>`+days+`</td>
                                <td>`+parseInt(staffRate * days,10).toLocaleString()+`</td>
                            </tr>`;
            }
        }
        for (var j = 0; j < equipment_rates.length; j++) {
            var repeaterItem = $(equipment_rates[j]).closest('[data-repeater-item]');
            var equipmentName = repeaterItem.find('.EquipmentSelect :selected').text() || "-";
            var equipmentPrice = repeaterItem.find('.EquipmentSelect :selected').data('rate') || "00";
            var equipmentQnt = repeaterItem.find('.equipment-qnt-input').val() || "0";
            var equipmentRate = repeaterItem.find('.equipment-rate-input').val() || "00";
            if(equipmentchecked.prop('checked') == true){
                tableData += `<tr>
                                <td>`+equipmentName+`</td>
                                <td>`+parseInt(equipmentPrice,10).toLocaleString()+`</td>
                                <td>`+equipmentQnt+`</td>
                                <td>`+parseInt(equipmentRate,10).toLocaleString()+`</td>
                            </tr>`;
            }
        }
        for (var k = 0; k < doctor_rates.length; k++) {
            var repeaterItem = $(doctor_rates[k]).closest('[data-repeater-item]');
            var staffShift = repeaterItem.find('.ShiftSelect :selected').text();
            var doctorDate = repeaterItem.find('.Doc_Date').val();
            var doctorRate = repeaterItem.find('.doctor-rate-input').val() || "00";

            if (staffShift === "Select shift" || staffShift === "") {
                staffShift = "";
            } else {
                staffShift = `<span style="font-size:12px;">` + staffShift + `</span>`;
            }

            if (doctorDate === "") {
                doctorDate = "";
            } else {
                doctorDate = `<span style="font-size:12px;">` + doctorDate + `</span>`;
            }

            if(doctorchecked.prop('checked') == true){
                tableData += `<tr>
                                <td>Doctor<br>`+doctorDate+` `+staffShift+`</td>
                                <td>`+parseInt(doctorRate,10).toLocaleString()+`</td>
                                <td>1</td>
                                <td>`+parseInt(doctorRate,10).toLocaleString()+`</td>
                            </tr>`;
            }
        }
        for (var l = 0; l < ambulance_rates.length; l++) {
            var repeaterItem = $(ambulance_rates[l]).closest('[data-repeater-item]');
            var staffShift = repeaterItem.find('.ShiftSelect :selected').text();
            var ambulanceRate = repeaterItem.find('.ambulance-rate-input').val() || "00";

            if (staffShift === "Select shift" || staffShift === "") {
                staffShift = "";
            } else {
                staffShift = `<span style="font-size:12px;">` + staffShift + `</span>`;
            }

            if(ambulancechecked.prop('checked') == true){
                tableData += `<tr>
                                <td>Ambulance<br>`+staffShift+`</td>
                                <td>`+parseInt(ambulanceRate,10).toLocaleString()+`</td>
                                <td>1</td>
                                <td>`+parseInt(ambulanceRate,10).toLocaleString()+`</td>
                            </tr>`;
            }
        }
        if(tableData != ''){
            $('#ShowItemsTable').html(tableData);
            $('#NoData').addClass('d-none');
        }else{
            $('#ShowItemsTable').html('');
            $('#NoData').removeClass('d-none');
        }
    }
    function StaffCopyData(thiss) {
        var repeaterItem = $(thiss).closest('[data-repeater-item]');
        var clonedItem = repeaterItem.clone();
        
        // Update the name attributes to ensure they are unique
        clonedItem.find('select, input').each(function() {
            var name = $(this).attr('name');
            if (name) {
                // Find the current index and increment it
                var newIndex = parseInt(name.match(/\[(\d+)\]/)[1]) + 1;
                // Replace the old index with the new index
                var newName = name.replace(/\[\d+\]/, '[' + newIndex + ']');
                $(this).attr('name', newName);
            }
        });

        // Set the selected values for the cloned selects
        repeaterItem.find('select').each(function(index) {
            var selectedValue = $(this).val();
            if(selectedValue){
                clonedItem.find('select').eq(index).val(selectedValue);
            }
        });

        clonedItem.appendTo("#ShowCopiedStaff");
        changeBillingRate();
    }
    function DoctorCopyData(thiss) {
        var repeaterItem = $(thiss).closest('[data-repeater-item]');
        var clonedItem = repeaterItem.clone();

        // Update the name attributes to ensure they are unique
        clonedItem.find('select, input').each(function() {
            var name = $(this).attr('name');
            if (name) {
                // Find the current index and increment it
                var newIndex = parseInt(name.match(/\[(\d+)\]/)[1]) + 1;
                // Replace the old index with the new index
                var newName = name.replace(/\[\d+\]/, '[' + newIndex + ']');
                $(this).attr('name', newName);
            }
        });

        // Set the selected values for the cloned selects
        repeaterItem.find('select').each(function(index) {
            var selectedValue = $(this).val();
            if(selectedValue){
                clonedItem.find('select').eq(index).val(selectedValue);
                }
        });
        clonedItem.appendTo("#ShowCopiedDoctor");

        var mindate = $('#BookingStartDate').val();
        var maxdate = $('#BookingEndDate').val();
        if(mindate && maxdate){
            var formattedMindate = formatDateToDMY(mindate);
            var formattedMaxdate = formatDateToDMY(maxdate);
            $('.Doc_Date').flatpickr({
                altInput: false,
                altFormat: 'd-m-Y',
                dateFormat: 'd-m-Y',
                minDate: formattedMindate,
                maxDate: formattedMaxdate
            });
        }

        changeBillingRate();
    }

    function checkBookingType(thiss){
        $('#customerId').val('');
        $('#Corporate-Select').val(null).trigger("change"); 
        $('#Patient-Select').val(null).trigger("change"); 
        var value = $('input[name="booking_type"]:checked').val();
        if(value == "Patient"){
            $('.PatientCheck').removeClass('d-none');
            $('.CorporateCheck').addClass('d-none');
            storeBookingType("Patient")
        }else if(value == "Corporate"){
            $('.PatientCheck').addClass('d-none');
            $('.CorporateCheck').removeClass('d-none');
            storeBookingType("Corporate")
        }
    }
    function StaffCheck(thiss){
        var checked = $(thiss);
        if (checked.prop('checked') == true){ 
            $('.StaffCheck').removeClass('d-none');
        }else{
            $('.StaffCheck').addClass('d-none');
        }
        changeBillingRate();
    }
    function EquipmentCheck(thiss){
        var checked = $(thiss);
        if (checked.prop('checked') == true){ 
            $('.EquipmentCheck').removeClass('d-none');
        }else{
            $('.EquipmentCheck').addClass('d-none');
        }
        changeBillingRate();
    }
    function DoctorCheck(thiss){
        var checked = $(thiss);
        if (checked.prop('checked') == true){ 
            $('.DoctorCheck').removeClass('d-none');
        }else{
            $('.DoctorCheck').addClass('d-none');
        }
        changeBillingRate();
    }
    function AmbulanceCheck(thiss){
        var checked = $(thiss);
        if (checked.prop('checked') == true){ 
            $('.AmbulanceCheck').removeClass('d-none');
        }else{
            $('.AmbulanceCheck').addClass('d-none');
        }
        changeBillingRate();
    }
    function getDates(startDate, endDate) {
        var dates = [];
        var currentDate = new Date(startDate);
        while (currentDate <= endDate) {
            dates.push(new Date(currentDate)); // Add a copy of the current date
            currentDate.setDate(currentDate.getDate() + 1); // Increment the date by 1 day
        }
        return dates;
    }
    function changeBillingRate() {
        var BookingStartDate = $('#BookingStartDate').val();
        var BookingEndDate = $('#BookingEndDate').val();

        var staff_rates = $('.staff-rate-input');
        var equipment_rates = $('.equipment-rate-input');
        var doctor_rates = $('.doctor-rate-input');
        var ambulance_rates = $('.ambulance-rate-input');

        var staff_rate_total = 0;
        var equipment_rate_total = 0;
        var doctor_rate_total = 0;
        var ambulance_rate_total = 0;

        if(BookingStartDate && BookingEndDate){
            var startDate = new Date(BookingStartDate);
            var endDate = new Date(BookingEndDate);

            var allDates = getDates(startDate, endDate);
        }else{
            var today = new Date();
            var allDates = getDates(today, today);
        }

        for (var i = 0; i < staff_rates.length; i++) {
            allDates.forEach(function(date) {
                staff_rate_total += Number($(staff_rates[i]).val()) || 0;
            });
        }
        for (var j = 0; j < equipment_rates.length; j++) {
            equipment_rate_total += Number($(equipment_rates[j]).val()) || 0;
        }
        for (var k = 0; k < doctor_rates.length; k++) {
            doctor_rate_total += Number($(doctor_rates[k]).val()) || 0;
        }
        for (var l = 0; l < ambulance_rates.length; l++) {
            ambulance_rate_total += Number($(ambulance_rates[l]).val()) || 0;
        }
        
        var sub_total = 0;

        var staffchecked = $('#staffcheckbox');
        var equipmentchecked = $('#equipmentcheckbox');
        var doctorchecked = $('#doctorcheckbox');
        var ambulancechecked = $('#ambulancecheckbox');

        if(staffchecked.prop('checked') == true){
            sub_total += staff_rate_total;
        }
        if(equipmentchecked.prop('checked') == true){
            sub_total += equipment_rate_total;
        }
        if(doctorchecked.prop('checked') == true){
            sub_total += doctor_rate_total;
        }
        if(ambulancechecked.prop('checked') == true){
            sub_total += ambulance_rate_total;
        }
        
        // var tax_amount = sub_total * 0.18;
        // var total = sub_total + tax_amount;
        $('#SubTotal').text('₹ ' + sub_total.toLocaleString());
        // $('#Tax').text('₹ ' + tax_amount.toLocaleString());
        $('#Total').text('₹ ' + sub_total.toLocaleString());


        $('#subTotalInput').val(sub_total.toLocaleString());
        $('#totalInput').val(sub_total.toLocaleString());

        ShowItemsInTable();
    }

    function multiplyEquipmentRate(thiss){
        var select = $(thiss);
        var qnt = select.find(':selected').val();
        var repeaterItem = select.closest('[data-repeater-item]');
        var selectInput = repeaterItem.find('.equipment-select');
        var oldrate = selectInput.find(':selected').data('rate');
        var rateInput = repeaterItem.find('.equipment-rate-input');
        var rate = parseInt(oldrate) * parseInt(qnt);
        rateInput.val(rate);
        changeBillingRate();
    }
    function addEquipmentRate(thiss) {
        var select = $(thiss);
        var rate = select.find(':selected').data('rate');
        var type = select.find(':selected').data('type');
        var repeaterItem = select.closest('[data-repeater-item]');
        var rateInput = repeaterItem.find('.equipment-rate-input');
        var qutInput = repeaterItem.find('.equipment-qnt-input');
        var daysqutLabel = repeaterItem.find('.equipment-days-qnt-label');
        if(type == "Rent"){
            var label = "Rental Days";
        }else{
            var label = "Quantity";
        }
        console.log(label);
        daysqutLabel.text(label);
        rateInput.val(rate);
        qutInput.val(1);
        qutInput.prop("disabled", false);
        rateInput.prop("readonly", false);
        changeBillingRate();
    }
    function addAmbulanceRate(thiss) {
        var select = $(thiss);
        var data = select.find(':selected').data('details');
        var repeaterItem = select.closest('[data-repeater-item]');
        var rateInput = repeaterItem.find('.ambulance-rate-input');
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
        ShowItemsInTable();
        changeBillingRate();
    }
    function showPatientDetails(thiss) {
        var select = $(thiss);
        var data = select.find(':selected').data('details');

        if (data) {
            $('#customerId').val(data.id || 0);

            $('#P-HType').text(data.h_type || '-');
            $('#P-Name').text(data.name || '-');
            $('#P-Mobile').text(data.mobile || '-');
            $('#P-Mobile2').text(data.mobile2 || '-');
            $('#P-Email').text(data.email || '-');
            if(data.dob){
                $('#P-DOB').text(formatDateToDMY(data.dob));
            }else{
                $('#P-DOB').text('-');
            }
            $('#P-Age').text(data.age || '-');
            $('#P-Gender').text(data.gender || '-');
            $('#P-Address').text(data.address || '-');
            $('#P-State').text((data.state && data.state.name) || '-');
            $('#P-City').text((data.city && data.city.name) || '-');
            $('#P-Area').text((data.area && data.area.name) || '-');

            $('#PatientDetails').removeClass('d-none');
        } else {
            $('#PatientDetails').addClass('d-none');
        }
    }

    function showCorporateDetails(thiss) {
        var select = $(thiss);
        var data = select.find(':selected').data('details');
        console.log(data);
        if (data) {
            $('#customerId').val(data.id || 0);

            $('#H-Name').text(data.name || '-');
            $('#H-Address').text(data.address || '-');
            $('#H-Mobile1').text(data.mobile1 || '-');
            $('#H-Mobile2').text(data.mobile2 || '-');
            $('#H-State').text((data.state && data.state.name) || '-');
            $('#H-City').text((data.city && data.city.name) || '-');
            $('#H-Area').text((data.area && data.area.name) || '-');

            $('#CorporateDetails').removeClass('d-none');
        } else {
            $('#CorporateDetails').addClass('d-none');
        }
    }

    function selectState() {
        var id = $('#State').val();
        $.ajax({
            url:"{{route('get_cities_by_state')}}",
            method:"POST",
            data:{'id':id,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(result)
            {
                var cities = result.data;
                var citySelect = $('#City');
                var cityyy = '{{old("city")}}';
                
                citySelect.empty().append('<option value=""></option>');
                cities.forEach(function(city) {
                    if(cityyy == city.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    citySelect.append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                    selectCity();
                });
            }
        }); 
    }
    function selectState2() {
        var id = $('#State2').val();
        $.ajax({
            url:"{{route('get_cities_by_state')}}",
            method:"POST",
            data:{'id':id,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(result)
            {
                var cities = result.data;
                var citySelect = $('#City2');
                var cityyy = '{{old("city")}}';
                
                citySelect.empty().append('<option value=""></option>');
                cities.forEach(function(city) {
                    if(cityyy == city.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    citySelect.append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                    selectCity2();
                });
            }
        }); 
    }
    
    function selectCity() {
        var id = $('#City').val();
        $.ajax({
            url: "{{route('get_areas_by_city')}}",
            method: "POST",
            data: {
                'id': id,
                _token: "{{ csrf_token() }}"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                var areas = result.data;
                var areaSelect = $('#Area');
                var areaaa = '{{old("area")}}';
                console.log();
                areaSelect.empty().append('<option value=""></option>');
                areas.forEach(function(area) {
                    if(areaaa == area.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    areaSelect.append('<option value="' + area.id + '" ' + selected + '>' + area.name + '</option>');
                });
            }
        });
    }
    function selectCity2() {
        var id = $('#City2').val();
        $.ajax({
            url: "{{route('get_areas_by_city')}}",
            method: "POST",
            data: {
                'id': id,
                _token: "{{ csrf_token() }}"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                var areas = result.data;
                var areaSelect = $('#Area2');
                var areaaa = '{{old("area")}}';
                console.log();
                areaSelect.empty().append('<option value=""></option>');
                areas.forEach(function(area) {
                    if(areaaa == area.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    areaSelect.append('<option value="' + area.id + '" ' + selected + '>' + area.name + '</option>');
                });
            }
        });
    }
    function storeBookingType(type){
        sessionStorage.removeItem("bookingType");
        sessionStorage.setItem("bookingType", type);
    }
    function formatDateToDMY(dateStr) {
        // Assuming the input date is in Y-m-d format
        var dateParts = dateStr.split('-');
        return dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
    }
    $(document).ready(function() {
        var value = sessionStorage.getItem("bookingType");
        if(value == "Patient"){
            $('input[name="booking_type"]').filter('[value="Patient"]').attr('checked', true);
            $('.PatientCheck').removeClass('d-none');
            $('.CorporateCheck').addClass('d-none');
            @if ($errors->any())
                $('#addPatientModal').modal('show');
            @endif
        }else if(value == "Corporate"){
            $('.PatientCheck').addClass('d-none');
            $('.CorporateCheck').removeClass('d-none');
            $('input[name="booking_type"]').filter('[value="Corporate"]').attr('checked', true);
            @if ($errors->any())
                $('#addCorporateModal').modal('show');
            @endif
        }else{
            console.log('nothing');
        }
    });
    // $('.StaffTypeSelect').select2({
    //     placeholder: 'Select a staff type'
    // });
    // $('.ShiftSelect').select2({
    //     placeholder: 'Select a shift'
    // });
    $('#Patient-Select').select2({
        placeholder: 'Select a patient'
    });
    $('#Corporate-Select').select2({
        placeholder: 'Select a corporate'
    });
    var addPatientModal = $('#addPatientModal > .modal-dialog > .modal-content')
    $('#State').select2({
        placeholder: 'Select a state',
        dropdownParent: addPatientModal
    });
    $('#City').select2({
        placeholder: 'Select a city',
        dropdownParent: addPatientModal
    });
    $('#Area').select2({
        placeholder: 'Select a area',
        dropdownParent: addPatientModal
    });
    $('#Hospital-Select-2').select2({
        placeholder: 'Select a hospital',
        dropdownParent: addPatientModal
    });
    $('#Gender').select2({
        placeholder: 'Select a gender',
        dropdownParent: addPatientModal
    });
    $('#State2').select2({
        placeholder: 'Select a state',
        dropdownParent: $('#addCorporateModal')
    });
    $('#City2').select2({
        placeholder: 'Select a city',
        dropdownParent: $('#addCorporateModal')
    });
    $('#Area2').select2({
        placeholder: 'Select a area',
        dropdownParent: $('#addCorporateModal')
    });
    $('#dob').flatpickr({
        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d',
        maxDate: new Date()
    });
    $('#BookingStartDate').flatpickr({
        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d',
        minDate: new Date().fp_incr(-6),
        maxDate: new Date(new Date().setMonth(new Date().getMonth() + 2))
    });
    $('#BookingStartDate').on('change', function(){
        var mindate = $('#BookingStartDate').val();
        if(mindate){
            $('#BookingEndDate').flatpickr({
                altInput: true,
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: mindate,
                maxDate: new Date(new Date().setMonth(new Date().getMonth() + 2))
            });
            var maxdate = $('#BookingEndDate').val();
            if(mindate && maxdate){
                var formattedMindate = formatDateToDMY(mindate);
                var formattedMaxdate = formatDateToDMY(maxdate);
                $('.Doc_Date').flatpickr({
                    altInput: false,
                    altFormat: 'd-m-Y',
                    dateFormat: 'd-m-Y',
                    minDate: formattedMindate,
                    maxDate: formattedMaxdate
                });
                $('.Amb_Date').flatpickr({
                    altInput: false,
                    altFormat: 'd-m-Y',
                    dateFormat: 'd-m-Y',
                    minDate: formattedMindate,
                    maxDate: formattedMaxdate
                });
            }
        }
    });
    $('#BookingEndDate').on('change', function(){
        var mindate = $('#BookingStartDate').val();
        var maxdate = $('#BookingEndDate').val();
        if(mindate && maxdate){
            var formattedMindate = formatDateToDMY(mindate);
            var formattedMaxdate = formatDateToDMY(maxdate);
            $('.Doc_Date').flatpickr({
                altInput: false,
                altFormat: 'd-m-Y',
                dateFormat: 'd-m-Y',
                minDate: formattedMindate,
                maxDate: formattedMaxdate
            });
            $('.Amb_Date').flatpickr({
                altInput: false,
                altFormat: 'd-m-Y',
                dateFormat: 'd-m-Y',
                minDate: formattedMindate,
                maxDate: formattedMaxdate
            });
        }
    });
        
</script>
@endsection
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
        @if($booking->pause_reason && $booking->booking_status != 0)
        <div class="alert alert-warning d-flex align-items-center p-3 mt-4" role="alert">
            <b>Pause Reason : <span style="font-weight: 400; color:black;">{{$booking->pause_reason ?? '-'}}</span></b>
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <i class="ri-close-line text-warning pt-3"><span class="path1"></span><span class="path2"></span></i>
            </button>
        </div>
        @endif
        <div class="card py-5">
            <div class="mx-5 row">
                <div class="col-6 p-0 pt-1">
                    <h5 class="mb-0"><i class="ri-information-line fs-3"></i> Booking Details | {{$booking->unique_id}}</h5>
                </div>
                <div class="col-6 text-end p-0">
                    {{-- <a href="{{route('bookings')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold waves-effect waves-light">Back</a> --}}
                </div>
            </div>
            <hr>
            <form id="Form">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
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
                                <p class="text-nowrap mb-2"><i class="ri-compass-line ri-20px me-2"></i>Area</p>
                                <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City</p>
                                <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State</p>
                                <p class="text-nowrap mb-0"><i class="ri-home-2-line ri-20px me-2 ms-50"></i>Address</p>
                            </div>
                            <div class="col-1">
                                <p class="mb-2">:</p>
                                <p class="mb-2">:</p>
                                <p class="mb-2">:</p>
                                <p class="mb-2">:</p>
                                <p class="mb-0">:</p>
                            </div>
                            <div class="col-3" style="margin-left: -70px; width:30%!important">
                                <p class="text-nowrap mb-2">{{$booking->customer_details->gender ?? "-"}}</p>
                                <p class="text-nowrap mb-2">{{$booking->area ?? "-"}}</p>
                                <p class="text-nowrap mb-2">{{$booking->city ?? "-"}}</p>
                                <p class="text-nowrap mb-2">{{$booking->state ?? "-"}}</p>
                                <p class="text-wrap mb-0">{{$booking->customer_details->address ?? "-"}}</p>
                            </div>
                        </div>
                        @endif
                        @if($booking->booking_type == "Corporate")
                        <h6 ><i class="ri-information-2-line ri-24px"></i> Corporate Details :</h6>
                        <div class="row mx-5">
                            <div class="col-2">
                                <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2"></i>Corporate Name</p>
                                <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 1</p>
                                <p class="text-nowrap mb-2"><i class="ri-phone-line ri-20px me-2"></i>Contact Number 2</p>
                                <p class="text-nowrap mb-2"><i class="ri-compass-line ri-20px me-2"></i>Area</p>
                                <p class="text-nowrap mb-2"><i class="ri-building-line ri-20px me-2 ms-50"></i>City</p>
                                <p class="text-nowrap mb-2"><i class="ri-road-map-line ri-20px me-2"></i>State</p>
                                <p class="text-nowrap mb-0"><i class="ri-map-pin-line ri-20px me-2"></i>Address</p>
                            </div>
                            <div class="col-1 text-center">
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-2">:</p>
                                <p class="text-nowrap mb-0">:</p>
                            </div>
                            <div class="col-9">
                                <p class="text-nowrap mb-2"> {{$booking->customer_details->name ?? "-"}}</p>
                                <p class="text-nowrap mb-2"> {{$booking->customer_details->mobile1 ?? "-"}}</p>
                                <p class="text-nowrap mb-2"> {{$booking->customer_details->mobile2 ?? "-"}}</p>
                                <p class="text-nowrap mb-2"> {{$booking->area ?? "-"}}</p>
                                <p class="text-nowrap mb-2"> {{$booking->city ?? "-"}}</p>
                                <p class="text-nowrap mb-2"> {{$booking->state ?? "-"}}</p>
                                <p class="text-wrap mb-0"> {{$booking->customer_details->address ?? "-"}}</p>
                            </div>
                        </div>
                        @endif
                        <hr class="mt-3">
                        <h6><i class="ri-calendar-line ri-22px"></i> Booking Date</h6>
                        <div class="row mb-4">
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="start_date" value="{{$booking->start_date}}" id="BookingStartDate" disabled/>
                                    <label for="BookingStartDate">Start Date</label>
                                </div>
                                @error('start_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="end_date" value="{{$booking->end_date}}" id="BookingEndDate" disabled/>
                                    <label for="BookingEndDate">End Date</label>
                                </div>
                                @error('end_date')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        @if(!empty($staff_data))
                        <hr>
                        <div class="form-repeater">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-nurse-line ri-22px"></i> Staff</h6>
                            </div>
                            <div data-repeater-list="staff_data">
                                @foreach($staff_data as $staff)
                                <div data-repeater-item class="StaffRow">
                                    <div class="row mb-5">
                                        <div class="col-lg-5 col-xl-5 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control staff-rate-input" value="{{$staff->name ?? ""}}" readonly>
                                                <label for="StaffRate">Staff Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-xl-5 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="doctor_shift" onchange="ShowItemsInTable()" disabled>
                                                    <option disabled selected>Select shift</option>
                                                    @if(!empty($shifts))
                                                        @foreach($shifts as $shift)
                                                            <option value="{{$shift->id}}" @if($shift->id == $staff->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="StaffRate">Shift</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control staff-rate-input" value="{{$staff->sell_rate ?? "00"}}" readonly>
                                                    <label for="StaffRate">Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if(!empty($equipment_data))
                        <hr class="mt-3">
                        <div class="form-repeater">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-syringe-line ri-22px"></i>Equipments</h6>
                            </div>
                            @foreach($equipment_data as $equipment)
                            <div data-repeater-list="equipment_data">
                                <div data-repeater-item>
                                    <div class="row mb-5">
                                        <div class="col-lg-8 col-xl-8 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control staff-rate-input" value="{{$equipment->name ?? ""}}" readonly>
                                                <label for="StaffRate">Equipment Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control staff-rate-input" value="{{$equipment->qnt ?? 1}}" readonly>
                                                <label for="EquipmentQnt">Quantity</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control equipment-rate-input" name="equipment_rate[]" value="{{$equipment->sell_rate ?? "00"}}" readonly>
                                                    <label>Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($doctor_data))
                        <hr>
                        <div class="form-repeater">
                            <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                <h6 class="mb-0"><i class="ri-stethoscope-line ri-22px"></i> Doctor</h6>
                            </div>
                            @foreach($doctor_data as $doctor)
                            <div data-repeater-list="doctor_data">
                                <div data-repeater-item>
                                    <div class="row mb-5">
                                        <div class="col-lg-4 col-xl-4 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control DoctorSelect" name="doctor_name[]" value="{{$doctor->name ?? ""}}" readonly>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-xl-4 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="doctor_shift" onchange="ShowItemsInTable()" disabled>
                                                    <option disabled selected>Select shift</option>
                                                    @if(!empty($shifts))
                                                        @foreach($shifts as $shift)
                                                            <option value="{{$shift->id}}" @if($shift->id == $doctor->shift) selected @endif>{{$shift->name}} ({{$shift->hours}} Hours)</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label for="StaffRate">Shift</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control Doc_Date" value="{{$doctor->date ?? ""}}" onchange="ShowItemsInTable()" name="date" placeholder="DD-MM-YYYY" disabled />
                                                <label for="form-repeater-1-3">Date</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control staff-rate-input" value="{{$doctor->sell_rate ?? "00"}}" readonly>
                                                    <label for="StaffRate">Rate</label>
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
                                    <div class="row mb-5">
                                        <div class=" col-lg-5 col-xl-5 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control" name="ambulance_name" value="{{$ambulance->name ?? ""}}" readonly>
                                                <label for="form-repeater-1-1">Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-xl-5 col-12">
                                            <div class="form-floating form-floating-outline">
                                                <select class="ShiftSelect select2 form-select" name="doctor_shift" onchange="ShowItemsInTable()" disabled>
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
                                        <div class="col-lg-2 col-xl-2 col-12">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text">₹</span>
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" class="form-control staff-rate-input" value="{{$ambulance->sell_rate ?? "00"}}" readonly>
                                                    <label for="StaffRate">Rate</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
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
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 76px;" aria-label="qty">days/qty</th>
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
                                            <td>₹{{ number_format($staff->sell_rate) ?? '00' }}</td>
                                            <td>{{ $staff->qnt ?? '1' }}</td>
                                            <td>₹{{ number_format($staff->sell_rate * $staff->qnt) ?? '00' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if(!empty($equipment_data))
                                    @foreach($equipment_data as $equipment)
                                        <tr>
                                            <td>{{ $equipment->name ?? '' }}</td>
                                            <td>₹{{ number_format($equipment->cost_rate) ?? '00' }}</td>
                                            <td>{{ $equipment->qnt ?? '1' }}</td>
                                            <td>₹{{ number_format($equipment->sell_rate) ?? '00' }}</td>
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
                                            <td>₹{{ number_format($doctor->sell_rate) ?? '00' }}</td>
                                            <td>{{ $doctor->qnt ?? '1' }}</td>
                                            <td>₹{{ number_format($doctor->sell_rate) ?? '00' }}</td>
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
                                            <td>₹{{ number_format($ambulance->sell_rate) ?? '00' }}</td>
                                            <td>{{ $ambulance->qnt ?? '1' }}</td>
                                            <td>₹{{ number_format($ambulance->sell_rate) ?? '00' }}</td>
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
                                <h6 class="mb-0" id="SubTotal">₹{{number_format($booking->sub_total) ?? "00.00"}}</h6>
                            </div>
                            <div class="d-flex justify-content-start gap-4">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0" id="Total">₹{{number_format($booking->total) ?? "00.00"}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>

<script>
    $(document).ready(function() {
    
    });
    $('.StaffTypeSelect').select2({
        placeholder: 'Select a staff type'
    });
    $('.StaffSelect').select2({
        placeholder: 'Select a staff'
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
        placeholder: 'Select a area',
        dropdownParent: $('#addPatientModal')
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
    });
    $('#BookingEndDate').flatpickr({
        altInput: true,
        altFormat: 'd-m-Y',
        dateFormat: 'Y-m-d',
    });
</script>
@endsection
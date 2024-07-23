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
                <h5 class="mb-0">Edit Role</h5>
            </div>
            <hr>
            @php
                $permissions = json_decode($data->permission) ?? [];
            @endphp
            <form id="Form" action="{{route('update_role')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="mb-4 mb-5">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control d-none" value="{{$data->id}}" name="id"/>
                        <input type="text" class="form-control mb-1" value="{{$data->name}}" name="name"  placeholder="Enter role name"/>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <h5>Permissions</h5>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Dashboard</b></label>
                            <div class="row">
                                @if(Auth::user()->id == 1 && $data->id == 1)
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input type="text" value="dashboard" name="permission[]" class="d-none"/>
                                        <input class="form-check-input" type="checkbox"  @if(in_array('dashboard',$permissions)) checked @endif name="permission[]" id="dashboard" disabled/>
                                        <label class="form-check-label" for="dashboard">
                                            All
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="dhc_dashboard" @if(in_array('dhc_dashboard',$permissions)) checked @endif name="permission[]" id="dhc_dashboard" />
                                        <label class="form-check-label" for="dhc_dashboard">
                                            DHC
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="hsp_dashboard" @if(in_array('hsp_dashboard',$permissions)) checked @endif name="permission[]" id="hsp_dashboard" />
                                        <label class="form-check-label" for="hsp_dashboard">
                                            HSP
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="crp_dashboard" @if(in_array('crp_dashboard',$permissions)) checked @endif name="permission[]" id="crp_dashboard" />
                                        <label class="form-check-label" for="crp_dashboard">
                                            CRP
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="analytics" @if(in_array('analytics',$permissions)) checked @endif name="permission[]" id="analytics" />
                                        <label class="form-check-label" for="analytics">
                                            Analytics
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Bookings</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="create_booking" @if(in_array('create_booking',$permissions)) checked @endif name="permission[]" id="create_booking" />
                                        <label class="form-check-label" for="create_booking">
                                            Create Booking
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="bookings" @if(in_array('bookings',$permissions)) checked @endif name="permission[]" id="bookings" />
                                        <label class="form-check-label" for="bookings">
                                            Active Booking
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="closed_bookings" @if(in_array('closed_bookings',$permissions)) checked @endif name="permission[]" id="closed_bookings" />
                                        <label class="form-check-label" for="closed_bookings">
                                            Closed Booking
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="assign_bookings" @if(in_array('assign_bookings',$permissions)) checked @endif name="permission[]" id="assign_bookings" />
                                        <label class="form-check-label" for="assign_bookings">
                                            Assign Booking
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="staff_attendance" @if(in_array('staff_attendance',$permissions)) checked @endif name="permission[]" id="staff_attendance" />
                                        <label class="form-check-label" for="staff_attendance">
                                            Staff Attendance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="booking_reviews" @if(in_array('booking_reviews',$permissions)) checked @endif name="permission[]" id="booking_reviews" />
                                        <label class="form-check-label" for="booking_reviews">
                                            Booking Reviews
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Invoice</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="active_invoice" @if(in_array('active_invoice',$permissions)) checked @endif name="permission[]" id="active_invoice" />
                                        <label class="form-check-label" for="active_invoice">
                                            Active Invoice
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="closed_invoice" @if(in_array('closed_invoice',$permissions)) checked @endif name="permission[]" id="closed_invoice" />
                                        <label class="form-check-label" for="closed_invoice">
                                            Closed Invoice
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Payments</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="salary" @if(in_array('salary',$permissions)) checked @endif name="permission[]" id="salary" />
                                        <label class="form-check-label" for="salary">
                                            Salary
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="advance_salary" @if(in_array('advance_salary',$permissions)) checked @endif name="permission[]" id="advance_salary" />
                                        <label class="form-check-label" for="advance_salary">
                                            Advance Salary
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Menus</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="staff" @if(in_array('staff',$permissions)) checked @endif name="permission[]" id="staff" />
                                        <label class="form-check-label" for="staff">
                                            Staff
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="doctors" @if(in_array('doctors',$permissions)) checked @endif name="permission[]" id="doctors" />
                                        <label class="form-check-label" for="doctors">
                                            Doctors
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="patients" @if(in_array('patients',$permissions)) checked @endif name="permission[]" id="patients" />
                                        <label class="form-check-label" for="patients">
                                            Patients
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="corporates" @if(in_array('corporates',$permissions)) checked @endif name="permission[]" id="corporates" />
                                        <label class="form-check-label" for="corporates">
                                            Corporates
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->id == 1 && $data->id == 1)
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>User Management</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input type="text" value="users" name="permission[]" class="d-none"/>
                                        <input class="form-check-input" type="checkbox"  @if(in_array('users',$permissions)) checked @endif name="permission[]" id="users" disabled/>
                                        <label class="form-check-label" for="users">
                                            Users
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input type="text" value="roles" name="permission[]" class="d-none"/>
                                        <input class="form-check-input" type="checkbox" @if(in_array('roles',$permissions)) checked @endif name="permission[]" id="roles" disabled/>
                                        <label class="form-check-label" for="roles">
                                            Roles
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Reports</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="staff_salary_report" @if(in_array('staff_salary_report',$permissions)) checked @endif name="permission[]" id="staff_salary_report" />
                                        <label class="form-check-label" for="staff_salary_report">
                                            Staff Salary
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="paused_booking_report" @if(in_array('paused_booking_report',$permissions)) checked @endif name="permission[]" id="paused_booking_report" />
                                        <label class="form-check-label" for="paused_booking_report">
                                            Paused Booking
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Masters</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="hospitals" @if(in_array('hospitals',$permissions)) checked @endif name="permission[]" id="hospitals" />
                                        <label class="form-check-label" for="hospitals">
                                            Hospitals
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="shifts" @if(in_array('shifts',$permissions)) checked @endif name="permission[]" id="shifts" />
                                        <label class="form-check-label" for="shifts">
                                            Shifts
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="equipments" @if(in_array('equipments',$permissions)) checked @endif name="permission[]" id="equipments" />
                                        <label class="form-check-label" for="equipments">
                                            Equipments
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="ambulance" @if(in_array('ambulance',$permissions)) checked @endif name="permission[]" id="ambulance" />
                                        <label class="form-check-label" for="ambulance">
                                            Ambulance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="staff_type" @if(in_array('staff_type',$permissions)) checked @endif name="permission[]" id="staff_type" />
                                        <label class="form-check-label" for="staff_type">
                                            Staff Type
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="states" @if(in_array('states',$permissions)) checked @endif name="permission[]" id="states" />
                                        <label class="form-check-label" for="states">
                                            States
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="cities" @if(in_array('cities',$permissions)) checked @endif name="permission[]" id="cities" />
                                        <label class="form-check-label" for="cities">
                                            Cities
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="area" @if(in_array('area',$permissions)) checked @endif name="permission[]" id="area" />
                                        <label class="form-check-label" for="area">
                                            Area
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('permission')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('roles')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')

@endsection
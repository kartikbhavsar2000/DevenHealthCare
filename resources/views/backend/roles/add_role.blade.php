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
                <h5 class="mb-0">Add Role</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_role')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="mb-4 mb-5">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control mb-1" value="{{old('name')}}" name="name"  placeholder="Enter role name"/>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <h5>Permissions</h5>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>Bookings</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="bookings" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Create Booking
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="assign_bookings" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Assign Booking
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
                                        <input class="form-check-input" type="checkbox" value="staff" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Staff
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="doctors" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Doctors
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="patients" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Patients
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="corporates" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Corporates
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="mb-2"><b>User Management</b></label>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="users" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Users
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="roles" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Roles
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
                                        <input class="form-check-input" type="checkbox" value="hospitals" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Hospitals
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="shifts" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Shifts
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="ambulance" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Ambulance
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="equipments" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Equipments
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="staff_type" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Staff Type
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="states" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            States
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="cities" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Cities
                                        </label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-check form-check-inline mt-4">
                                        <input class="form-check-input" type="checkbox" value="area" name="permission[]" id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">
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
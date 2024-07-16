@extends('backend.components.header')

@section('css')

@endsection

@section('content')
<div class="container">
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
</div>
<div class="row">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0">Edit Ambulance</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('update_ambulance')}}" method="POST">
                @csrf
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control d-none" value="{{$data->id}}" name="id"/>
                                <input type="text" class="form-control mb-1" value="{{$data->name}}" name="name"  placeholder="Enter full name"/>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-time-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Shifts</h5>
                        <hr>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Day Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Salary / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{$data->day_cost}}" name="day_cost" placeholder="00">
                                </div>
                                @error('day_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Night Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Salary / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{$data->night_cost}}" name="night_cost" placeholder="00">
                                </div>
                                @error('night_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Fullday Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Salary / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{$data->full_cost}}" name="full_cost" placeholder="00">
                                </div>
                                @error('full_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('ambulance')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
$('#Gender').select2({
    placeholder: 'Select a gender'
});
$('#Type').select2({
    placeholder: 'Select a type'
});
</script>
@endsection
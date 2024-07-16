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
                <h5 class="mb-0">Add Area</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_area')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="city" id="City">
                                    <option></option>
                                    @if(!empty($cities))
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 text-start">
                            <h6 class="pt-3">Add Multiple Area</h6>
                        </div>
                        <div class="col-6 text-end ">
                            <button type="button" class="btn btn-icon btn-outline-primary waves-effect" onclick="addArea()">
                                <span class="tf-icons ri-add-line ri-22px"></span>
                            </button>
                        </div>
                        <hr>
                        <div id="AreaBox" class="row">
                            <div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Area Name</label>
                                    <input type="text" class="form-control mb-1" name="name[]"  placeholder="Enter area name"/>
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('area')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    function addArea(){
        var html = `<div class="col-6 mb-3">
                                <div class="mb-4">
                                    <label class="form-label">Area Name</label>
                                    <input type="text" class="form-control mb-1" name="name[]"  placeholder="Enter area name"/>
                                </div>
                            </div>`;
        $('#AreaBox').append(html);
    }

    $('#City').select2({
        placeholder: 'Select a city'
    });
</script>
@endsection
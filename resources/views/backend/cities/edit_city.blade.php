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
                <h5 class="mb-0">Add City</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('update_city')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="state" id="State">
                                    <option></option>
                                    @if(!empty($states))
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if($data->state_id == $state->id) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('state')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1 d-none" value="{{$data->id}}" name="id"/>
                                <input type="text" class="form-control mb-1" value="{{$data->name}}" name="name"  placeholder="Enter city name"/>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('cities')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    $('#State').select2({
        placeholder: 'Select a state'
    });
</script>
@endsection
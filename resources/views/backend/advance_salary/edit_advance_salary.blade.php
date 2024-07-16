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
                <h5 class="mb-0">Edit Advance Salary</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('update_advance_salary')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Select Staff <span class="text-danger">*</span></label>
                                <input type="hidden" name="id" class="form-control" value="{{$data->id}}"/>
                                <select class="form-control mb-1" id="StaffId" disabled>
                                    <option value=""></option>
                                    @if(!empty($staff))
                                        @foreach($staff as $st)
                                            <option value="{{$st->id}}" @if($data->staff_id == $st->id) selected @endif>{{$st->f_name ?? ""}} {{$st->m_name ?? ""}} {{$st->l_name ?? ""}} - {{$st->staff_id ?? ""}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('staff_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Month <span class="text-danger">*</span></label>
                                <input type="text" value="{{$data->month ?? ""}}" name="month" placeholder="00"  class="form-control" readonly style="color: #bdbec5;"/>
                                @error('month')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Pending Amount <span class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" value="{{$data->amount ?? ""}}" name="amount" placeholder="00"  class="form-control" readonly style="color: #bdbec5;"/>
                                </div>
                                @error('amount')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Pay Amount <span class="text-danger">*</span></label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" max="{{$data->amount ?? 0}}" name="pay_amount" placeholder="00"  class="form-control"/>
                                </div>
                                @error('pay_amount')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea type="text" name="description"  class="form-control">{{$data->description ?? ""}}</textarea> 
                                @error('description')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('advance_salary')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    $('#StaffId').select2({
        placeholder: 'Select a staff'
    });
</script>
@endsection
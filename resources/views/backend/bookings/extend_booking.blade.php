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
                <h5 class="mb-0">Extend Booking | {{$booking->unique_id ?? ""}}</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('extend_booking_post')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <h6><i class="ri-calendar-line ri-22px"></i> Booking Date</h6>
                    <div class="row mb-4">
                        <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                            <div class="form-floating form-floating-outline">
                                <input type="hidden" class="form-control" name="booking_id" value="{{$booking->id}}"/>
                                <input type="text" class="form-control Date" value="{{date('d/m/Y',strtotime($booking->start_date))}}"  disabled/>
                                <label>Start Date</label>
                            </div>
                            
                        </div>
                        <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control Date" value="{{date('d/m/Y',strtotime($booking->end_date))}}" disabled/>
                                <label>End Date</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-9">
                            <div class="mb-4">
                                <label class="form-label">Select Services <span class="text-danger">*</span></label>
                                <select class="form-control" name="id[]" id="StaffId"  multiple  required>
                                    <option value=""></option>
                                    @if(!empty($bookingDetails))
                                        @foreach($bookingDetails as $b_details)
                                            <option value="{{$b_details->id}}">{{$b_details->name ?? ""}} | {{$b_details->shiftt->name ?? ""}}&ensp;(₹{{ number_format($b_details->sell_rate) ?? "0"}})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mt-8">
                            <button type="button" class="btn btn-white w-100" id="selectAll">Select All</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer text-end">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    $('#StaffId').select2({
        placeholder: 'Select',
        // allowClear: true,
        closeOnSelect: false
    });
    $('#selectAll').click(function() {
        $('#StaffId > option').each(function() {
            if ($(this).val() !== "") {
                $(this).prop("selected", true);
            }
        });
        $('#StaffId').trigger("change");
    });
</script>
@endsection
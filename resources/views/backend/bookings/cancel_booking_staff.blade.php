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
                    <h5 class="mb-0"><i class="ri-user-unfollow-line fs-3"></i> Cancel Staff From Booking| {{$booking->unique_id}}</h5>
                </div>
                <div class="col-6 text-end p-0">
                    <button class="btn btn-primary waves-effect waves-light me-2" id="showHideDetails"><span class="me-1"><i class="ri-eye-line me-1"></i> View</span>{{$booking->booking_type}} Details</button>
                </div>
            </div>
            <hr>
            <form id="Form" action="{{route('cancel_staff',$booking->id)}}" method="post">
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
                            <div class="row mx-3">
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
                                    @if(!empty($staff_data))
                                    <div class="form-repeater">
                                        <div class="mb-6 d-flex justify-content-between align-items-center pe-9">
                                            <h6 class="mb-0"><i class="ri-nurse-line ri-22px"></i>Cancel Staff</h6>
                                        </div>
                                        <div data-repeater-list="staff_data">
                                            <div class="row mb-3">
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Type
                                                </div>
                                                <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Shift
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    Customer Rate
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    From Date
                                                </div>
                                                <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0 bg-primary text-white p-2 text-center">
                                                    To Date
                                                </div>
                                            </div>
                                            @foreach($staff_data as $staff)
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="hidden" class="form-control" name="detail_id" value="{{$staff->id ?? ""}}">
                                                            <input type="text" class="form-control d-none" name="type" value="{{$staff->name ?? ""}}">
                                                            <input type="text" class="form-control" value="{{$staff->name ?? ""}}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 col-lg-4 col-xl-4 col-12 mb-0">
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
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" class="form-control StartDate" name="start_date[]" id="BookingStartDate_{{$staff->id}}" onchange="startDateChange('{{$staff->id}}')" placeholder="DD-MM-YYYY" readonly/>
                                                            <label for="BookingStartDate">Start Date</label>
                                                        </div>
                                                        @error('start_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-2 col-lg-2 col-xl-2 col-12 mb-0">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" class="form-control EndDate" name="end_date[]" id="BookingEndDate_{{$staff->id}}" placeholder="DD-MM-YYYY" readonly />
                                                            <label for="BookingEndDate">End Date</label>
                                                        </div>
                                                        @error('end_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-10">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('bookings')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
            <hr>
            <div class="mt-5 container">
                <h6><i class="ri-close-circle-line ri-22px"></i> Canceled Staff</h6>
            </div>
            <div class="my-3 container">
                <table id="kt_datatable5" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Type</th>
                            <th>Staff Id</th>
                            <th>Staff Name</th>
                            <th>Shift</th>
                            <th>Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancled_staff as $key => $staff)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$staff->type ?? "-"}}</td>
                            <td>{{$staff->staff->staff_id ?? "-"}}</td>
                            <td>{{$staff->staff_name ?? "-"}}</td>
                            <td>{{$staff->shift_name ?? "-"}}</td>
                            <td>{{date('d/m/Y',strtotime($staff->date)) ?? "-"}}</td>
                            <td>₹{{number_format($staff->sell_rate) ?? "0"}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/jquery-repeater/jquery-repeater.js"></script>

<script>
    $('#kt_datatable5').DataTable({
        dom: `<'row'<'col-sm-12'lBtr>>
			<'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
        pageLength: 10,
        buttons: [{
            extend: 'excel',
            title: 'Active Bookings List',
            exportOptions: {
                columns: [1,2,3,4,5]
            }
        }],
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all",
        }],
        initComplete: function() {
            var api = this.api();
            var row = $('<tr>').appendTo($(api.table().header()));
            api.columns().every(function() {
                var column = this;
                var title = $(column.header()).text(); // Get the title from the original header
                var input = $('<input>', {
                    type: 'text',
                    placeholder: 'Search ' + title,
                    class: 'form-control form-control-sm my-2'
                }).appendTo($('<th>').appendTo(row));

                input.on('keyup change clear', function() {
                    if (column.search() !== this.value) {
                        column.search(this.value).draw();
                    }
                });
            });

            var $buttons = $('.dt-buttons').hide();
            $('#exportLink').on('click', function() {
                var btnClass = ".buttons-excel";
                if (btnClass) $buttons.find(btnClass).click();
            })
        },
        scrollX: true,
        processing: true,
        serverSide: false,
    });

    function startDateChange(id){
        var end_date = @json($booking->end_date);
        var mindate = $('#BookingStartDate_'+id).val();
        $('#BookingEndDate_'+id).flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: mindate,
            maxDate: end_date
        });
    }
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
        var stafff = @json($staff_data);

        $.each(stafff, function( index, value ) {
            var id = value.id;
            $('#BookingStartDate_'+id).flatpickr({
                altInput: true,
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: start_date,
                maxDate: end_date
            });
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
<script>
    $(document).ready(function() {
        dataTable = $('#kt_datatable5').DataTable();
    });
    $(window).on('load', function() {
        dataTable.columns.adjust().draw();
    });
</script>
@endsection
@extends('backend.components.header')

@section('css')
<style>
    #dt-length-0{
        margin-top: 25px;
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
<div class="row">
    <div class="col-6 mb-5">
        <h4 class="mt-1 mb-1">Active Bookings</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Active Bookings</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        {{-- <a href="{{route('add_booking')}}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line"></i> Create Booking</a> --}}
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Booking ID</th>
                            <th>Type</th>
                            <th>Customer Name</th>
                            <th>Staff</th>
                            <th>Equipment</th>
                            <th>Doctor</th>
                            <th>Ambulance</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Created At</th>
                            <th>Added By</th>
                            <th>Amount Difference</th>
                            <th>Pending Amount</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!--/ Role Table -->
    </div>
</div>
@endsection


@section('javascript')

<script>
    $('#kt_datatable').DataTable({
        dom: `<'row'<'col-sm-12'lBtr>>
			<'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
        pageLength: 10,
        buttons: [{
            extend: 'excel',
            title: 'Active Bookings List',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]
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
        order: [
            [0, "asc"]
        ],
        ajax: "{{asset("get_bookings_list")}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "unique_id" ,"defaultContent": "-"},
            // { "data": "booking_type" ,"defaultContent": "-"},
            {"data": "customer_details.h_type" , render : function ( data, type, row, meta ) {
                if(row.booking_type == "Corporate"){
                    return "CRP";
                }else if(row.booking_type == "Patient"){
                    if(data == "DHC"){
                        return "DHC";
                    }else{
                        return "HSP";
                    }
                }else{
                    return "-";
                }
            }},
            { "data": "customer_details.name" ,"defaultContent": "-"},
            {"data": "is_staff" , render : function ( data, type, row, meta ) {
                if(data == 1){
                    return "<span class='badge rounded-pill bg-primary'>YES</span>";
                }else{
                    return "<span class='badge rounded-pill bg-dark'>NO</span>";
                }
            }},
            {"data": "is_equipment" , render : function ( data, type, row, meta ) {
                if(data == 1){
                    return "<span class='badge rounded-pill bg-primary'>YES</span>";
                }else{
                    return "<span class='badge rounded-pill bg-dark'>NO</span>";
                }
            }},
            {"data": "is_doctor" , render : function ( data, type, row, meta ) {
                if(data == 1){
                    return "<span class='badge rounded-pill bg-primary'>YES</span>";
                }else{
                    return "<span class='badge rounded-pill bg-dark'>NO</span>";
                }
            }},
            {"data": "is_ambulance" , render : function ( data, type, row, meta ) {
                if(data == 1){
                    return "<span class='badge rounded-pill bg-primary'>YES</span>";
                }else{
                    return "<span class='badge rounded-pill bg-dark'>NO</span>";
                }
            }},
            {"data": "start_date" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            {"data": "end_date" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            {"data": "created_at" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY hh:mm A")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            {"data": "added_by" , render : function ( data, type, row, meta ) {
                if(data){
                    return data.name;
                }else{
                    return "-";
                }
            }},
            {"data": "booking_amount_diffrence" , render : function ( data, type, row, meta ) {
                return '₹'+ parseInt(data, 10).toLocaleString();
            }},
            {"data": "pending_payment" , render : function ( data, type, row, meta ) {
                return '₹'+ parseInt(data - row.booking_amount_diffrence, 10).toLocaleString();
            }},
            {"data": "total" , render : function ( data, type, row, meta ) {
                return '₹'+ parseInt(data, 10).toLocaleString();
            }},
            {
                "data": "booking_status",
                "render": function (data, type, row, meta) {
                    if(data == 0){
                        return type === 'display' ?
                        '<button class="badge rounded-pill bg-label-primary border-0 ms-2">Active</button>' :
                        data;
                    }else{
                        return type === 'display' ?
                        '<button class="badge rounded-pill bg-label-warning border-0 ms-2">Paused</button>' :
                        data;
                    }
                }
            },
            // {
            //     "data": "id",
            //     "render": function (data, type, row, meta) {
            //         if(row.booking_status == 0){
            //             return type === 'display' ?
            //             '<a href="{{asset("/")}}view_booking_assign_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-list-view ri-20px"></i></a><a href="{{asset("/")}}view_booking_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-information-2-line ri-20px"></i></a><a href="{{asset("/")}}cancel_booking_staff/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-user-unfollow-line ri-20px"></i></a><button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="pauseBooking('+data+')"><i class="ri-pause-circle-line ri-20px"></i></button>' :
            //             data;
            //         }else{
            //             return type === 'display' ?
            //             '<a href="{{asset("/")}}view_booking_assign_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-list-view ri-20px"></i></a><a href="{{asset("/")}}view_booking_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-information-2-line ri-20px"></i></a>' :
            //             data;
            //         }
            //     }
            // },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    if(row.booking_status == 0){
                        return type === 'display' ?
                        `<div class="d-inline-block"><a href="javascript:;"
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ri-more-2-line"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                <li><a href="{{asset("/")}}view_booking_assign_details/` + data + `" class="dropdown-item"><i class="ri-list-view ri-20px"></i> View Staff List</a></li>
                                <li><a href="{{asset("/")}}view_booking_details/` + data + `" class="dropdown-item"><i class="ri-information-2-line ri-20px"></i> View Booking Details</a></li>
                                <li><a href="{{asset("/")}}extend_booking/` + data + `" class="dropdown-item"><i class="ri-add-box-line ri-20px"></i> Extend Booking</a></li>
                                <li><a href="{{asset("/")}}cancel_booking_staff/` + data + `" class="dropdown-item"><i class="ri-user-unfollow-line ri-20px"></i> Remove Staff</a></li>
                                <li><button onclick="pauseBooking('`+data+`')" class="dropdown-item"><i class="ri-pause-circle-line"></i> Pause Booking</button></li>
                            </ul>
                        </div>` :
                        data;
                    }else{
                        return type === 'display' ?
                        `<div class="d-inline-block"><a href="javascript:;"
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="ri-more-2-line"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                                <li><a href="{{asset("/")}}view_booking_assign_details/` + data + `" class="dropdown-item"><i class="ri-list-view ri-20px"></i> View Staff List</a></li>
                                <li><a href="{{asset("/")}}view_booking_details/` + data + `" class="dropdown-item"><i class="ri-information-2-line ri-20px"></i> View Booking Details</a></li>
                            </ul>
                        </div>` :
                        data;
                    }
                }
            }
        ],
        
    });

    function pauseBooking(id){
        Swal.fire({
        title: 'Confirm Your Action',
        text: "Are you sure you want to pause the booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        customClass: {
          confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false,
        input:'textarea',
        inputPlaceholder: 'Enter reason for pause...',
        buttonsStyling: false,
        }).then(function(result) {
            if (result.isConfirmed) {
                let rejectionReason = result.value;
                $.ajax({
                    url: "{{route('pause_booking')}}",
                    method: "POST",
                    data: {
                        id: id,
                        reason: rejectionReason,
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if(result == "Done"){
                            Swal.fire({
                                title:'Done!',
                                text: 'The booking paused successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                            setTimeout(function() { window.location.reload(); }, 500);
                        }else if(result == "Date"){
                            Swal.fire({
                                title: 'Error',
                                text: 'The booking has expired and cannot be paused.',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                        }else if(result == "Date2"){
                            Swal.fire({
                                title: 'Error',
                                text: 'You can not pause this booking.',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                        }else{
                            Swal.fire({
                                title: 'Error',
                                text: 'No Data Found!',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                        }
                    }
                });
            }
        }); 
    }

</script>

@endsection
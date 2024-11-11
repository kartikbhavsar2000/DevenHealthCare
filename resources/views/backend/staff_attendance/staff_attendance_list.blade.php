@extends('backend.components.header')

@section('css')
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
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
    <div class="col-4 mb-5">
        <h4 class="mt-1 mb-1">Staff Attendance</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Staff Attendance</p>
    </div>
    <div class="col-8 mb-5 text-end pt-5 pe-5">
        <button id="approveBulckBtn" class="btn btn-success me-1 d-none" onclick="approveBulckClick()"><i class="ri-check-line"></i> <span class="nav-text">Approve</span></button>
        <button id="rejectBulckBtn" class="btn btn-danger me-1 d-none" onclick="rejectBulckClick()"><i class="ri-close-line"></i> <span class="nav-text">Reject</span></button>
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-1"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <div class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-primary h-40px fs-7 waves-effect waves-light p-0">
            <div class="form-floating form-floating-outline">
                <input type="text" id="StaffAttandanceDaterange" class="p-2 rounded border-0 bg-primary text-white" readonly/>
            </div>
        </div>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="CheckAll" class="form-check" onclick="CheckAll()" /></th>
                            <th>Sr No.</th>
                            <th>Booking ID</th>
                            <th>Booking Type</th>
                            <th>Hospital Name</th>
                            <th>Type</th>
                            <th>Assigned Staff</th>
                            <th>Shift</th>
                            <th>Booking Date</th>
                            <th>Attendance Date & Time</th>
                            <th>Staff Cost</th>
                            <th>Rejection Reason</th>
                            <th>Location</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
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
<script src="{{asset('public')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>

<script>
    
    $('#StaffAttandanceDaterange').daterangepicker({
        opens: 'left',
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: moment().startOf('day').format('DD/MM/YYYY'),
        endDate: moment().endOf('day').format('DD/MM/YYYY')
    }, function (start, end, label) {
        fetchAttendanceData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    });

    var table = $('#kt_datatable').DataTable({
        dom: `<'row'<'col-sm-12'lBtr>>
            <'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
        pageLength: 10,
        ordering: false,
        buttons: [{
            extend: 'excel',
            title: 'Bookings List',
            exportOptions: {
                columns: [2,3,4,5,6,7,8,10,11,12,13,14,15]
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

                // Create input field for search
                var input = $('<input>', {
                    type: 'text',
                    placeholder: 'Search ' + title,
                    class: 'form-control form-control-sm my-2'
                }).appendTo($('<th>').appendTo(row));

                // On keyup, change, or clear, perform the search
                input.on('keyup change clear', function() {
                    var searchValue = this.value;

                    // If it's a date column, convert the search input to the date format used in the render function
                    if (title.toLowerCase().includes('date')) {
                        if (searchValue) {
                            searchValue = moment(searchValue, "DD/MM/YYYY").format("YYYY-MM-DD");
                        }
                    }

                    // If the search input is empty, clear the search and show all data
                    if (searchValue === "") {
                        column.search('').draw();
                    } else if (column.search() !== searchValue) {
                        column.search(searchValue).draw();
                    }
                });
            });

            var $buttons = $('.dt-buttons').hide();
            $('#exportLink').on('click', function() {
                var btnClass = ".buttons-excel";
                if (btnClass) $buttons.find(btnClass).click();
            })
        },
        scrollY: "400px",
        scrollX: true,
        bScrollCollapse : true,
        processing: true,
        serverSide: false,
        order: [
            [0, "asc"]
        ],
        ajax: "{{asset("get_staff_attendance_list")}}",
        columns:[
            {"data": "id" , render : function ( data, type, row, meta ) {
                if(data){
                    if (row.status == 0) {
                        return type === 'display'  ?
                        '<input type="checkbox" class="BulkCheckBox" onclick="showHideBulckButton()" value="'+data+'" class="form-check" />' :
                        data;
                    }else{
                        return type === 'display'  ?
                        '<input type="checkbox" class="form-check" disabled />' :
                        data;
                    }
                }else{
                    return "-";
                }
            }},
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "booking.unique_id" ,"defaultContent": "-"},
            {"data": "customer_details.h_type" , render : function ( data, type, row, meta ) {
                if(row.booking.booking_type == "Corporate"){
                    return "CRP";
                }else if(row.booking.booking_type == "Patient"){
                    if(data == "DHC"){
                        return "DHC";
                    }else{
                        return "HSP";
                    }
                }else{
                    return "-";
                }
            }},
            { "data": "customer_details.h_type" ,"defaultContent": "-"},
            { "data": "type" ,"defaultContent": "-"},
            {
                data: "staff.f_name",
                render: function (data, type, row, meta) {
                    // Check if the proof image exists
                    if(row.staff){
                        const fullName = `${row.staff.f_name} ${row.staff.m_name || ''} ${row.staff.l_name || ''}`.trim();
                        const nameToShow = fullName.length > 0 ? fullName : 'Name not available';

                        const proof = row.att_proof ? 
                        `<a href="{{asset('public/staff_attendance')}}/${row.att_proof}" target="_blank"><img src="{{asset('public/staff_attendance')}}/${row.att_proof}" loading="lazy" alt="Avatar" class="rounded-circle"></a>` : 
                        `<span class="avatar-initial rounded-circle bg-label-danger">${row.staff.f_name.charAt(0)}</span>`;
                    
                        // Return the formatted HTML if the type is 'display'
                        if (type === 'display') {
                            return `
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar me-2">${proof}</div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="emp_name text-truncate text-heading fw-medium">${nameToShow}</span>
                                        <small class="emp_post text-truncate">${row.staff.staff_id}</small>
                                    </div>
                                </div>`;
                        }
                        
                        // Otherwise, return the raw data
                        return data;
                    }else{
                        return "-";
                    }
                }
            },
            { "data": "shift.name" ,"defaultContent": "-"},
            {"data": "date" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            {
                data: "att_date_time",
                render: function (data, type, row, meta) {
                    if (data) {
                        return type === 'display' ?
                            moment(new Date(data)).format("DD/MM/YYYY hh:mm A") :
                            data;
                    } else {
                        return "-";
                    }
                }
            },
            {"data": "cost_rate" , render : function ( data, type, row, meta ) {
                if(data){
                    return '₹'+ parseInt(data, 10).toLocaleString();
                }else{
                    return "-";
                }
            }},
            { "data": "rej_reason" ,"defaultContent": "-"},
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    if(row.lat && row.lng){
                        return type === 'display' ?
                        '<a href="https://www.google.com/maps/search/?api=1&query='+row.lat+','+row.lng+'" target="_blank" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-map-pin-line"></i></a>' :
                        data;
                    }else{
                        return type === 'display' ?
                        '<span class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-map-pin-line" style="color:#bbbcbe;"></i></span>' :
                        data;   
                    }
                }
            },
            { "data": "updated_by_user.name" ,"defaultContent": "-"},
            {
                data: "updated_at",
                render: function (data, type, row, meta) {
                    if (data) {
                        return type === 'display' ?
                            moment(new Date(data)).format("DD/MM/YYYY hh:mm A") :
                            data;
                    } else {
                        return "-";
                    }
                }
            },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    if (row.status == 0) {
                        return type === 'display' ?
                            `<button class="badge rounded-pill bg-label-warning border-0">Pending</button>` :
                            data;
                    } else if (row.status == 1) {
                        return type === 'display' ?
                            '<button class="badge rounded-pill bg-label-primary border-0">Approved</button>' :
                            data;
                    } else if (row.status == 2) {
                        return type === 'display' ?
                            '<button class="badge rounded-pill bg-label-secondary border-0">Rejected</button>' :
                            data;
                    } else {
                        return "-";
                    }
                }
            },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    if (row.status == 0) {
                        return type === 'display' ?
                            `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="changeStatus('${row.id}', '1')">
                                <i class="ri-check-line"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="changeStatus('${row.id}', '2')">
                                <i class="ri-close-line"></i>
                            </button>` :
                            data;
                    } else {
                        return `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="deleteAttandance('${row.id}')">
                                <i class="ri-delete-bin-7-line"></i>
                            </button>`;
                    }
                }
            }
        ],
        
    });

    function CheckAll(){
        if($('#CheckAll').is(':checked')){
            $('.BulkCheckBox').prop('checked', true);
        } else {
            $('.BulkCheckBox').prop('checked', false);
        }
        showHideBulckButton();
    }
    function showHideBulckButton(){
        var numItems = $('.BulkCheckBox:checked').length;
        console.log(numItems);
        if(numItems > 0){
            $('#approveBulckBtn').removeClass('d-none');
            $('#rejectBulckBtn').removeClass('d-none');
            $('#CheckAll').prop('checked', true);
        }else{
            $('#approveBulckBtn').addClass('d-none');
            $('#rejectBulckBtn').addClass('d-none');
            $('#CheckAll').prop('checked', false);
        }
    }
    function approveBulckClick() {
        // Get all checked checkbox values
        var ids = $('.BulkCheckBox:checked').map(function() {
            return $(this).val();
        }).get(); // Converts the result to an array
        
        if(ids.length === 0) {
            alert('No items selected');
            return;
        }

        $.ajax({
            url: '{{route("approve_bulk_attendance")}}',
            method: "POST",
            data: {
                id: ids, // Pass the array of ids
                _token: "{{ csrf_token() }}"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    function rejectBulckClick(){
        var ids = $('.BulkCheckBox:checked').map(function() {
            return $(this).val();
        }).get(); // Converts the result to an array
        
        if(ids.length === 0) {
            alert('No items selected');
            return;
        }

        $.ajax({
            url: '{{route("reject_bulk_attendance")}}',
            method: "POST",
            data: {
                id: ids, // Pass the array of ids
                _token: "{{ csrf_token() }}"
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Function to fetch and display attendance data
    function fetchAttendanceData(startDate, endDate) {
        $.ajax({
            url: '{{route("get_staff_attendance_list")}}',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function (response) {
                table.clear();
                table.rows.add(response.data); // Assuming `response.data` is an array of data rows
                table.draw();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    
    function changeStatus(id, status){
        if(status == 1){
            var btnText = "Approve";
        }else{
            var btnText = "Reject";
        }

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, '+btnText+' it!',
        customClass: {
          confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false,
        input: status == 2 ? 'textarea' : null,
        inputPlaceholder: 'Enter reason for rejection...',
        // inputValidator: status == 2 ? (value) => {
        //     if (!value) {
        //         return 'You need to provide a reason!';
        //     }
        // } : null,
        buttonsStyling: false,
        }).then(function(result) {
            if (result.isConfirmed) {
                let rejectionReason = status == 2 ? result.value : null;
                var startDate = $('#StaffAttandanceDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#StaffAttandanceDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                $.ajax({
                    url: "{{route('approve_reject_staff_attendance')}}",
                    method: "POST",
                    data: {
                        id: id,
                        status: status,
                        reason: rejectionReason,
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if(result == "Done"){
                            Swal.fire({
                                title: status == 1 ? 'Approved!' : 'Rejected!',
                                text: status == 1 ? 'The staff attendance was approved successfully!' : 'The staff attendance was rejected successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                            fetchAttendanceData(startDate, endDate);
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
                            fetchAttendanceData(startDate, endDate);
                        }
                    }
                });
            }
        }); 
    }

    function deleteAttandance(id){

        Swal.fire({
        title: 'Confirm Your Action',
        text: "Are you sure you want to unmark the attendance?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        customClass: {
          confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        }
        }).then(function(result) {
            if (result.isConfirmed) {
                var startDate = $('#StaffAttandanceDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#StaffAttandanceDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                $.ajax({
                    url: "{{route('make_attandance_pending')}}",
                    method: "POST",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if(result == "Done"){
                            Swal.fire({
                                title:'Done!',
                                text: 'The attendance unmarked successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            });
                            fetchAttendanceData(startDate, endDate);
                            // setTimeout(function() { window.location.reload(); }, 500);
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
                            fetchAttendanceData(startDate, endDate);
                            // setTimeout(function() { window.location.reload(); }, 500);
                        }
                    }
                });
            }
        }); 
    }

</script>

@endsection
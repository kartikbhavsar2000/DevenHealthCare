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
        <h4 class="mt-1 mb-1">Active Invoice</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Active Invoice</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
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
                            <th>Hospital Name</th>
                            <th>Customer Name</th>
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
            title: 'Active Invoice List',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9,10,11,12]
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
        ajax: "{{asset("get_active_invoice_list")}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "unique_id" ,"defaultContent": "-"},
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
            { "data": "customer_details.h_type" ,"defaultContent": "-"},
            { "data": "customer_details.name" ,"defaultContent": "-"},
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
            //         return type === 'display' ?
            //         '<a href="{{asset("/")}}view_booking_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-information-2-line ri-20px"></i></a><button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onClick="closeBooking('+data+')"><i class="ri-close-circle-line ri-20px"></i></button><a href="{{asset("/")}}generate_invoice/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-file-list-3-line ri-20px"></i></a>' :
            //         data;
            //     }
            // },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    `<div class="d-flex">
                        <a href="{{asset("/")}}view_booking_assign_details/` + data + `" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-list-view ri-20px"></i></a>
                        <a href="{{asset("/")}}view_booking_details/` + data + `" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-information-2-line ri-20px"></i></a>
                        <a href="{{asset("/")}}generate_invoice/` + data + `" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-file-list-3-line ri-20px"></i></a>
                        <button onclick="closeBooking('`+data+`')" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-close-circle-line ri-20px"></i></button>
                    </div>` :
                    data;
                }
            }
        ],
        
    });

    function closeBooking(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        customClass: {
          confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false,
        allowOutsideClick: false
        }).then(function(result) {
            if(result.dismiss != 'cancel'){
                $.ajax({
                    url:"{{route('close_booking')}}",
                    method:"POST",
                    data:{'id':id,_token:"{{ csrf_token() }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result)
                    {
                        if(result == "Error"){
                            Swal.fire({
                                title: 'Error!',
                                text: "There should be at least one payment history to close the booking.",
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
                                title: 'Closed!',
                                text: "The booking closed succsessfully!",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                                },
                                buttonsStyling: false
                            }); 
                            setTimeout(function(){ window.location.reload(); }, 500);
                        }
                    }
                }); 
            }
        }); 
    }

</script>

@endsection
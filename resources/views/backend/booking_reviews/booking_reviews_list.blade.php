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
    <div class="col-6 mb-5">
        <h4 class="mt-1 mb-1">Booking Reviews</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Booking Reviews</p>
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
                            <th>Hospital Name</th>
                            <th>Customer Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            {{-- <th>Created At</th>
                            <th>Added By</th> --}}
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
            title: 'Bookings List',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
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
        ajax: "{{asset("get_booking_reviews_list")}}",
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
            // {"data": "created_at" , render : function ( data, type, row, meta ) {
            //     if(data){
            //         return type === 'display'  ?
            //         ''+ moment(new Date(data)).format("DD/MM/YYYY hh:mm A")  +'' :
            //         data;
            //     }else{
            //         return "-";
            //     }
            // }},
            // {"data": "added_by" , render : function ( data, type, row, meta ) {
            //     if(data){
            //         return data.name;
            //     }else{
            //         return "-";
            //     }
            // }},
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    if(row.booking_status == 0){
                        return type === 'display' ?
                        '<button class="badge rounded-pill bg-label-primary border-0 ms-2">Open</button>' :
                        data;
                    }else{
                        return type === 'display' ?
                        '<button class="badge rounded-pill bg-label-secondary border-0 ms-2">Closed</button>' :
                        data;
                    }
                }
            },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    '<a href="{{asset("/")}}view_booking_details/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-information-2-line ri-20px"></i></a><a href="{{asset("/")}}add_booking_reviews/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-user-star-line ri-20px"></i></a>' :
                    data;
                }
            },
        ],
        
    });

</script>

@endsection
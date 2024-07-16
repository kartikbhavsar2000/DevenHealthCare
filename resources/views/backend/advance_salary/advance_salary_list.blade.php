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
        <h4 class="mt-1 mb-1">Advance Salary</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Advance Salary</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <a href="{{route('add_advance_salary')}}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line"></i> Add Advance Salary</a>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Staff Name</th>
                            <th>Month</th>
                            <th>Pending Amount</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            {{-- <th>Status</th> --}}
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
            title: 'Advance Salary List',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8]
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
        ajax: "{{asset("get_advance_salary_list")}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            {
                data: "staff",
                render: function (data, type, row, meta) {
                    var m_name = data.m_name ? " " + data.m_name : "";
                    var l_name = data.l_name ? " " + data.l_name : "";
                    return type === 'display' ? data.f_name + m_name + l_name : data;
                }
            },
            { "data": "month" ,"defaultContent": "-"},
            {
                "data": "amount",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    '₹'+ parseInt(data, 10).toLocaleString() :
                    data;
                }
            },
            { "data": "description" ,"defaultContent": "-"},
            {"data": "created_at" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY hh:mm A")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            {"data": "updated_at" , render : function ( data, type, row, meta ) {
                if(data){
                    return type === 'display'  ?
                    ''+ moment(new Date(data)).format("DD/MM/YYYY hh:mm A")  +'' :
                    data;
                }else{
                    return "-";
                }
            }},
            { "data": "created_by_user.name" ,"defaultContent": "-"},
            { "data": "updated_by_user.name" ,"defaultContent": "-"},
            // {
            //     "data": "status",
            //     "render": function (data, type, row, meta) {
            //         if(data == 0){
            //             return type === 'display' ?
            //             '<button onclick="changeStatus('+row.id+')" class="btn btn-label-warning w-100">Unpaid</button>' :
            //             data;
            //         }else{
            //             return type === 'display' ?
            //             '<button class="btn btn-label-success w-100">Paid</button>' :
            //             data;
            //         }
            //     }
            // },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    '<a href="{{asset("/")}}edit_advance_salary/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-box-line ri-20px"></i></a><a href="{{asset("/")}}advance_salary_history/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-history-line ri-20px"></i></a>' :
                    data;
                }
            },
        ],
        
    });

    function changeStatus(id){
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
        buttonsStyling: false
        }).then(function(result) {
            if(result.dismiss != 'cancel'){
                $.ajax({
                    url:"{{route('advance_salary_change_status')}}",
                    method:"POST",
                    data:{'id':id,_token:"{{ csrf_token() }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result)
                    {
                        Swal.fire({
                            title: 'Changed!',
                            text: "The status changed succsessfully!",
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
                }); 
            }
        }); 
    }
</script>

@endsection
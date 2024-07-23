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
        <h4 class="mt-1 mb-1">Equipments</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Equipments</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <a href="{{route('add_equipment')}}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line"></i> Add Equipment</a>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Cost Price</th>
                            <th>Selling Price</th>
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
            title: 'Equipments List',
            exportOptions: {
                columns: [1,2,3,4]
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
        ajax: "{{asset("get_equipments_list")}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "name" ,"defaultContent": "-"},
            { "data": "type" ,"defaultContent": "-"},
            {
                "data": "cost_price",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    '₹'+ parseInt(data, 10).toLocaleString() :
                    data;
                }
            },
            {
                "data": "sell_price",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    '₹'+ parseInt(data, 10).toLocaleString() :
                    data;
                }
            },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    var checked = "";
                    if(row.status == 1){
                        checked = "checked";
                    }
                    return type === 'display' ?
                    '<a href="{{asset("/")}}edit_equipment/' + data + '" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-box-line ri-20px"></i></a><label class="switch"><input type="checkbox" class="switch-input" '+checked+' onclick="changeStatus('+row.id+')"/><span class="switch-toggle-slider"><span class="switch-on"></span><span class="switch-off"></span></span></label>' :
                    data;
                }
            },
        ],
        
    });

    function changeStatus(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You want to change the status!",
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
                    url:"{{route('change_equipment_status')}}",
                    method:"POST",
                    data:{'id':id,_token:"{{ csrf_token() }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result)
                    {
                        Swal.fire({
                            title: 'Updated!',
                            text: "The status changed succsessfully!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'ok',
                            customClass: {
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                            },
                            buttonsStyling: false
                        }); 
                        // setTimeout(function(){ window.location.reload(); }, 500);
                    }
                }); 
            }else{
                setTimeout(function(){ window.location.reload(); }, 500);
            }
        }); 
    }

    function deleted(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
          cancelButton: 'btn btn-outline-secondary waves-effect'
        },
        buttonsStyling: false
        }).then(function(result) {
            if(result.dismiss != 'cancel'){
                $.ajax({
                    url:"{{route('delete_equipment')}}",
                    method:"POST",
                    data:{'id':id,_token:"{{ csrf_token() }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result)
                    {
                        Swal.fire({
                            title: 'Deleted!',
                            text: "The equipment deleted succsessfully!",
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
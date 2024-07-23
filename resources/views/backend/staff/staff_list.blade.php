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
        <h4 class="mt-1 mb-1">Staff</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Staff</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <a href="{{route('add_staff')}}" class="btn btn-primary waves-effect waves-light"><i class="ri-add-line"></i> Add Staff</a>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Staff Id</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th style="width: 200px;">Rating</th>
                            <th>Mobile</th>
                            <th>Area</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Exp</th>
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
            title: 'Staff List',
            exportOptions: {
                columns: [1,2,3,4,5,6,7,8,9]
            }
        }],
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all",
        },{ 
            width: "200px", 
            targets: 4 
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
        ajax: "{{asset("get_staff_list")}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "staff_id" ,"defaultContent": "-"},
            { "data": "types.title" ,"defaultContent": "-"},
            {
                data: "f_name",
                render: function (data, type, row, meta) {
                    var m_name = row.m_name ? " " + row.m_name : "";
                    var l_name = row.l_name ? " " + row.l_name : "";
                    return type === 'display' ? data + m_name + l_name : data;
                }
            },
            {
                data: "rating",
                render: function (data, type, row, meta) {
                    var rating = "";
                    var maxStars = 5;
                    var wholeStars = Math.floor(data); // Number of full stars
                    var fractionalPart = data - wholeStars; // Fractional part of the rating
                    var halfStar = fractionalPart >= 0.25 && fractionalPart < 0.75; // Whether to show a half star
                    var additionalStar = fractionalPart >= 0.75 ? 1 : 0; // Add an additional full star if the fractional part is >= 0.75

                    // Render full stars
                    for (var i = 1; i <= wholeStars + additionalStar; i++) {
                        rating += `<i class="ri-star-fill" style="color:gold;"></i>`;
                    }

                    // Render half star if needed
                    if (halfStar) {
                        rating += `<i class="ri-star-half-s-fill" style="color:gold;"></i>`;
                    }

                    // Render empty stars
                    for (var i = wholeStars + additionalStar + (halfStar ? 1 : 0); i < maxStars; i++) {
                        rating += `<i class="ri-star-line" style="color:gold;"></i>`;
                    }

                    if(data == 1){
                        rating += `<br> `+data+` Star`;
                    }else{
                        rating += `<br> `+data+` Stars`;
                    }

                    return rating;
                }
            },

            // { "data": "rating" ,"defaultContent": "-"},
            { "data": "mobile" ,"defaultContent": "-"},
            { "data": "area.name" ,"defaultContent": "-"},
            { "data": "gender" ,"defaultContent": "-"},
            {"data": "age" , render : function ( data, type, row, meta ) {
                if(data != null){
                    return type === 'display'  ?
                    data + " Years" :
                    data;
                }else{
                    return "-";
                }
            }},
            {"data": "experience" , render : function ( data, type, row, meta ) {
                if(data < 2){
                    return type === 'display'  ?
                    data + " Year" :
                    data;
                }else{
                    return type === 'display'  ?
                    data + " Years" :
                    data;
                }
            }},
            // {
            //     "data": "id",
            //     "render": function (data, type, row, meta) {
            //         return type === 'display' ?
            //         `<div class="d-inline-block"><a href="javascript:;"
            //                 class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
            //                 aria-expanded="false"><i class="ri-more-2-line"></i></a>
            //             <ul class="dropdown-menu dropdown-menu-end m-0" style="">
            //                 <li><a href="{{asset("/")}}view_staff_details/` + data + `" class="dropdown-item"><i class="ri-information-line ri-20px"></i> View Staff Details</a></li>
            //                 <li><a href="{{asset("/")}}view_staff_reviews/` + data + `" class="dropdown-item"><i class="ri-user-star-line ri-20px"></i> Staff Ratings</a></li>
            //                 <li><a href="{{asset("/")}}edit_staff/` + data + `" class="dropdown-item"><i class="ri-edit-box-line ri-20px"></i> Edit Staff</a></li>
            //                 <li><a href="{{asset("/")}}staff_salary_slip/` + data + `" class="dropdown-item"><i class="ri-file-list-2-line"></i> Staff Salary Slip</a></li>
            //                 <li><a href="{{asset("/")}}change_staff_password/` + data + `" class="dropdown-item"><i class="ri-key-2-line"></i> Change Password</a></li>
            //                 <div class="dropdown-divider"></div>
            //                 <li><button onClick="deleted(`+data+`)" class="dropdown-item text-danger"><i class="ri-delete-bin-7-line" style="font-size:19px;"></i> Delete Staff</button></li>
            //             </ul>
            //         </div>` :
            //         data;
            //     }
            // },
            {
                "data": "status",
                "render": function (data, type, row, meta) {
                    var checked = "";
                    if(data == 1){
                        checked = "checked";
                    }
                    return type === 'display' ?
                    '<label class="switch"><input type="checkbox" class="switch-input" '+checked+' onclick="changeStatus('+row.id+')"/><span class="switch-toggle-slider"><span class="switch-on"></span><span class="switch-off"></span></span></label>' :
                    data;
                }
            },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    return type === 'display' ?
                    `<div class="d-inline-block"><a href="javascript:;"
                            class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="ri-more-2-line"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                            <li><a href="{{asset("/")}}view_staff_details/` + data + `" class="dropdown-item"><i class="ri-information-line ri-20px"></i> View Staff Details</a></li>
                            <li><a href="{{asset("/")}}view_staff_reviews/` + data + `" class="dropdown-item"><i class="ri-user-star-line ri-20px"></i> Staff Ratings</a></li>
                            <li><a href="{{asset("/")}}edit_staff/` + data + `" class="dropdown-item"><i class="ri-edit-box-line ri-20px"></i> Edit Staff</a></li>
                            <li><a href="{{asset("/")}}staff_salary_slip/` + data + `" class="dropdown-item"><i class="ri-file-list-2-line"></i> Staff Salary Slip</a></li>
                            <li><a href="{{asset("/")}}change_staff_password/` + data + `" class="dropdown-item"><i class="ri-key-2-line"></i> Change Password</a></li>
                        </ul>
                    </div>` :
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
                    url:"{{route('change_staff_status')}}",
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
                    url:"{{route('delete_staff')}}",
                    method:"POST",
                    data:{'id':id,_token:"{{ csrf_token() }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result)
                    {
                        Swal.fire({
                            title: 'Deleted!',
                            text: "The staff deleted succsessfully!",
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
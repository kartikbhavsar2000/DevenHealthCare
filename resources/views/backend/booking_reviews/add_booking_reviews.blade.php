@extends('backend.components.header')

@section('css')
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/rateyo/rateyo.css" />
@endsection

@section('content')
<div class="container">
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
</div>
<div class="row">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0"><i class="ri-user-star-line ri-22px"></i> Add Staff Rating | {{$booking->unique_id ?? ""}}</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_booking_reviews')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-9 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Select Staff<span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" name="booking_id" value="{{$booking->id}}"/>
                                <input type="hidden" class="form-control" id="StaffType" name="staff_type"/>
                                <select class="form-control mb-1" name="staff_id" id="Staff" onchange="addStaffType(this)">
                                    <option value=""></option>
                                    @if(!empty($data))
                                        @foreach($data as $staff)
                                            <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }} data-type="{{$staff->type_name ?? ""}}">
                                                {{$staff->staff_name ?? ""}} | {{$staff->unique_id ?? ""}} | {{$staff->type_name ?? ""}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('staff_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">Select Rating Stars</label>
                            <div class="full-star-ratings mt-1" id="rateYo"></div>
                            <input type="hidden" name="rating" id="rating">
                        </div>
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea class="form-control mb-1" placeholder="Enter description" name="description">{{old('description')}}</textarea>
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
                    <a href="{{route('booking_reviews')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row mt-12">
    <div class="col-6">
        <h4 class="mt-1">Staff Reviews</h4>
    </div>
    <div class="col-6 text-end pe-5">
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
                            <th>Type</th>
                            <th>Staff Name</th>
                            <th>Rating</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Added By</th>
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
<script src="{{asset('public')}}/assets/vendor/libs/rateyo/rateyo.js"></script>
<script>
    $('#kt_datatable').DataTable({
        dom: `<'row'<'col-sm-12'lBtr>>
			<'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
        pageLength: 10,
        buttons: [{
            extend: 'excel',
            title: '{{$booking->unique_id}}_Staff_Review_List',
            exportOptions: {
                columns: [1,2,3,4,5,6]
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
        ajax: "{{route("get_staff_reviews_list",$booking->id)}}",
        columns:[
            { "render": function(data, type, full, meta) {
                    return meta.row+1;
            }},
            { "data": "type" ,"defaultContent": "-"},
            { "data": "staff_name" ,"defaultContent": "-"},
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
            {"data": "created_by" , render : function ( data, type, row, meta ) {
                if(data){
                    return data.name;
                }else{
                    return "-";
                }
            }},
        ],
    });
</script>
<script>
function addStaffType(thiss){
    var selectedOption = $(thiss).find(':selected');
    var dataType = selectedOption.data('type');
    $('#StaffType').val(dataType);
}
$(function () {
    $("#rateYo").rateYo({
        fullStar: true,
        onSet: function (rating, rateYoInstance) {
            $("#rating").val(rating);
        }
    });
});
$('#Staff').select2({
    placeholder: 'Select a staff'
});
</script>
@endsection
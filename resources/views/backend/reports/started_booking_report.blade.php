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
    <div class="col-6 mb-5">
        <h4 class="mt-1 mb-1">Services Report</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Services Report</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <button class="btn btn-primary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="ri-filter-line me-1"></i>Filter
        </button>
    </div>
    <div class="col-12 my-3">
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <div class="row">
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Services</label>
                            <select class="form-control mb-1" id="Services">
                                <option value=" " selected>All</option>
                                @if(!empty($staff_type))
                                    @foreach($staff_type as $st)
                                        <option value="{{$st->id}}">{{$st->title ?? "-"}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Category</label>
                            <select class="form-control mb-1" id="Category">
                                <option value=" " selected>All</option>
                                <option value="DHC">Deven Health Care</option>
                                <option value="HSP">Hospitals</option>
                                <option value="CRP">Corporates</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select class="form-control mb-1" id="Status">
                                <option value=" " selected>All</option>
                                <option value="1">Active</option>
                                <option value="2">Closed</option>
                                <option value="3">Paused</option>
                                <option value="4">Stopped</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Type</label>
                            <select class="form-control mb-1" id="Type">
                                <option value=" " selected>All</option>
                                <option value="12">12Hrs Services</option>
                                <option value="24">24Hrs Services</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label"  for="Daterange">Date</label>
                            <div class="dropdown d-none d-sm-flex">
                                <input type="text" id="Daterange" class="form-control" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mt-8">
                            <button class="btn btn-primary waves-effect waves-light" type="button" onclick="filterData()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable5" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>BookingId</th>
                            <th>Customer Name</th>
                            <th>Service Name</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="TData">
                        
                    </tbody>
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
    function filterData(){
        $("#loader").fadeIn("slow");
        $("#DATAAA").fadeOut("slow");

        var category = $('#Category').val();
        var services = $('#Services').val();
        var status = $('#Status').val();
        var type = $('#Type').val();
        var date_range = $('#Daterange').val();

        var table = $('#kt_datatable5').DataTable();
                table.clear().draw();

        $.ajax({
            url:"{{route('get_started_booking_report_data')}}",
            method:"GET",
            data:{'category':category,'services':services,'status':status,'type':type,'date_range':date_range,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                console.log(result);
                var rows = '';
                $.each(result, function(index, item) {
                    var type = item.booking_type == "Corporate" ? "CRP" :
                            (item.booking_type == "Patient" ? (item.h_type == "DHC" ? "DHC" : "HSP") : "-");

                    var shift = (item.shift == 1 || item.shift == 2) ? "12Hrs Shift" : "24Hrs Shift";
                    if(item.is_cancled == 0){
                        var status = item.booking_status == 0 ? "<p class='m-0 text-success bg-label-success text-center p-1 rounded'>Active</p>" :
                                item.booking_status == 1 ? "<p class='m-0 text-secondary bg-label-secondary text-center p-1 rounded'>CLOSED</p>" :
                                item.booking_status == 2 ? "<p class='m-0 text-warning bg-label-warning text-center p-1 rounded'>PAUSED</p>" : "-";
                    }else{
                        var status = "<p class='m-0 text-danger bg-label-danger text-center p-1 rounded'>Stopped</p>";
                    }
                    var amount = '₹'+ parseInt(item.sell_rate, 10).toLocaleString();

                    rows += '<tr><td>' + (index + 1) + '</td><td>' + item.unique_id + '</td><td>' + item.customer_name + '</td><td>' +
                            item.type + '</td><td>' + shift + '</td><td>' + type + '</td><td>' +
                            moment(new Date(item.date)).format("DD/MM/YYYY") + '</td><td>' + status + '</td><td>' + amount + '</td></tr>';
                });
                table.rows.add($(rows)).draw(false);
                $("#loader").fadeOut("slow");
                $("#DATAAA").fadeIn("slow");

            }
        }); 
    }
    $(document).ready(function() {
        var table =$('#kt_datatable5').DataTable({
            dom: `<'row'<'col-sm-12'lBtr>>
			<'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
            pageLength: 10,
            scrollX: true,
            deferRender: true,
            buttons: [{
                extend: 'excel',
                title: 'Services Report',
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
        });
        filterData();
    });
    $('#Daterange').daterangepicker({
        opens: 'left',
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: moment().startOf('month').format('DD/MM/YYYY'),
        endDate: moment().endOf('month').format('DD/MM/YYYY')
    });
    $('#Category').select2({
        placeholder: 'Select a category'
    });
    $('#Services').select2({
        placeholder: 'Select a services'
    });
    $('#Status').select2({
        placeholder: 'Select a status'
    });
    $('#Type').select2({
        placeholder: 'Select a type'
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
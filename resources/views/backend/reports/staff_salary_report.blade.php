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
        <h4 class="mt-1 mb-1">Staff Salary Report</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Staff Salary Report</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
        <div class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-primary h-40px fs-7 waves-effect waves-light p-0" style="width: 150px;">
            <div class="form-floating form-floating-outline">
                <input type="text" class="p-2 rounded border-0 bg-primary text-white w-100" id="monthpicker" name="month" placeholder="Select Month" readonly onchange="getData()">
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
                            <th>Month</th>
                            <th>Staff Id</th>
                            <th>Staff Name</th>
                            <th>Total Shifts</th>
                            <th>Gross Salary</th>
                            <th>Advance Salary</th>
                            <th>Net Payable</th>
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

<script>
    $(document).ready(function() {
        // Get the current date
        var currentDate = new Date();
        // Format the date to yyyy-mm
        var formattedDate =  ('0' + (currentDate.getMonth() + 1)).slice(-2) + ' ' + currentDate.getFullYear();

        // Initialize the datepicker
        $('#monthpicker').datepicker({
            format: "M yyyy",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        }).datepicker('setDate', formattedDate);

        var table =$('#kt_datatable5').DataTable({
            dom: `<'row'<'col-sm-12'lBtr>>
			<'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
            pageLength: 10,
            scrollX: true,
            buttons: [{
                extend: 'excel',
                title: 'Staff Salary Report',
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

        getData();
    });
  
    function getData(){
        var month = $('#monthpicker').val();
        $.ajax({
            url:"{{route('get_staff_salary_report_data')}}",
            method:"GET",
            data:{'month':month,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                console.log(result);

                var table = $('#kt_datatable5').DataTable();
                table.clear().draw();

                $.each(result, function(index, item) {
                    var grandTotal = parseInt(item.total, 10) - parseInt(item.deduct, 10);
                    var day = item.days == 1 ? item.days + " Shift" : item.days + " Shifts";
                    table.row.add([
                        index + 1,
                        item.month,
                        item.staff.staff_id,
                        item.staff.staff_name,
                        day,
                        '₹' + parseInt(item.total, 10).toLocaleString(),
                        '₹' + parseInt(item.deduct, 10).toLocaleString(),
                        '₹' + parseInt(item.total - item.deduct, 10).toLocaleString()
                    ]).draw(false);
                });
            }
        }); 
    }
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
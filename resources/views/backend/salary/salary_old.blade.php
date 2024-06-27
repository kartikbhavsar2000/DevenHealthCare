@extends('backend.components.header')

@section('css')

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
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0">Generate Salary</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_advance_salary')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label" for="typeSelector">Select Type:</label>
                            <div class="d-flex py-3">
                                <div class="form-check me-10">
                                    <input name="type" class="form-check-input" type="radio" value="Staff" id="StaffRadio" onclick="getStaffOptions('Staff')">
                                    <label class="form-check-label" for="StaffRadio">Staff</label>
                                </div>
                                <div class="form-check">
                                    <input name="type" class="form-check-input" type="radio" value="Doctor" id="DoctorRadio" onclick="getStaffOptions('Doctor')">
                                    <label class="form-check-label" for="DoctorRadio">Doctor</label>
                                </div>
                            </div>
                            <div id="typeError" class="text-danger"></div>
                        </div>
                        <div class="col-9">
                            <div class="mb-4">
                                <label class="form-label">Select Staff <span class="text-danger">*</span></label>
                                <select class="form-control" name="staff_id" id="StaffId" disabled>
                                    <option value=""></option>
                                </select>
                                <div id="staffError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label" for="monthpicker">Select Month:</label>
                                <input type="text" class="form-control" id="monthpicker" name="month" placeholder="Select Month" readonly>
                                <div id="monthError" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label" for="weekselector">Select Weeks:</label>
                                <select class="form-control" id="weekselector" name="weeks[]" multiple="multiple"></select>
                                <div id="weeksError" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="col-2 mb-3 mt-8">
                            <div class="mb-4">
                                <button class="btn btn-label-secondary w-100" type="button" onclick="getStaffSalaryDetails()">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-10">
                        <div class="table-responsive border rounded-4 border-bottom-0 mx-3">
                            <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                              <thead>
                                <tr>
                                  <th>Sr No.</th>
                                  <th>Booking ID</th>
                                  <th>Date</th>
                                  <th>Shift</th>
                                  <th>Amount</th>
                                  <th>Attendance Status</th>
                                </tr>
                              </thead>
                              <tbody id="table-body">
                           
                              </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 text-end mt-5 pe-5">
                        <b>Total Salary : </b> <span id="grand-total">₹00</span>
                    </div>
                </div>
                <hr>
                <div class="card-footer text-end">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    $("#Form").submit(function(e){
        var validate = validateFields();
        if(!validate){
            e.preventDefault();
        }
    });
    $('.kt_datatable').DataTable({
        dom:'',
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all",
        }],
    });
    function getStaffOptions(type){
        $.ajax({
            url:"{{route('get_staff_doctor_list')}}",
            method:"POST",
            data:{'type':type,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(result)
            {
                $('#StaffId').attr('disabled',false);

                // Clear existing options
                $('#StaffId').empty();

                // Add a default empty option
                $('#StaffId').append('<option value=""></option>');

                // Append new options
                result.forEach(function(item) {
                    $('#StaffId').append('<option value="' + item.id + '">' + item.staff_name + ' | ' + item.unique_id + '</option>');
                });
            }
        }); 
    }
    function formatDate(dateString) {
        var date = new Date(dateString);
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        var year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
    function getStaffSalaryDetails(){
        var validate = validateFields();
        if(validate){
            var type = $('input[name="type"]:checked').val();
            var month = $('#monthpicker').val();
            var weeks = $('#weekselector').val();
            var staff_id = $('#StaffId').val();

            $.ajax({
                url:"{{route('get_staff_doctor_salary_details')}}",
                method:"POST",
                data:{'type':type,'month':month,'weeks':weeks,'staff_id':staff_id,_token:"{{ csrf_token() }}"},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(result)
                {
                    console.log(result);

                    $('#table-body').empty();

                    var grandTotal = 0;

                    // Populate the table with the data received
                    $.each(result, function(index, item) {
                        var status = '-';
                        if(item.att_marked == 0){
                            status = '<span class="badge bg-label-secondary">Not Marked</span>';
                        }else{
                            if(item.status == 0){
                                status = '<span class="badge bg-label-warning">Pending</span>';
                            }else if(item.status == 1){
                                status = '<span class="badge bg-label-success">Approved</span>';
                            }else{
                                status = '<span class="badge bg-label-danger">Rejected</span>';
                            }
                        }
                        $('#table-body').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + item.booking_unique_id + '</td>' +
                            '<td>' + formatDate(item.date) + '</td>' +
                            '<td>' + item.shift_name + '</td>' +
                            '<td>' + '₹' +  parseInt(item.cost_rate, 10).toLocaleString() + '</td>' +
                            '<td>' + status + '</td>' +
                            '</tr>'
                        );
                        grandTotal += parseInt(item.cost_rate, 10);
                    });

                    $('#grand-total').text('₹' + grandTotal.toLocaleString());
                }
            }); 
        }
    }
    function validateFields(){
        var validate = true;

        var type = $('input[name="type"]:checked').val();
        var month = $('#monthpicker').val();
        var weeks = $('#weekselector').val();
        var staff_id = $('#StaffId').val();

        if(!type){
            $('#typeError').text('Please select a type.');
            validate = false;
        } else {
            $('#typeError').text('');
        }

        if(!month){
            $('#monthError').text('Please select a month.');
            validate = false;
        } else {
            $('#monthError').text('');
        }

        if(!weeks || weeks.length === 0){
            $('#weeksError').text('Please select at least one week.');
            validate = false;
        } else {
            $('#weeksError').text('');
        }

        if(!staff_id){
            $('#staffError').text('Please select a staff member.');
            validate = false;
        } else {
            $('#staffError').text('');
        }

        return validate;
    }
    $(document).ready(function() {
        var selectedWeeks = [];

        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero
            var day = date.getDate().toString().padStart(2, '0'); // Add leading zero
            return year + '-' + month + '-' + day;
        }
       
        function getWeeksInMonth(year, month) {
            var weeks = [];
            var firstDate = new Date(year, month, 1);
            var lastDate = new Date(year, month + 1, 0);
            var currentWeekStart = firstDate;

            while (currentWeekStart <= lastDate) {
                var currentWeekEnd = new Date(currentWeekStart);
                currentWeekEnd.setDate(currentWeekStart.getDate() + 6);
                if (currentWeekEnd > lastDate) {
                    currentWeekEnd = lastDate;
                }
                weeks.push({
                    startDate: new Date(currentWeekStart),
                    endDate: new Date(currentWeekEnd)
                });
                currentWeekStart.setDate(currentWeekEnd.getDate() + 1);
            }
            return weeks;
        }
        
        function populateWeekSelector(weeks) {
            var weekSelector = $('#weekselector');
            weekSelector.empty();
            weeks.forEach(function(week, index) {
                var formattedStartDate = formatDate(week.startDate);
                var formattedEndDate = formatDate(week.endDate);
                
                var option = new Option(
                    "Week " + (index + 1) + " (" + formattedStartDate + " to " + formattedEndDate + ")",
                    JSON.stringify({ startDate: formattedStartDate, endDate: formattedEndDate })
                );
                weekSelector.append(option);
            });
        }

        $('#monthpicker').datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        }).on("changeDate", function(e) {
            var selectedDate = e.date;
            var year = selectedDate.getFullYear();
            var month = selectedDate.getMonth();
            var weeks = getWeeksInMonth(year, month);
            populateWeekSelector(weeks);
            $('#weekselector').val(null).trigger('change');
        });

        $('#weekselector').select2({
            placeholder: "Select Weeks",
            allowClear: true
        }).on("change", function() {
            var selectedOptions = $(this).val();
            selectedWeeks = selectedOptions ? selectedOptions.map(function(option) {
                return JSON.parse(option);
            }) : [];
        });
    });
</script>

<script>
    $('#StaffId').select2({
        placeholder: 'Select Staff'
    });
</script>
@endsection
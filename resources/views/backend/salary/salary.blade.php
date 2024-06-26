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
                        <div class="col-2 mb-3">
                            <label class="form-label" for="monthpicker">Select Type:</label>
                            <div class="d-flex py-3">
                                <div class="form-check me-3">
                                    <input name="type" class="form-check-input" type="radio" value="Staff" id="StaffRadio" onclick="getStaffOptions('Staff')">
                                    <label class="form-check-label" for="StaffRadio">
                                      Staff
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="type" class="form-check-input" type="radio" value="Doctor" id="DoctorRadio" onclick="getStaffOptions('Doctor')">
                                    <label class="form-check-label" for="DoctorRadio">
                                      Doctor
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="monthpicker">Select Month:</label>
                                <input type="text" class="form-control" id="monthpicker" name="month" placeholder="Select Month" readonly>
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="weekselector">Select Weeks:</label>
                                <select class="form-control" id="weekselector" name="weeks[]" multiple="multiple"></select>
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Select Staff <span class="text-danger">*</span></label>
                                <select class="form-control" name="staff_id" id="StaffId">
                                    <option value=""></option>
                                </select>
                                @error('staff_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 mb-3 mt-8">
                            <div class="mb-4">
                                <button class="btn btn-label-secondary" type="button" onclick="getStaffSalaryDetails()">Get Details</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('advance_salary')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
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
                console.log(result);

                // Clear existing options
                $('#StaffId').empty();

                // Add a default empty option
                $('#StaffId').append('<option value=""></option>');

                // Append new options
                result.forEach(function(item) {
                    let optionText = item.name || item.f_name;
                    $('#StaffId').append('<option value="' + item.id + '">' + optionText + '</option>');
                });
            }
        }); 
    }
    function getStaffSalaryDetails(){
        console.log("Data");
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
                console.log(week);
                var formattedStartDate = formatDate(week.startDate);
                var formattedEndDate = formatDate(week.endDate);
                
                var option = new Option(
                    "Week " + (index + 1) + " (" + formattedStartDate + " to " + formattedEndDate + ")",
                    JSON.stringify({ startDate: formattedStartDate, endDate: formattedEndDate })
                );
                console.log(option);
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
            console.log(selectedOptions);
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
@extends('backend.components.header')

@section('css')
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/css/pages/app-logistics-dashboard.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="{{asset('public')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
@endsection

@section('content')
<div class="row g-6">
    <div class="col-sm-6 col-lg-3">
      <a href="{{route('staff')}}"><div class="card card-border-shadow-primary h-100">
          <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                  <div class="avatar me-4">
                      <span class="avatar-initial rounded-3 bg-label-primary"><i
                              class="ri-nurse-line ri-24px"></i></span>
                  </div>
                  <h4 class="mb-0">{{$data['staff_count'] ?? "00"}}</h4>
              </div>
              <h6 class="mb-0 fw-normal">Staff</h6>
          </div>
      </div></a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="{{route('doctors')}}"><div class="card card-border-shadow-warning h-100">
          <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                  <div class="avatar me-4">
                      <span class="avatar-initial rounded-3 bg-label-warning"><i
                              class="ri-stethoscope-line ri-24px"></i></span>
                  </div>
                  <h4 class="mb-0">{{$data['doctor_count'] ?? "00"}}</h4>
              </div>
              <h6 class="mb-0 fw-normal">Doctors</h6>
          </div>
      </div></a>
    </div>
    <div div class="col-sm-6 col-lg-3">
        <a href="{{route('patients')}}"><div class="card card-border-shadow-danger h-100">
          <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                  <div class="avatar me-4">
                      <span class="avatar-initial rounded-3 bg-label-danger"><i
                              class="ri-wheelchair-line ri-24px"></i></span>
                  </div>
                  <h4 class="mb-0">{{$data['patient_count'] ?? "00"}}</h4>
              </div>
              <h6 class="mb-0 fw-normal">Patients</h6>
          </div>
      </div></a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="{{route('bookings')}}"><div class="card card-border-shadow-success h-100">
          <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                  <div class="avatar me-4">
                      <span class="avatar-initial rounded-3 bg-label-success"><i class="ri-calendar-schedule-line ri-24px"></i></span>
                  </div>
                  <h4 class="mb-0">{{$data['booking_count'] ?? "00"}}</h4>
              </div>
              <h6 class="mb-0 fw-normal">Bookings</h6>
          </div>
      </div></a>
    </div>
  <!--/ Card Border Shadow -->

    <div class="col-12 col-lg-4 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">DHC</h5>
                {{-- <div class="dropdown">
                    <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-20px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID" style="">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                    </div>
                </div> --}}
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">HSP</h5>
                <div class="dropdown">
                    <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-20px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID" style="">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">CRP</h5>
                <div class="dropdown">
                    <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="transactionID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-2-line ri-20px"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID" style="">
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center pb-2">
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-1">Credit Card</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="mb-0">85</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

  <!-- Vehicles overview -->
  <div class="col-lg-6 col-xxl-6 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="card-title mb-0">Staff Allocation For Bookings</h5>
          </div>
          <div class="dropdown d-none d-sm-flex">
            <div class="form-floating form-floating-outline">
                <input type="text" id="StaffAllocationDaterange" class="form-control" />
                <label for="StaffAllocationDaterange">Date</label>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="donutChart"></div>
        </div>
      </div>
  </div>
  <div class="col-lg-6 col-xxl-6 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Available & Unavailable Staff</h5>
            </div>
            <div class="dropdown d-none d-sm-flex">
                
            </div>
        </div>
        <div class="card-body">
            <div id="hbarChart"></div>
        </div>
    </div>
  </div>
  <!--/ Vehicles overview -->
  <!-- Shipment statistics-->
  <div class="col-lg-12 col-xxl-12 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Profit VS Loss</h5>
            </div>
            <div class="dropdown d-sm-flex">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="ProfitVsLossDaterange" class="form-control" />
                    <label for="ProfitVsLossDaterange">Month</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="profitChart"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-12 col-xxl-12 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Income VS Expense</h5>
            </div>
            <div class="dropdown d-sm-flex">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="IncomeVsExpenseDaterange" class="form-control" />
                    <label for="IncomeVsExpenseDaterange">Month</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="incomeChart"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-12 col-xxl-12 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Patients Vs Corporations Booking</h5>
            </div>
            <div class="dropdown d-none d-sm-flex">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="PatientVsCorporationDaterange" class="form-control" />
                    <label for="PatientVsCorporationDaterange">Date</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="areaChart"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-12 col-xxl-12 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Area Wise Bookings</h5>
            </div>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                <i class="ri-filter-line me-1"></i>Filter
            </button>
        </div>
        <div class="card-body">
            <div class="collapse my-3" id="collapseExample2">
                <div class="container">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State</label>
                                <select class="form-control mb-1" name="state" id="State2" onchange="selectState2()">
                                    <option value=""></option>
                                    @if(!empty($data['states']))
                                        @foreach($data['states'] as $key => $state)
                                            <option value="{{$state->id}}" @if($state->id == 5 || $key == 0) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('state')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City</label>
                                <select class="form-control mb-1" name="city" id="City2" onchange="fetchBookingData($('#AreaWiseBookingDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD'), $('#AreaWiseBookingDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD'))">
                                    <option value=""></option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label"  for="AreaWiseBookingDaterange">Date</label>
                                <div class="dropdown d-none d-sm-flex">
                                    {{-- <label for="AreaWiseBookingDaterange">Date</label> --}}
                                    <input type="text" id="AreaWiseBookingDaterange" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="barChart"></div>
        </div>
    </div>
  </div>

  <div class="col-lg-12 col-xxl-12 order-3 order-xxl-1">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h5 class="card-title mb-0">Area Wise Patients & Staff</h5>
            </div>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="ri-filter-line me-1"></i>Filter
            </button>
        </div>
        <div class="card-body">
            <div class="collapse my-3" id="collapseExample">
                <div class="container">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State</label>
                                <select class="form-control mb-1" name="state" id="State" onchange="selectState()">
                                    <option value=""></option>
                                    @if(!empty($data['states']))
                                        @foreach($data['states'] as $key => $state)
                                            <option value="{{$state->id}}" @if($state->id == 5 || $key == 0) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('state')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City</label>
                                <select class="form-control mb-1" name="city" id="City" onchange="fetchPSData()">
                                    <option value=""></option>
                                </select>
                                @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="barChart2"></div>
        </div>
    </div>
  </div>
  
</div>
@endsection

@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{asset('public')}}/assets/js/app-logistics-dashboard.js"></script>
<script src="{{asset('public')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script>
     $(document).ready(function() {
        selectState();
        selectState2();
        fetchPSData();
        fetchBookingData($('#AreaWiseBookingDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD'), $('#AreaWiseBookingDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD'));
     });
    function selectState() {
        var id = $('#State').val();
        $.ajax({
            url:"{{route('get_cities_by_state')}}",
            method:"POST",
            data:{'id':id,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(result)
            {
                var cities = result.data;
                var citySelect = $('#City');
                var cityyy = '125';
                
                citySelect.empty().append('<option value=""></option>');
                cities.forEach(function(city,index) {
                    if(cityyy == city.id || index == 0){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    citySelect.append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                });
                fetchPSData();
            }
        }); 
    }
    function selectState2() {
        var id = $('#State2').val();
        $.ajax({
            url:"{{route('get_cities_by_state')}}",
            method:"POST",
            data:{'id':id,_token:"{{ csrf_token() }}"},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(result)
            {
                var cities = result.data;
                var citySelect = $('#City2');
                var cityyy = '125';
                
                citySelect.empty().append('<option value=""></option>');
                cities.forEach(function(city,index) {
                    if(cityyy == city.id || index == 0){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    citySelect.append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                });
                fetchBookingData($('#AreaWiseBookingDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD'), $('#AreaWiseBookingDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD'));
            }
        }); 
    }
</script>
<script>
     document.addEventListener("DOMContentLoaded", function () {
            $('#ProfitVsLossDaterange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                },
                startDate: moment().startOf('month').format('DD/MM/YYYY'),
                endDate: moment().endOf('month').format('DD/MM/YYYY')
            }, function(start, end, label) {
                fetchChartData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            });

            var options = {
                series: [],
                chart: {
                    type: 'bar',
                    height: 365,
                    foreColor: '#333'  // Darker color for text elements
                },
                plotOptions: {
                    bar: {
                        colors: {
                            ranges: []
                        }
                    }
                },
                xaxis: {
                    categories: [],
                    labels: {
                        style: {
                            colors: '#333',  // Darker color for x-axis labels
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Amount',
                        style: {
                            color: '#333'  // Darker color for y-axis title
                        }
                    },
                    labels: {
                        style: {
                            colors: '#333',  // Darker color for y-axis labels
                            fontSize: '12px'
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        colors: ['#333']  // Darker color for data labels
                    }
                },
                annotations: {
                    yaxis: [{
                        y: 0,
                        borderColor: '#000',  // Darker color for zero line
                        label: {
                            borderColor: '#000',
                            style: {
                                color: '#fff',
                                background: '#000'
                            }
                        }
                    }]
                }
            };

            var chart = new ApexCharts(document.querySelector("#profitChart"), options);
            chart.render();

            function fetchChartData(start_date, end_date) {
                $.ajax({
                    url: '{{ route("get_profit_loss_chart_data") }}',
                    method: 'GET',
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function (data) {
                        var series = [{
                            name: 'Amount',
                            data: data.series[0].data
                        }];

                        var colors = data.series[0].data.map(value => value < 0 ? '#db1919' : '#0dbb0d'); // Dark red and dark green

                        chart.updateOptions({
                            series: series,
                            xaxis: {
                                categories: data.categories
                            },
                            plotOptions: {
                                bar: {
                                    colors: {
                                        ranges: data.series[0].data.map((value, index) => ({
                                            from: value,
                                            to: value,
                                            color: value < 0 ? '#db1919' : '#0dbb0d'
                                        }))
                                    }
                                }
                            }
                        });
                    },
                    error: function (error) {
                        console.error('Error fetching chart data:', error);
                    }
                });
            }

            fetchChartData(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
        });


    document.addEventListener("DOMContentLoaded", function () {
        $('#IncomeVsExpenseDaterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('month').format('DD/MM/YYYY'),
            endDate: moment().endOf('month').format('DD/MM/YYYY')
        }, function(start, end, label) {
            fetchChartData2(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });

        var options = {
            series: [],
            chart: {
                type: 'line',
                height: 365
            },
            colors:['#0be49a','#ED3237'],
            stroke: {
                width: [5, 5],
                curve: 'smooth'
            },
            xaxis: {
                categories: []
            },
            yaxis: {
                title: {
                    text: 'Amount'
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
            },
            dataLabels: {
                enabled: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#incomeChart"), options);
        chart.render();

        function fetchChartData2(start_date, end_date) {
            $.ajax({
                url: '{{ route("get_income_expense_chart_data") }}',
                method: 'GET',
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success: function (data) {
                    var series = [
                        {
                            name: 'Income',
                            data: data.series[0].data.map((value, index) => ({
                                x: data.categories[index],
                                y: value
                            }))
                        },
                        {
                            name: 'Expense',
                            data: data.series[1].data.map((value, index) => ({
                                x: data.categories[index],
                                y: value
                            }))
                        }
                    ];

                    chart.updateOptions({
                        series: series,
                        xaxis: {
                            categories: data.categories
                        }
                    });
                },
                error: function (error) {
                    console.error('Error fetching chart data:', error);
                }
            });
        }

        fetchChartData2(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
    });




    document.addEventListener("DOMContentLoaded", function () {
        $('#StaffAllocationDaterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('month').format('DD/MM/YYYY'),
            endDate: moment().endOf('month').format('DD/MM/YYYY')
        }, function(start, end, label) {
            $.ajax({
                url: '{{route("get_staff_booking_chart_data")}}',
                method: 'GET',
                data: {
                    start_date: start.format('YYYY-MM-DD'),
                    end_date: end.format('YYYY-MM-DD')
                },
                success: function (data) {
                    chart.updateOptions({
                        series: data.series,
                        labels: data.labels
                    });
                },
                error: function (error) {
                    console.error('Error fetching chart data:', error);
                }
            });
        });

        var options = {
            series: [],
            chart: {
                type: 'donut',
                height: 365
            },
            labels: [],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#donutChart"), options);
        chart.render();

        $.ajax({
            url: '{{route("get_staff_booking_chart_data")}}',
            method: 'GET',
            data: {
                start_date: moment().startOf('month').format('YYYY-MM-DD'),
                end_date: moment().endOf('month').format('YYYY-MM-DD')
            },
            success: function (data) {
                chart.updateOptions({
                    series: data.series,
                    labels: data.labels
                });
            },
            error: function (error) {
                console.error('Error fetching chart data:', error);
            }
        });
    });




    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            series: [],
            chart: {
                type: 'bar',
                height: 370
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: []
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#hbarChart"), options);
        chart.render();

        function updateChart() {
            var url = '{{route("available_and_occupied_staff")}}';
            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    chart.updateOptions({
                        series: data.series,
                        xaxis: {
                            categories: data.categories
                        }
                    });
                },
                error: function (error) {
                    console.error('Error fetching chart data:', error);
                }
            });
        }

        updateChart();
    });

    document.addEventListener("DOMContentLoaded", function () {
        $('#PatientVsCorporationDaterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('week').format('DD/MM/YYYY'),
            endDate: moment().endOf('week').format('DD/MM/YYYY')
        }, function(start, end, label) {
            $.ajax({
                url: '{{route("patient_vs_corporation_chart")}}',
                method: 'GET',
                data: {
                    start_date: start.format('YYYY-MM-DD'),
                    end_date: end.format('YYYY-MM-DD')
                },
                success: function (data) {
                    chart.updateOptions({
                        series: data.series,
                        xaxis: {
                            categories: data.categories
                        }
                    });
                },
                error: function (error) {
                    console.error('Error fetching chart data:', error);
                }
            });
        });

        var options = {
            series: [],
            chart: {
                type: 'area',
                height: 350
            },
            colors: ['#1DA1F2','#ff9800'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: []
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#areaChart"), options);
        chart.render();

        $.ajax({
            url: '{{route("patient_vs_corporation_chart")}}',
            method: 'GET',
            data: {
                start_date: moment().startOf('week').format('YYYY-MM-DD'),
                end_date: moment().endOf('week').format('YYYY-MM-DD')
            },
            success: function (data) {
                chart.updateOptions({
                    series: data.series,
                    xaxis: {
                        categories: data.categories
                    }
                });
            },
            error: function (error) {
                console.error('Error fetching chart data:', error);
            }
        });
        
    });

    $('#AreaWiseBookingDaterange').daterangepicker({
        opens: 'left',
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: moment().startOf('week').format('DD/MM/YYYY'),
        endDate: moment().endOf('week').format('DD/MM/YYYY')
    }, function(start, end, label) {
        fetchBookingData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    });

    function fetchBookingData(startDate, endDate) {
        var options = {
            series: [],
            chart: {
                type: 'bar',
                height: 335
            },
            colors: ['#1E90FF','#F02627','#ff9800'], // Add colors for both series
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: []
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#barChart"), options);
        chart.render();

        var state = $('#State2').val();
        var city = $('#City2').val();
        $.ajax({
            url: '{{ route("area_wise_booking_chart") }}',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate,
                state: state,
                city: city
            },
            success: function (data) {
                chart.updateOptions({
                    series: data.series,
                    xaxis: {
                        categories: data.categories
                    }
                });
            },
            error: function (error) {
                console.error('Error fetching chart data:', error);
            }
        });
    }

    fetchBookingData($('#AreaWiseBookingDaterange').data('daterangepicker').startDate.format('YYYY-MM-DD'), $('#AreaWiseBookingDaterange').data('daterangepicker').endDate.format('YYYY-MM-DD'));

    function fetchPSData() {
        var options = {
            series: [],
            chart: {
                type: 'bar',
                height: 335
            },
            colors: ['#FF9800', '#66DA26'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: []
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#barChart2"), options);
        chart.render();
        
        var state = $('#State').val();
        var city = $('#City').val();

        $.ajax({
            url: '{{ route("area_wise_patient_and_staff_chart") }}',
            method: 'GET',
            data: {
                start_date: moment().startOf('week').format('YYYY-MM-DD'),
                end_date: moment().endOf('week').format('YYYY-MM-DD'),
                state: state,
                city: city
            },
            success: function (data) {
                chart.updateOptions({
                    series: data.series,
                    xaxis: {
                        categories: data.categories
                    }
                });
            },
            error: function (error) {
                console.error('Error fetching chart data:', error);
            }
        });
    }
    $('#State').select2({
        placeholder: 'Select a state'
    });
    $('#City').select2({
        placeholder: 'Select a city'
    });
    $('#State2').select2({
        placeholder: 'Select a state'
    });
    $('#City2').select2({
        placeholder: 'Select a city'
    });
</script>
    
@endsection
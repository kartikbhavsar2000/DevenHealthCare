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

  <!-- Vehicles overview -->
  <div class="col-xxl-6 order-5 order-xxl-0">
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
            <div class="dropdown d-none d-sm-flex">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="AreaWiseBookingDaterange" class="form-control" />
                    <label for="AreaWiseBookingDaterange">Date</label>
                </div>
            </div>
        </div>
        <div class="card-body">
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
            {{-- <div class="dropdown d-none d-sm-flex">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="AreaWiseStaffAndPatientDaterange" class="form-control" />
                    <label for="AreaWiseStaffAndPatientDaterange">Date</label>
                </div>
            </div> --}}
        </div>
        <div class="card-body">
            <div id="barChart2"></div>
        </div>
    </div>
  </div>
  
  <!--/ Shipment statistics -->
  <!-- Delivery Performance -->
  <div class="col-lg-6 col-xxl-4 order-2 order-xxl-2">
      <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
              <div>
                  <h5 class="card-title mb-1">Delivery Performance</h5>
                  <p class="card-subtitle mb-0">12% increase in this month</p>
              </div>
              <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                      id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-more-2-line ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
                      <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                      <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                      <a class="dropdown-item" href="javascript:void(0);">Share</a>
                  </div>
              </div>
          </div>
          <div class="card-body">
              <ul class="p-0 m-0">
                  <li class="d-flex mb-6 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-primary"><i
                                  class="ri-gift-line ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Packages in transit</h6>
                              <small class="text-success fw-normal d-block">
                                  <i class="ri-arrow-up-s-line ri-24px"></i>
                                  25.8%
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">10k</h6>
                          </div>
                      </div>
                  </li>
                  <li class="d-flex mb-6 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-info"><i
                                  class="ri-car-line ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Packages out for delivery</h6>
                              <small class="text-success fw-normal d-block">
                                  <i class="ri-arrow-up-s-line ri-24px"></i>
                                  4.3%
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">5k</h6>
                          </div>
                      </div>
                  </li>
                  <li class="d-flex mb-6 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-success"><i
                                  class="ri-check-line text-success ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Packages delivered</h6>
                              <small class="text-danger fw-normal d-block">
                                  <i class="ri-arrow-down-s-line ri-24px"></i>
                                  12.5
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">15k</h6>
                          </div>
                      </div>
                  </li>
                  <li class="d-flex mb-6 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-warning"><i
                                  class="ri-home-line ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Delivery success rate</h6>
                              <small class="text-success fw-normal d-block">
                                  <i class="ri-arrow-up-s-line ri-24px"></i>
                                  35.6%
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">95%</h6>
                          </div>
                      </div>
                  </li>
                  <li class="d-flex mb-6 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-secondary"><i
                                  class="ri-timer-line ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Average delivery time</h6>
                              <small class="text-danger fw-normal d-block">
                                  <i class="ri-arrow-down-s-line ri-24px"></i>
                                  2.15
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">2.5 Days</h6>
                          </div>
                      </div>
                  </li>
                  <li class="d-flex">
                      <div class="avatar flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-3 bg-label-danger"><i
                                  class="ri-user-line ri-24px"></i></span>
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                          <div class="me-2">
                              <h6 class="mb-0 fw-normal">Customer satisfaction</h6>
                              <small class="text-success fw-normal d-block">
                                  <i class="ri-arrow-up-s-line ri-24px"></i>
                                  5.7%
                              </small>
                          </div>
                          <div class="user-progress">
                              <h6 class="mb-0">4.5/5</h6>
                          </div>
                      </div>
                  </li>
              </ul>
          </div>
      </div>
  </div>
  <!--/ Delivery Performance -->
  <!-- Reasons for delivery exceptions -->
  <div class="col-md-6 col-xxl-4 order-1 order-xxl-3">
      <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
              </div>
              <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                      id="deliveryExceptionsReasons" data-bs-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false">
                      <i class="ri-more-2-line ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptionsReasons">
                      <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                      <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                      <a class="dropdown-item" href="javascript:void(0);">Share</a>
                  </div>
              </div>
          </div>
          <div class="card-body">
              <div id="deliveryExceptionsChart"></div>
          </div>
      </div>
  </div>
  <!--/ Reasons for delivery exceptions -->
  <!-- Orders by Countries -->
  <div class="col-md-6 col-xxl-4 order-0 order-xxl-4">
      <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
              <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Orders by Countries</h5>
                  <span class="text-body mb-0">62 deliveries in progress</span>
              </div>
              <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                      id="ordersCountries" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-more-2-line ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersCountries">
                      <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                      <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                      <a class="dropdown-item" href="javascript:void(0);">Share</a>
                  </div>
              </div>
          </div>
          <div class="card-body p-0">
              <div class="nav-align-top">
                  <ul class="nav nav-tabs nav-fill" role="tablist">
                      <li class="nav-item">
                          <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                              data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                              aria-selected="true">
                              New
                          </button>
                      </li>
                      <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-preparing"
                              aria-controls="navs-justified-link-preparing" aria-selected="false">
                              Preparing
                          </button>
                      </li>
                      <li class="nav-item">
                          <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                              data-bs-target="#navs-justified-link-shipping"
                              aria-controls="navs-justified-link-shipping" aria-selected="false">
                              Shipping
                          </button>
                      </li>
                  </ul>
                  <div class="tab-content border-0 pb-0 px-6 mx-1">
                      <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Myrtle Ullrich</h6>
                                      <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Barry Schowalter</h6>
                                      <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                  </div>
                              </li>
                          </ul>
                          <div class="border-1 border-light border-top border-dashed mb-2"></div>
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Veronica Herman</h6>
                                      <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Helen Jacobs</h6>
                                      <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Barry Schowalter</h6>
                                      <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent border-left-dashed">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Myrtle Ullrich</h6>
                                      <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                  </div>
                              </li>
                          </ul>
                          <div class="border-1 border-light border-top border-dashed mb-2"></div>
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Veronica Herman</h6>
                                      <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Helen Jacobs</h6>
                                      <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Veronica Herman</h6>
                                      <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Barry Schowalter</h6>
                                      <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                                  </div>
                              </li>
                          </ul>
                          <div class="border-1 border-light border-top border-dashed mb-2"></div>
                          <ul class="timeline mb-0">
                              <li class="timeline-item ps-6 border-left-dashed">
                                  <span class="timeline-indicator-advanced text-success border-0 shadow-none">
                                      <i class="ri-checkbox-circle-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-success text-uppercase">sender</small>
                                      </div>
                                      <h6 class="my-50">Myrtle Ullrich</h6>
                                      <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                                  </div>
                              </li>
                              <li class="timeline-item ps-6 border-transparent">
                                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                                      <i class="ri-map-pin-line ri-20px"></i>
                                  </span>
                                  <div class="timeline-event ps-1">
                                      <div class="timeline-header">
                                          <small class="text-primary text-uppercase">Receiver</small>
                                      </div>
                                      <h6 class="my-50">Helen Jacobs</h6>
                                      <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!--/ Orders by Countries -->
  <!-- On route vehicles Table -->
  <div class="col-12 order-5">
      <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                  <h5 class="m-0 me-2">On route vehicles</h5>
              </div>
              <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                      id="routeVehicles" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-more-2-line ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="routeVehicles">
                      <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                      <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                      <a class="dropdown-item" href="javascript:void(0);">Share</a>
                  </div>
              </div>
          </div>
          <div class="card-datatable table-responsive">
              <table class="dt-route-vehicles table">
                  <thead>
                      <tr>
                          <th></th>
                          <th></th>
                          <th>location</th>
                          <th>starting route</th>
                          <th>ending route</th>
                          <th>warnings</th>
                          <th class="w-20">progress</th>
                      </tr>
                  </thead>
              </table>
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

    // document.addEventListener("DOMContentLoaded", function () {
    //     $('#AvailableAndOccupiedStaffDaterange').daterangepicker({
    //         opens: 'left',
    //         locale: {
    //             format: 'DD/MM/YYYY'
    //         },
    //         startDate: moment().startOf('week').format('DD/MM/YYYY'),
    //         endDate: moment().endOf('week').format('DD/MM/YYYY')
    //     }, function(start, end, label) {
    //         $.ajax({
    //             url: '{{route("available_and_occupied_staff")}}',
    //             method: 'GET',
    //             data: {
    //                 start_date: start.format('YYYY-MM-DD'),
    //                 end_date: end.format('YYYY-MM-DD')
    //             },
    //             success: function (data) {
    //                 console.log('Received data:', data); // Log received data
    //                 chart.updateOptions({
    //                     series: data.series,
    //                     xaxis: {
    //                         categories: data.categories
    //                     }
    //                 });
    //             },
    //             error: function (error) {
    //                 console.error('Error fetching chart data:', error);
    //             }
    //         });
    //     });

    //     var options = {
    //         series: [],
    //         chart: {
    //             type: 'bar',
    //             height: 375
    //         },
    //         plotOptions: {
    //             bar: {
    //                 horizontal: true,
    //                 columnWidth: '55%',
    //                 endingShape: 'rounded'
    //             },
    //         },
    //         dataLabels: {
    //             enabled: true
    //         },
    //         stroke: {
    //             show: true,
    //             width: 2,
    //             colors: ['transparent']
    //         },
    //         xaxis: {
    //             categories: []
    //         },
    //         fill: {
    //             opacity: 1
    //         },
    //         tooltip: {
    //             y: {
    //                 formatter: function (val) {
    //                     return val + " staff"
    //                 }
    //             }
    //         }
    //     };

    //     var chart = new ApexCharts(document.querySelector("#hbarChart"), options);
    //     chart.render();

    //     $.ajax({
    //         url: '{{route("available_and_occupied_staff")}}',
    //         method: 'GET',
    //         data: {
    //             start_date: moment().startOf('week').format('YYYY-MM-DD'),
    //             end_date: moment().endOf('week').format('YYYY-MM-DD')
    //         },
    //         success: function (data) {
    //             console.log('Received data:', data); // Log received data
    //             chart.updateOptions({
    //                 series: data.series,
    //                 xaxis: {
    //                     categories: data.categories
    //                 }
    //             });
    //         },
    //         error: function (error) {
    //             console.error('Error fetching chart data:', error);
    //         }
    //     });
        
    // });

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
                    console.log('Received data:', data); // Log received data
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
                console.log('Received data:', data); // Log received data
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

    document.addEventListener("DOMContentLoaded", function () {
        $('#AreaWiseBookingDaterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('week').format('DD/MM/YYYY'),
            endDate: moment().endOf('week').format('DD/MM/YYYY')
        }, function(start, end, label) {
            $.ajax({
                url: '{{ route("area_wise_booking_chart") }}',
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
                type: 'bar',
                height: 335
            },
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

        var chart = new ApexCharts(document.querySelector("#barChart"), options);
        chart.render();

        $.ajax({
            url: '{{ route("area_wise_booking_chart") }}',
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

    document.addEventListener("DOMContentLoaded", function () {
        $('#AreaWiseStaffAndPatientDaterange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            startDate: moment().startOf('week').format('DD/MM/YYYY'),
            endDate: moment().endOf('week').format('DD/MM/YYYY')
        }, function(start, end, label) {
            $.ajax({
                url: '{{ route("area_wise_booking_chart") }}',
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
                type: 'bar',
                height: 335
            },
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

        $.ajax({
            url: '{{ route("area_wise_patient_and_staff_chart") }}',
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
</script>
    
@endsection
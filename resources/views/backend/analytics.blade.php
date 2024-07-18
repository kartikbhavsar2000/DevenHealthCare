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
  
</div>
@endsection

@section('javascript')
<script src="{{asset('public')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{asset('public')}}/assets/js/app-logistics-dashboard.js"></script>
<script src="{{asset('public')}}/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
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
                        console.log(data);

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
            fetchChartData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
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

        function fetchChartData(start_date, end_date) {
            $.ajax({
                url: '{{ route("get_income_expense_chart_data") }}',
                method: 'GET',
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                success: function (data) {
                    console.log(data);
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

        fetchChartData(moment().startOf('month').format('YYYY-MM-DD'), moment().endOf('month').format('YYYY-MM-DD'));
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

    // document.addEventListener("DOMContentLoaded", function () {
    //     $('#AreaWiseBookingDaterange').daterangepicker({
    //         opens: 'left',
    //         locale: {
    //             format: 'DD/MM/YYYY'
    //         },
    //         startDate: moment().startOf('week').format('DD/MM/YYYY'),
    //         endDate: moment().endOf('week').format('DD/MM/YYYY')
    //     }, function(start, end, label) {
    //         $.ajax({
    //             url: '{{ route("area_wise_booking_chart") }}',
    //             method: 'GET',
    //             data: {
    //                 start_date: start.format('YYYY-MM-DD'),
    //                 end_date: end.format('YYYY-MM-DD')
    //             },
    //             success: function (data) {
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
    //             height: 335
    //         },
    //         colors: ['#F02627'],
    //         plotOptions: {
    //             bar: {
    //                 horizontal: false,
    //                 columnWidth: '55%',
    //                 endingShape: 'rounded'
    //             }
    //         },
    //         dataLabels: {
    //             enabled: false
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
    //                     return val
    //                 }
    //             }
    //         }
    //     };

    //     var chart = new ApexCharts(document.querySelector("#barChart"), options);
    //     chart.render();

    //     $.ajax({
    //         url: '{{ route("area_wise_booking_chart") }}',
    //         method: 'GET',
    //         data: {
    //             start_date: moment().startOf('week').format('YYYY-MM-DD'),
    //             end_date: moment().endOf('week').format('YYYY-MM-DD')
    //         },
    //         success: function (data) {
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
        fetchBookingData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    });

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

    function fetchBookingData(startDate, endDate) {
        $.ajax({
            url: '{{ route("area_wise_booking_chart") }}',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
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

    // Initial fetch for the current week
    fetchBookingData(moment().startOf('week').format('YYYY-MM-DD'), moment().endOf('week').format('YYYY-MM-DD'));
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
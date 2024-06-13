<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shifts;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\Doctor;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Corporate;
use App\Models\Hospital;
use App\Models\BookingAssign;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoice()
    {
        return view('backend.pdf.invoice');
    }
    public function index()
    {   
        $staff_type = StaffType::orderBy('id',"ASC")->get();
        $bookings = Booking::with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
        foreach($bookings as $booking){
            $customer_details = $booking->customerDetails();
            $customer_details->state = State::find($customer_details->state);
            $customer_details->city = City::find($customer_details->city);
            $customer_details->area = Area::find($customer_details->area);
            $booking->customer_details = $customer_details;

            foreach($booking->bookingDetails as $details){
                $shift = Shifts::find($details->shift);
                if($shift){
                    $details->shift_name = $shift->name;
                }
            }

            $staff_data = [];
            $doctor_data = [];
            foreach($booking->bookingAssigns as $book){
                $book->shiftt = Shifts::find($book->shift);
                if($book->type == "Doctor"){
                    $book->staff_details = Doctor::with('state')->with('city')->with('area')->find($book->staff_id);
                    $doctor_data[] = $book;
                }else{
                    $book->staff_details = Staff::with('types')->with('state')->with('city')->with('area')->find($book->staff_id);
                    $staff_data[] = $book;
                }
            }
            $booking->staff_data = $staff_data;
            $booking->doctor_data = $doctor_data;
        }

        $dates = [];
        $currentDate = new \DateTime();
        $dates[] = $currentDate->format('Y-m-d');

        for ($i = 1; $i <= 6; $i++) {
            $nextDate = clone $currentDate;
            $nextDate->add(new \DateInterval('P' . $i . 'D'));
            $dates[] = $nextDate->format('Y-m-d');
        }
        $shifts = Shifts::orderBy('id',"DESC")->get();
        $staffs = Staff::orderBy('id',"DESC")->get();
        $doctors = Doctor::orderBy('id',"DESC")->get();
        return view('backend.dashboard',['shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $bookings,'dates' => $dates]);
    }
    public function analytics()
    {
        $staff_count = Staff::count();
        $doctor_count = Doctor::count();
        $patient_count = Patient::count();
        $corporate_count = Corporate::count();
        $booking_count = Booking::count();
        $hospital_count = Hospital::count();

        $data = [
            'staff_count' => $staff_count,
            'doctor_count' => $doctor_count,
            'patient_count' => $patient_count,
            'corporate_count' => $corporate_count,
            'booking_count' => $booking_count,
            'hospital_count' => $hospital_count,
        ];
        return view('backend.analytics',['data'=>$data]);
    }
    public function get_cities_by_state(Request $request)
    {
        $data = City::where('state_id',$request->id)->orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function get_areas_by_city(Request $request)
    {
        $data = Area::where('city_id',$request->id)->orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function get_staff_booking_chart_data(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $staffType = StaffType::all();

        $series = [];
        $labels = [];

        foreach($staffType as $type){
            $assign_data = BookingAssign::where('staff_id', '!=', null)
                ->where('type', $type->title)
                ->when($startDate === $endDate, function ($query) use ($startDate) {
                    return $query->whereDate('date', $startDate);
                }, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('date', [$startDate, $endDate]);
                })
                ->count();
            $series[] = $assign_data;
            $labels[] = $type->title;
        }

        $assign_data = BookingAssign::where('staff_id', '!=', null)
            ->where('type', 'Doctor')
            ->when($startDate === $endDate, function ($query) use ($startDate) {
                return $query->whereDate('date', $startDate);
            }, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->count();
        $series[] = $assign_data;
        $labels[] = 'Doctor';

        $data = [
            'series' => $series,
            'labels' => $labels
        ];

        return response()->json($data);
    }
    public function available_and_occupied_staff()
    {
        $date = now()->format('Y-m-d');
        $staffTypes = StaffType::all();

        $availableSeries = [];
        $unavailableSeries = [];
        $totalSeries = [];
        $categories = [];

        foreach ($staffTypes as $type) {
            $totalStaff = Staff::where('type',$type->id)->count();
            $unavailableCount = BookingAssign::where('staff_id','!=',null)->where(['type'=> $type->title])->whereDate('date', $date)->count();
            $availableCount = $totalStaff - $unavailableCount;

            $availableSeries[] = $availableCount;
            $unavailableSeries[] = $unavailableCount;
            $totalSeries[] = $totalStaff;
            $categories[] = $type->title;
        }

        $data = [
            'series' => [
                [
                    'name' => 'Available',
                    'data' => $availableSeries
                ],
                [
                    'name' => 'Unavailable',
                    'data' => $unavailableSeries
                ],
                [
                    'name' => 'Total',
                    'data' => $totalSeries
                ]
            ],
            'categories' => $categories
        ];

        return response()->json($data);
    }
    public function area_wise_booking_chart(Request $request)
    {

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $bookings = Booking::when($startDate === $endDate, function ($query) use ($startDate) {
            return $query->whereDate('start_date', $startDate)
                         ->orWhereDate('end_date', $startDate)
                         ->orWhereBetween('start_date', [$startDate, $startDate])
                         ->orWhereBetween('end_date', [$startDate, $startDate]);
        }, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('start_date', [$startDate, $endDate])
                         ->orWhereBetween('end_date', [$startDate, $endDate])
                         ->orWhere(function ($q) use ($startDate, $endDate) {
                             $q->whereDate('start_date', '<=', $startDate)
                               ->whereDate('end_date', '>=', $endDate);
                         });
        })->get();
        $area_counts = [];

        foreach ($bookings as $booking) {
            $area = $booking->customerDetails()->area;
            $area_name = Area::find($area)->name;
            
            if (!isset($area_counts[$area_name])) {
                $area_counts[$area_name] = 0;
            }
            $area_counts[$area_name]++;
        }

        $areas = array_keys($area_counts);
        $counts = array_values($area_counts);

        $data = [
            'series' => [
                [
                    'name' => 'Bookings',
                    'data' => $counts
                ]
            ],
            'categories' => $areas
        ];

        return response()->json($data);
    }
    public function patient_vs_corporation_chart(Request $request)
    {
        $all_dates = [];
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $current_date = strtotime($startDate);
        $end_timestamp = strtotime($endDate);

        $patientSeries = [];
        $corporationSeries = [];
        $categories = [];

        while ($current_date <= $end_timestamp) {
            $all_dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }
        foreach($all_dates as $date){
            $patientSeries[] = Booking::where('booking_type', 'Patient')
                ->where(function($query) use ($date) {
                    $query->whereDate('start_date', '<=', $date)
                            ->whereDate('end_date', '>=', $date);
                })
                ->count();
            $corporationSeries[] = Booking::where('booking_type', 'Corporate')
            ->where(function($query) use ($date) {
                $query->whereDate('start_date', '<=', $date)
                        ->whereDate('end_date', '>=', $date);
            })
            ->count();

            $datee = date('d M', strtotime($date));
            $categories[] = $datee;
        }
        $data = [
            'series' => [
                [
                    'name' => 'Patient',
                    'data' => $patientSeries
                ],
                [
                    'name' => 'Corporation',
                    'data' => $corporationSeries
                ]
            ],
            'categories' => $categories
        ];

        return response()->json($data);
    }

}

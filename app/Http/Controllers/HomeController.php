<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shifts;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\Doctor;
use App\Models\State;
use App\Models\Equipment;
use App\Models\City;
use App\Models\Area;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\Corporate;
use App\Models\Hospital;
use App\Models\BookingAssign;
use App\Models\Ambulance;
use Session;

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
    // public function index()
    // {   
    //     if (in_array("dashboard", Auth::user()->permissions())) {
    //         $staff_type = StaffType::orderBy('id',"ASC")->get();
    //         if(Session::has('customerType')){
    //             if(Session::get('customerType') == "CRP"){
    //                 $bookings = Booking::where(['booking_type'=>'Corporate','booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
    //             }elseif(Session::get('customerType') == "All"){
    //                 $bookings = Booking::where(['booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
    //             }else{
    //                 $bookings = Booking::where(['booking_type'=>'Patient','booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
    //             }
    //         }else{
    //             $bookings = Booking::where(['booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
    //         }
    //         $all_bookings = [];
    //         foreach($bookings as $booking){
    //             $customer_details = $booking->customerDetails();
    //             if(Session::has('customerType')){
    //                 if(Session::get('customerType') == "DHC"){
    //                     if($customer_details->h_type == "DHC"){
    //                         $all_bookings[] = $booking;
    //                     }
    //                 }elseif(Session::get('customerType') == "HSP"){
    //                     if($customer_details->h_type != "DHC"){
    //                         $all_bookings[] = $booking;
    //                     }
    //                 }else{
    //                     $all_bookings[] = $booking;
    //                 }
    //             }else{
    //                 $all_bookings[] = $booking;
    //             }
    //             $customer_details->state = State::find($customer_details->state);
    //             $customer_details->city = City::find($customer_details->city);
    //             $customer_details->area = Area::find($customer_details->area);
    //             $booking->customer_details = $customer_details;

    //             foreach($booking->bookingDetails as $details){
    //                 $shift = Shifts::find($details->shift);
    //                 if($shift){
    //                     $details->shift_name = $shift->name;
    //                 }
    //             }

    //             $staff_data = [];
    //             $doctor_data = [];
    //             foreach($booking->bookingAssigns as $book){
    //                 $book->shiftt = Shifts::find($book->shift);
    //                 if($book->type == "Doctor"){
    //                     $book->staff_details = Doctor::with('state')->with('city')->with('area')->find($book->staff_id);
    //                     $doctor_data[] = $book;
    //                 }else{
    //                     $book->staff_details = Staff::with('types')->with('state')->with('city')->with('area')->find($book->staff_id);
    //                     $staff_data[] = $book;
    //                 }
    //             }
    //             $booking->staff_data = $staff_data;
    //             $booking->doctor_data = $doctor_data;
    //         }

    //         $dates = [];
    //         $currentDate = new \DateTime();
    //         $dates[] = $currentDate->format('Y-m-d');

    //         for ($i = 1; $i <= 6; $i++) {
    //             $nextDate = clone $currentDate;
    //             $nextDate->add(new \DateInterval('P' . $i . 'D'));
    //             $dates[] = $nextDate->format('Y-m-d');
    //         }
    //         $shifts = Shifts::orderBy('id',"DESC")->get();
    //         $staffs = Staff::orderBy('id',"DESC")->get();
    //         $doctors = Doctor::orderBy('id',"DESC")->get();
    //         $equipments = Equipment::orderBy('id',"DESC")->get();
    //         $ambulance = Ambulance::first();
    //         return view('backend.dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
    //     }
    //     abort(403);
    // }
    public function index()
    {   

        // if (in_array("dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where(['booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
            $all_bookings = [];
            foreach($bookings as $booking){
                $customer_details = $booking->customerDetails();
                $all_bookings[] = $booking;
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
            $equipments = Equipment::orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        // }
        // abort(403);
    }
    public function dhc_dashboard()
    {   
        if (in_array("dhc_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where(['booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
            $all_bookings = [];
            foreach($bookings as $booking){
                $customer_details = $booking->customerDetails();
                if($customer_details->h_type == "DHC"){
                    $all_bookings[] = $booking;
                }
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
            $equipments = Equipment::orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.dhc_dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        }
        abort(403);
    }
    public function hsp_dashboard()
    {   
        if (in_array("hsp_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where(['booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
            $all_bookings = [];
            foreach($bookings as $booking){
                $customer_details = $booking->customerDetails();
                if(Session::get('customerType') == "HSP"){
                    if($customer_details->h_type != "DHC"){
                        $all_bookings[] = $booking;
                    }
                }
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
            $equipments = Equipment::orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.hsp_dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        }
        abort(403);
    }
    public function crp_dashboard()
    {   
        if (in_array("crp_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where(['booking_type'=>'Corporate','booking_status'=>0])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
            $all_bookings = [];
            foreach($bookings as $booking){
                $customer_details = $booking->customerDetails();
                $all_bookings[] = $booking;
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
            $equipments = Equipment::orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.crp_dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        }
        abort(403);
    }
    // public function change_customer_type(Request $request){
    //     Session::put('customerType', $request->type);
    //     return "Stored";
    // }
    public function analytics()
    {
        if (in_array("analytics", Auth::user()->permissions())) {
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
        abort(403);
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
                ->where(['booking_status'=>0,'type'=> $type->title])
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
            ->where(['booking_status'=>0,'type'=> 'Doctor'])
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
            $unavailableCount = BookingAssign::whereNotNull('staff_id')->where(['booking_status'=>0,'type'=> $type->title])->whereDate('date', $date)->distinct('staff_id')->count('staff_id');
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

        $bookings = Booking::where('booking_status',0)->when($startDate === $endDate, function ($query) use ($startDate) {
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
    public function area_wise_patient_and_staff_chart(Request $request)
    {
        $staff_counts = [];
        $patient_counts = [];
        $areas = [];

        // Retrieve all areas where status is 1
        $areas = Area::where('status', 1)->get();

        // Filter areas and calculate staff and patient counts
        $filtered_areas = $areas->filter(function ($area) use (&$staff_counts, &$patient_counts) {
            $staff_count = Staff::where('area', $area->id)->count();
            $patient_count = Patient::where('area', $area->id)->count();

            // Include the area only if there are staff or patients
            if ($staff_count > 0 || $patient_count > 0) {
                $staff_counts[] = $staff_count;
                $patient_counts[] = $patient_count;
                return true;
            }

            return false;
        });

        // Prepare data for the chart
        $data = [
            'series' => [
                [
                    'name' => 'Staff',
                    'data' => $staff_counts
                ],
                [
                    'name' => 'Patient',
                    'data' => $patient_counts
                ]
            ],
            'categories' => $filtered_areas->pluck('name') // Assuming 'name' is the field for area names
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
            $patientSeries[] = Booking::where(['booking_status'=>0,'booking_type'=>'Patient'])
                ->where(function($query) use ($date) {
                    $query->whereDate('start_date', '<=', $date)
                            ->whereDate('end_date', '>=', $date);
                })
                ->count();
            $corporationSeries[] = Booking::where(['booking_status'=>0,'booking_type'=>'Corporate'])
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

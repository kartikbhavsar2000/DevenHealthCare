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
use App\Models\BookingDetails;
use App\Models\Patient;
use App\Models\Corporate;
use App\Models\Hospital;
use App\Models\BookingAssign;
use App\Models\Ambulance;
use Session;
use Log;
use Carbon\Carbon;

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
    public function index()
    {   

        // if (in_array("dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::whereIn('booking_status',[0,2])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
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
            
            // $dates = [];
            // $currentDate = new \DateTime();
            // $dates[] = $currentDate->format('Y-m-d');

            // for ($i = 1; $i <= 6; $i++) {
            //     $nextDate = clone $currentDate;
            //     $nextDate->add(new \DateInterval('P' . $i . 'D'));
            //     $dates[] = $nextDate->format('Y-m-d');
            // }
            $dates = [];
            $currentDate = new \DateTime();
            $pastDate = clone $currentDate;
            $pastDate->sub(new \DateInterval('P6D')); // 7 days before today
            $dates[] = $pastDate->format('Y-m-d');

            for ($i = 1; $i <= 12; $i++) { // 13 days total to include 7 days before and 6 days ahead
                $nextDate = clone $pastDate;
                $nextDate->add(new \DateInterval('P' . $i . 'D'));
                $dates[] = $nextDate->format('Y-m-d');
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staffs = Staff::where('status',1)->orderBy('id',"DESC")->get();
            $doctors = Doctor::where('status',1)->orderBy('id',"DESC")->get();
            $equipments = Equipment::where('status',1)->orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        // }
        // abort(403);
    }
    public function dhc_dashboard()
    {   
        if (in_array("dhc_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::whereIn('booking_status',[0,2])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
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

            // $dates = [];
            // $currentDate = new \DateTime();
            // $dates[] = $currentDate->format('Y-m-d');

            // for ($i = 1; $i <= 6; $i++) {
            //     $nextDate = clone $currentDate;
            //     $nextDate->add(new \DateInterval('P' . $i . 'D'));
            //     $dates[] = $nextDate->format('Y-m-d');
            // }
            $dates = [];
            $currentDate = new \DateTime();
            $pastDate = clone $currentDate;
            $pastDate->sub(new \DateInterval('P6D')); // 7 days before today
            $dates[] = $pastDate->format('Y-m-d');

            for ($i = 1; $i <= 12; $i++) { // 13 days total to include 7 days before and 6 days ahead
                $nextDate = clone $pastDate;
                $nextDate->add(new \DateInterval('P' . $i . 'D'));
                $dates[] = $nextDate->format('Y-m-d');
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staffs = Staff::where('status',1)->orderBy('id',"DESC")->get();
            $doctors = Doctor::where('status',1)->orderBy('id',"DESC")->get();
            $equipments = Equipment::where('status',1)->orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.dhc_dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        }
        abort(403);
    }
    public function hsp_dashboard()
    {   
        if (in_array("hsp_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where('booking_type','!=','Corporate')->whereIn('booking_status',[0,2])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
            $all_bookings = [];
            foreach($bookings as $booking){
                $customer_details = $booking->customerDetails();
                if($customer_details->h_type != "DHC"){
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

            // $dates = [];
            // $currentDate = new \DateTime();
            // $dates[] = $currentDate->format('Y-m-d');

            // for ($i = 1; $i <= 6; $i++) {
            //     $nextDate = clone $currentDate;
            //     $nextDate->add(new \DateInterval('P' . $i . 'D'));
            //     $dates[] = $nextDate->format('Y-m-d');
            // }
            $dates = [];
            $currentDate = new \DateTime();
            $pastDate = clone $currentDate;
            $pastDate->sub(new \DateInterval('P6D')); // 7 days before today
            $dates[] = $pastDate->format('Y-m-d');

            for ($i = 1; $i <= 12; $i++) { // 13 days total to include 7 days before and 6 days ahead
                $nextDate = clone $pastDate;
                $nextDate->add(new \DateInterval('P' . $i . 'D'));
                $dates[] = $nextDate->format('Y-m-d');
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staffs = Staff::where('status',1)->orderBy('id',"DESC")->get();
            $doctors = Doctor::where('status',1)->orderBy('id',"DESC")->get();
            $equipments = Equipment::where('status',1)->orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            return view('backend.hsp_dashboard',['ambulance' => $ambulance,'equipments' => $equipments, 'shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $all_bookings,'dates' => $dates]);
        }
        abort(403);
    }
    public function crp_dashboard()
    {   
        if (in_array("crp_dashboard", Auth::user()->permissions())) {
            $staff_type = StaffType::orderBy('id',"ASC")->get();
            $bookings = Booking::where(['booking_type'=>'Corporate'])->whereIn('booking_status',[0,2])->with('bookingAssigns')->with('bookingDetails')->orderBy('id',"DESC")->get();
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

            // $dates = [];
            // $currentDate = new \DateTime();
            // $dates[] = $currentDate->format('Y-m-d');

            // for ($i = 1; $i <= 6; $i++) {
            //     $nextDate = clone $currentDate;
            //     $nextDate->add(new \DateInterval('P' . $i . 'D'));
            //     $dates[] = $nextDate->format('Y-m-d');
            // }
            $dates = [];
            $currentDate = new \DateTime();
            $pastDate = clone $currentDate;
            $pastDate->sub(new \DateInterval('P6D')); // 7 days before today
            $dates[] = $pastDate->format('Y-m-d');

            for ($i = 1; $i <= 12; $i++) { // 13 days total to include 7 days before and 6 days ahead
                $nextDate = clone $pastDate;
                $nextDate->add(new \DateInterval('P' . $i . 'D'));
                $dates[] = $nextDate->format('Y-m-d');
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staffs = Staff::where('status',1)->orderBy('id',"DESC")->get();
            $doctors = Doctor::where('status',1)->orderBy('id',"DESC")->get();
            $equipments = Equipment::where('status',1)->orderBy('id',"DESC")->get();
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
            $staff_count = Staff::where('status',1)->count();
            $doctor_count = Doctor::where('status',1)->count();
            $patient_count = Patient::count();
            $corporate_count = Corporate::count();
            $booking_count = Booking::count();
            $hospital_count = Hospital::count();
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $data = [
                'staff_count' => $staff_count,
                'doctor_count' => $doctor_count,
                'patient_count' => $patient_count,
                'corporate_count' => $corporate_count,
                'booking_count' => $booking_count,
                'hospital_count' => $hospital_count,
                'states' => $states,
            ];
            return view('backend.analytics',['data'=>$data]);
        }
        abort(403);
    }
    public function mark_attandance(Request $request)
    {
        $data = BookingAssign::find($request->id);
        if($data){
            $dateTime = now()->setTimezone('Asia/Kolkata');

            $data->att_marked = 1;
            $data->status = 1;
            $data->att_date_time = $dateTime->format('Y-m-d H:i:s');
            $data->updated_by = Auth::user()->id;
            $data->update();
        }
        return "Marked";
    }
    public function get_cities_by_state(Request $request)
    {
        $data = City::where('state_id',$request->id)->where('status',1)->orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function get_areas_by_city(Request $request)
    {
        $data = Area::where('city_id',$request->id)->where('status',1)->orderBy('name',"asc")->get();
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
            $assign_data = BookingAssign::where('is_cancled',0)->where('staff_id', '!=', null)
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

        $assign_data = BookingAssign::where('is_cancled',0)->where('staff_id', '!=', null)
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
            $totalStaff = Staff::where('status',1)->where('type',$type->id)->count();
            $unavailableCount = BookingAssign::where('is_cancled',0)->whereNotNull('staff_id')->where(['booking_status'=>0,'type'=> $type->title])->whereDate('date', $date)->distinct('staff_id')->count('staff_id');
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

        $active_bookings = Booking::where('booking_status', 0)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->whereDate('start_date', '<=', $startDate)
                            ->whereDate('end_date', '>=', $endDate);
                    });
            })->get();

        $close_bookings = Booking::where('booking_status', 1)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->whereDate('start_date', '<=', $startDate)
                            ->whereDate('end_date', '>=', $endDate);
                    });
            })->get();

        $paused_bookings = Booking::where('booking_status', 2)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->whereDate('start_date', '<=', $startDate)
                        ->whereDate('end_date', '>=', $endDate);
                });
        })->get();

        $area_counts_active = [];
        $area_counts_close = [];
        $area_counts_pause = [];

        foreach ($active_bookings as $Abooking) {
            $area = $Abooking->customerDetails()->area;
            if($request->city){
                $areaaaaa = Area::where('city_id', $request->city)->where('status', 1)->where('id',$area)->first();
            }else{
                $areaaaaa = Area::where('status', 1)->where('id',$area)->first();
            }
            $area_name = $areaaaaa->name;

            if (!isset($area_counts_active[$area_name])) {
                $area_counts_active[$area_name] = 0;
            }
            $area_counts_active[$area_name]++;
        }

        foreach ($close_bookings as $Cbooking) {
            $area = $Cbooking->customerDetails()->area;
            if($request->city){
                $areaaaaa = Area::where('city_id', $request->city)->where('status', 1)->where('id',$area)->first();
            }else{
                $areaaaaa = Area::where('status', 1)->where('id',$area)->first();
            }
            $area_name = $areaaaaa->name;

            if (!isset($area_counts_close[$area_name])) {
                $area_counts_close[$area_name] = 0;
            }
            $area_counts_close[$area_name]++;
        }

        foreach ($paused_bookings as $Pbooking) {
            $area = $Pbooking->customerDetails()->area;
            if($request->city){
                $areaaaaa = Area::where('city_id', $request->city)->where('status', 1)->where('id',$area)->first();
            }else{
                $areaaaaa = Area::where('status', 1)->where('id',$area)->first();
            }
            $area_name = $areaaaaa->name;

            if (!isset($area_counts_pause[$area_name])) {
                $area_counts_pause[$area_name] = 0;
            }
            $area_counts_pause[$area_name]++;
        }

        $all_areas = array_unique(array_merge(array_keys($area_counts_active), array_keys($area_counts_close), array_keys($area_counts_pause)));
        $active_counts = [];
        $close_counts = [];
        $pause_counts = [];

        foreach ($all_areas as $area) {
            $active_counts[] = $area_counts_active[$area] ?? 0;
            $close_counts[] = $area_counts_close[$area] ?? 0;
            $pause_counts[] = $area_counts_pause[$area] ?? 0;
        }

        $data = [
            'series' => [
                [
                    'name' => 'Active Bookings',
                    'data' => $active_counts
                ],
                [
                    'name' => 'Close Bookings',
                    'data' => $close_counts
                ],
                [
                    'name' => 'Pause Bookings',
                    'data' => $pause_counts
                ]
            ],
            'categories' => $all_areas
        ];

        return response()->json($data);
    }

    

    public function area_wise_patient_and_staff_chart(Request $request)
    {
        $staff_counts = [];
        $patient_counts = [];
        $areas = [];

        // Retrieve all areas where status is 1
        if($request->state && $request->city){
            $areas = Area::where('city_id', $request->city)->where('status', 1)->get();
        }else{
            $areas = Area::where('status', 1)->get();
        }

        // Filter areas and calculate staff and patient counts
        $filtered_areas = $areas->filter(function ($area) use (&$staff_counts, &$patient_counts) {
            $staff_count = Staff::where('status',1)->where('area', $area->id)->count();
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
    public function get_income_expense_chart_data(Request $request)
    {
        $all_dates = [];
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $current_date = strtotime($startDate);
        $end_timestamp = strtotime($endDate);

        $profitSeries = [];
        $lossSeries = [];
        $categories = [];

        while ($current_date <= $end_timestamp) {
            $all_dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }

        foreach ($all_dates as $date) {
            $doctorSell = BookingAssign::where('is_cancled',0)->where(['date' => $date, 'type' => 'Doctor'])->sum('sell_rate');
            $doctorCost = BookingAssign::where('is_cancled',0)->where(['date' => $date, 'type' => 'Doctor'])->sum('cost_rate');

            $staffSell = BookingAssign::where('is_cancled',0)->where('type', '!=', 'Doctor')->where(['att_marked' => 1, 'status' => 1, 'date' => $date])->sum('sell_rate');
            $staffCost = BookingAssign::where('is_cancled',0)->where('type', '!=', 'Doctor')->where(['att_marked' => 1, 'status' => 1, 'date' => $date])->sum('cost_rate');

            $equipments = BookingDetails::where(['type' => 2, 'date' => $date])->get();
            $equipmentSell = 0;
            $equipmentCost = 0;
            foreach ($equipments as $equipment) {
                $equipmenttt = Equipment::where('name',$equipment->name)->first();
                if($equipmenttt){
                    if($equipmenttt->type == "Sale"){
                        $equipmentSell += $equipment->sell_rate;
                        $equipmentCost += $equipmenttt->cost_price * $equipment->qnt;
                    }else{
                        $equipmentSell += $equipment->sell_rate;
                        $equipmentCost += 0;
                    }
                }
            }

            $ambSell = BookingDetails::where(['type' => 4, 'date' => $date])->sum('sell_rate');
            
            $profitSeries[] = $doctorSell + $staffSell + $equipmentSell + $ambSell;
            $lossSeries[] = $doctorCost +  $staffCost + $equipmentCost;
            $categories[] = date('d M', strtotime($date));
        }
        $data = [
            'series' => [
                [
                    'name' => 'Income',
                    'data' => $profitSeries
                ],
                [
                    'name' => 'Expense',
                    'data' => $lossSeries
                ]
            ],
            'categories' => $categories
        ];

        return response()->json($data);
    }
    public function get_profit_loss_chart_data(Request $request)
    {
        $all_dates = [];
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $current_date = strtotime($startDate);
        $end_timestamp = strtotime($endDate);

        $docProfit = [];
        $stProfit = [];
        $eqiProfit = [];
        $ambProfit = [];

        while ($current_date <= $end_timestamp) {
            $all_dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }

        foreach ($all_dates as $date) {
            $doctorSell = BookingAssign::where('is_cancled',0)->where(['date' => $date, 'type' => 'Doctor'])->sum('sell_rate');
            $doctorCost = BookingAssign::where('is_cancled',0)->where(['date' => $date, 'type' => 'Doctor'])->sum('cost_rate');
            $docProfit[] = $doctorSell - $doctorCost;

            $staffSell = BookingAssign::where('is_cancled',0)->where('type', '!=', 'Doctor')->where(['att_marked' => 1, 'status' => 1, 'date' => $date])->sum('sell_rate');
            $staffCost = BookingAssign::where('is_cancled',0)->where('type', '!=', 'Doctor')->where(['att_marked' => 1, 'status' => 1, 'date' => $date])->sum('cost_rate');
            $stProfit[] = $staffSell - $staffCost;

            $equipments = BookingDetails::where(['type' => 2, 'date' => $date])->get();
            $equipmentSell = 0;
            $equipmentCost = 0;
            foreach ($equipments as $equipment) {
                $equipmenttt = Equipment::where('name',$equipment->name)->first();
                if($equipmenttt){
                    if($equipmenttt->type == "Sale"){
                        $equipmentSell += $equipment->sell_rate;
                        $equipmentCost += $equipmenttt->cost_price * $equipment->qnt;
                    }else{
                        $equipmentSell += $equipment->sell_rate;
                    }
                }
            }
            $eqiProfit[] = $equipmentSell - $equipmentCost;

            $ambProfit[] = BookingDetails::where(['type' => 4, 'date' => $date])->sum('sell_rate');
        }
        $dataaaa = [ array_sum($stProfit), array_sum($docProfit),array_sum($eqiProfit), array_sum($ambProfit)];

        $data = [
            'series' => [
                [
                    'name' => 'Amount',
                    'data' => $dataaaa
                ]
            ],
            'categories' => ['Staff', 'Doctor', 'Equipment', 'Ambulance']
        ];

        return response()->json($data);
    }
}

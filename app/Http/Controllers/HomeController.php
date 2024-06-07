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
        $staff_type = StaffType::orderBy('id',"ASC")->get();
        $bookings = Booking::with('bookingAssigns')->orderBy('id',"DESC")->get();
        foreach($bookings as $booking){
            $customer_details = $booking->customerDetails();
            $customer_details->state = State::find($customer_details->state);
            $customer_details->city = City::find($customer_details->city);
            $customer_details->area = Area::find($customer_details->area);
            $booking->customer_details = $customer_details;

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

        // return $bookings;

        // Initialize the date array
        $dates = [];

        // Create a DateTime instance for today
        $currentDate = new \DateTime();

        // Add today's date to the array
        $dates[] = $currentDate->format('Y-m-d');

        // Loop through the next 6 days to get the dates
        for ($i = 1; $i <= 6; $i++) {
            // Clone the current date to avoid modifying the original
            $nextDate = clone $currentDate;
            // Add the interval of $i days
            $nextDate->add(new \DateInterval('P' . $i . 'D'));
            // Add the formatted date to the array
            $dates[] = $nextDate->format('Y-m-d');
        }
        $shifts = Shifts::orderBy('id',"DESC")->get();
        $staffs = Staff::orderBy('id',"DESC")->get();
        $doctors = Doctor::orderBy('id',"DESC")->get();
        return view('backend.dashboard',['shifts' => $shifts,'staffs' => $staffs,'doctors' => $doctors,'staff_type' => $staff_type,'bookings' => $bookings,'dates' => $dates]);
    }
    public function analytics()
    {
        return view('backend.analytics');
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
}

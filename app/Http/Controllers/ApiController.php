<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Shifts;
use App\Models\BookingAssign;
use App\Models\Booking;
use App\Models\City;
use App\Models\State;
use App\Models\Area;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Validation failed.',
                'data' => $validator->errors()
            ]);
        }
    
        $staff = Staff::where('staff_id', $request->staff_id)->first();
        
        if (!$staff) {
            return response()->json([
                'status' => 0,
                'msg' => 'Invalid staff ID.'
            ]);
        }
    
        if (!Hash::check($request->password, $staff->password)) {
            return response()->json([
                'status' => 0,
                'msg' => 'Incorrect password.'
            ]);
        }
    
        return response()->json([
            'status' => 1,
            'msg' => 'Login successful.',
            'data' => $staff
        ]);
    }
    public function get_booking_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Validation failed.',
                'data' => $validator->errors()
            ]);
        }

        $staff = Staff::find($request->staff_id);

        if(!$staff){
            return response()->json([
                'status' => 0,
                'msg' => 'Invalid staff ID.'
            ]);
        }

        $booking_assign = BookingAssign::where(['staff_id' => $staff->id,'booking_status'=>0])->get();

        foreach($booking_assign as $book){
            $shift = Shifts::find($book->shift);
            $book->shift_name = $shift->name;
            $booking = Booking::find($book->booking_id);
            $booking->customer_details = $booking->customerDetails();
            $city = City::find($booking->customer_details->city);
            $state = State::find($booking->customer_details->state);
            $area = Area::find($booking->customer_details->area);
            $booking->customer_details->city_name = $city->name ?? "";
            $booking->customer_details->state_name = $state->name ?? "";
            $booking->customer_details->area_name = $area->name ?? "";
            $book->booking_details = $booking;
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Data Found.',
            'data' => $booking_assign
        ]);
    }
    public function mark_attendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'proof' => 'required|image|max:5120',
            'lat' => 'required',
            'lng' => 'required',
            'date_time' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Validation failed.',
                'data' => $validator->errors()
            ]);
        }

        $booking_assign = BookingAssign::find($request->id);

        if(!$booking_assign){
            return response()->json([
                'status' => 0,
                'msg' => 'Invalid ID.'
            ]);
        }

        $imageName = time().'.'.$request->proof->extension();  
        $request->proof->move(public_path('staff_attendance'), $imageName);

        $booking_assign->att_proof = $imageName;
        $booking_assign->lat = $request->lat;
        $booking_assign->lng = $request->lng;
        $booking_assign->att_date_time = date('Y-m-d H:i:s', strtotime($request->date_time));
        $booking_assign->att_marked = 1;
        $booking_assign->update();

        return response()->json([
            'status' => 1,
            'msg' => 'Attendance Marked',
            'data' => $booking_assign
        ]);
    }
}

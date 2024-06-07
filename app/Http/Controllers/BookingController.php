<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shifts;
use App\Models\Equipment;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\Hospital;
use App\Models\Corporate;
use App\Models\Doctor;
use App\Models\Ambulance;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Booking;
use App\Models\BookingDetails;
use App\Models\BookingAssign;

class BookingController extends Controller
{
    public function bookings()
    {
        if (in_array("bookings", Auth::user()->permissions())) {
            return view('backend.bookings.booking_list');
        }
        abort(403);
    }
    public function get_bookings_list()
    {   
        $data = Booking::orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
        }
        return response()->json(['data'=>$data]);
    }
    public function add_booking()
    {
        if (in_array("bookings", Auth::user()->permissions())) {
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staff_type = StaffType::orderBy('id',"DESC")->get();
            $patients = Patient::with('state')->with('city')->with('area')->orderBy('id',"DESC")->get();
            $equipments = Equipment::orderBy('id',"DESC")->get();
            $ambulance = Ambulance::first();
            $hospitals = Hospital::orderBy('id',"DESC")->get();
            $corporates = Corporate::orderBy('id',"DESC")->get();
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $data = [
                'shifts' => $shifts,
                'staff_type' => $staff_type,
                'patients' => $patients,
                'equipments' => $equipments,
                'hospitals' => $hospitals,
                'corporates' => $corporates,
                'states' => $states,
            ];
            return view('backend.bookings.add_booking',['data'=>$data]);
        }
        abort(403);
    }
    public function view_booking_details($id)
    {
        if (in_array("bookings", Auth::user()->permissions())) {
            $booking = Booking::with('bookingDetails')->find($id);
            $booking->customer_details = $booking->customerDetails();
            $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
            $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
            $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

            $staff_data = [];
            $equipment_data = [];
            $doctor_data = [];
            $ambulance_data = [];
            foreach($booking->bookingDetails as $bookings){
                if($bookings->type == 1){
                    $staff_data[] = $bookings;
                }
                if($bookings->type == 2){
                    $equipment_data[] = $bookings;
                }
                if($bookings->type == 3){
                    $doctor_data[] = $bookings;
                }
                if($bookings->type == 4){
                    $ambulance_data[] = $bookings;
                }
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staff = Staff::orderBy('id',"DESC")->get();
            $doctors = Doctor::orderBy('id',"DESC")->get();
            return view('backend.bookings.view_booking',['shifts'=>$shifts,'staff_data'=>$staff_data,'equipment_data'=>$equipment_data,'doctor_data'=>$doctor_data,'ambulance_data'=>$ambulance_data,'booking'=>$booking,'staff'=>$staff,'doctors'=>$doctors]);
        }
        abort(403);
    }
    public function create_booking(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'booking_type' => 'required',
            'customer_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ],[
            'booking_type.required' => 'The booking type field is required.',
            'customer_id.required' => 'This field is required.',
            'start_date.required' => 'The start date field is required.',
            'end_date.required' => 'The end date field is required.',
        ]);

        if($request->is_staff || $request->is_equipment || $request->is_doctor || $request->is_ambulance){
            $booking = new Booking();
            $booking->booking_type = $request->booking_type;
            $booking->customer_id = $request->customer_id;
            // if($request->is_staff){
            //     $booking->is_staff = 1;
            // }
            // if($request->is_equipment){
            //     $booking->is_equipment = 1;
            // }
            // if($request->is_doctor){
            //     $booking->is_doctor = 1;
            // }
            // if($request->is_ambulance){
            //     $booking->is_ambulance = 1;
            // }
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->sub_total = $request->sub_total;
            $booking->total = $request->total;
            $booking->save();

            $staff_rate = [];
            $equipment_rate = [];
            $doctor_rate = [];
            $ambulance_rate = [];

            $all_dates = [];
            $current_date = strtotime($booking->start_date);
            $end_timestamp = strtotime($booking->end_date);

            while ($current_date <= $end_timestamp) {
                $all_dates[] = date('Y-m-d', $current_date);
                $current_date = strtotime('+1 day', $current_date);
            }

            if(!empty($all_dates)){
                if($request->is_staff){
                    if(!empty($request->staff_data)){
                        foreach($request->staff_data as $staff){
                            if (!empty($staff['staff_type']) && !empty($staff['staff_shift']) && isset($staff['staff_rate'])) {
                                $staff_name = StaffType::where('id',$staff['staff_type'])->pluck('title')->first();
                                $booking_details = new BookingDetails();
                                $booking_details->booking_id = $booking->id;
                                $booking_details->type = 1;
                                $booking_details->shift = $staff['staff_shift'];
                                $booking_details->sell_rate = $staff['staff_rate'];
                                $booking_details->name = $staff_name;
                                $booking_details->qnt = 1;
                                $booking_details->save();
                                foreach($all_dates as $date){
                                    $booking_assign = new BookingAssign();
                                    $booking_assign->booking_id = $booking->id;
                                    $booking_assign->type = $staff_name;
                                    $booking_assign->shift = $staff['staff_shift'];
                                    $booking_assign->sell_rate = $staff['staff_rate'];
                                    $booking_assign->date = $date;
                                    $booking_assign->save();
                                }
                                $staff_rate[] = $staff['staff_rate'];
                            }
                        }
                    }
                }
    
                if($request->is_equipment){
                    if(!empty($request->equipment_data)){
                        foreach($request->equipment_data as $equipment){
                            if (!empty($equipment['equipment_name']) && !empty($equipment['equipment_rate']) && isset($equipment['equipment_qnt'])) {
                                $equipment_details = Equipment::find($equipment['equipment_name']);
                                $booking_details = new BookingDetails();
                                $booking_details->booking_id = $booking->id;
                                $booking_details->type = 2;
                                $booking_details->cost_rate = $equipment_details->cost_price;
                                $booking_details->sell_rate = $equipment['equipment_rate'];
                                $booking_details->name = $equipment_details->name;
                                $booking_details->qnt = $equipment['equipment_qnt'];
                                $booking_details->save();
                                $equipment_rate[] = $equipment['equipment_rate'];
                            }
                        }
                    }
                }
    
                if($request->is_doctor){
                    if(!empty($request->doctor_data)){
                        foreach($request->doctor_data as $doctor){
                            if (!empty($doctor['doctor_shift']) && !empty($doctor['doctor_rate']) && isset($doctor['doctor_name'])) {
                                $booking_details = new BookingDetails();
                                $booking_details->booking_id = $booking->id;
                                $booking_details->type = 3;
                                $booking_details->shift = $doctor['doctor_shift'];
                                $booking_details->sell_rate = $doctor['doctor_rate'];
                                $booking_details->name = $doctor['doctor_name'];
                                $booking_details->qnt = 1;
                                $booking_details->save();
                                foreach($all_dates as $date){
                                    $booking_assign = new BookingAssign();
                                    $booking_assign->booking_id = $booking->id;
                                    $booking_assign->type = "Doctor";
                                    $booking_assign->shift = $doctor['doctor_shift'];
                                    $booking_assign->sell_rate = $doctor['doctor_rate'];
                                    $booking_assign->date = $date;
                                    $booking_assign->save();
                                }
                                $doctor_rate[] = $doctor['doctor_rate'];
                            }
                        }
                    }
                }
    
                if($request->is_ambulance){
                    if(!empty($request->ambulance_data)){
                        foreach($request->ambulance_data as $ambulance){
                            if (!empty($ambulance['ambulance_shift']) && !empty($ambulance['ambulance_rate']) && isset($ambulance['ambulance_name'])) {
                                $booking_details = new BookingDetails();
                                $booking_details->booking_id = $booking->id;
                                $booking_details->type = 4;
                                $booking_details->shift = $ambulance['ambulance_shift'];
                                $booking_details->sell_rate = $ambulance['ambulance_rate'];
                                $booking_details->name = $ambulance['ambulance_name'];
                                $booking_details->qnt = 1;
                                $booking_details->save();
                                $ambulance_rate[] = $ambulance['ambulance_rate'];
                            }
                        }
                    }
                }
            }

            $staff_rate_sum = 0;
            $equipment_rate_sum = 0;
            $doctor_rate_sum = 0;
            $ambulance_rate_sum = 0;

            if(!empty($staff_rate)){
                $staff_rate_sum = array_sum($staff_rate);
                $booking->is_staff = 1;
            }
            if(!empty($equipment_rate)){
                $equipment_rate_sum = array_sum($equipment_rate);
                $booking->is_equipment = 1;
            }
            if(!empty($doctor_rate)){
                $doctor_rate_sum = array_sum($doctor_rate);
                $booking->is_doctor = 1;
            }
            if(!empty($ambulance_rate)){
                $ambulance_rate_sum = array_sum($ambulance_rate);
                $booking->is_ambulance = 1;
            }
            $total = $staff_rate_sum + $equipment_rate_sum + $doctor_rate_sum + $ambulance_rate_sum;
            $booking->sub_total = $total;
            $booking->total = $total;
            $booking->update();

            return redirect('bookings')->with('success','The Booking Created Successfully');
        }else{
            return redirect()->back()->with('error','You Need To Check Your Requirements');
        }
    }
    public function assign_bookings()
    {
        if (in_array("assign_bookings", Auth::user()->permissions())) {
            return view('backend.assign_bookings.booking_list');
        }
        abort(403);
    }
    public function get_assign_bookings_list()
    {   
        $data = Booking::where('is_staff',1)->orWhere('is_doctor',1)->with('bookingDetails')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;

            $staff_data = [];
            $equipment_data = [];
            $doctor_data = [];
            $ambulance_data = [];
            $b_details = $da->bookingDetails;
            foreach($b_details as $dd){
                if($dd->type == 1){
                    $staff_data[] = $dd;
                }
                if($dd->type == 2){
                    $equipment_data[] = $dd;
                }
                if($dd->type == 3){
                    $doctor_data[] = $dd;
                }
                if($dd->type == 4){
                    $ambulance_data[] = $dd;
                }
            }
            $da->staff_count = count($staff_data);
            $da->equipment_count = count($equipment_data);
            $da->doctor_count = count($doctor_data);
            $da->ambulance_count = count($ambulance_data);
        }
        // dd($data);
        return response()->json(['data'=>$data]);
    }
    public function assign_booking($id)
    {
        if (in_array("assign_bookings", Auth::user()->permissions())) {
            $booking = Booking::with('bookingDetails')->find($id);
            $booking->customer_details = $booking->customerDetails();
            $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
            $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
            $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

            $staff_data = [];
            $equipment_data = [];
            $doctor_data = [];
            $ambulance_data = [];
            foreach($booking->bookingDetails as $bookings){
                if($bookings->type == 1){
                    $bookings->staff_type = StaffType::where('title',$bookings->name)->pluck('id')->first();
                    $staff_data[] = $bookings;
                }
                if($bookings->type == 2){
                    $equipment_data[] = $bookings;
                }
                if($bookings->type == 3){
                    $doctor_data[] = $bookings;
                }
                if($bookings->type == 4){
                    $ambulance_data[] = $bookings;
                }
            }
            $shifts = Shifts::orderBy('id',"DESC")->get();
            $staffs = Staff::orderBy('id',"DESC")->get();
            $doctors = Doctor::orderBy('id',"DESC")->get();
            // dd($booking->bookingDetails);
            return view('backend.assign_bookings.assign_booking',['shifts'=>$shifts,'staff_data'=>$staff_data,'equipment_data'=>$equipment_data,'doctor_data'=>$doctor_data,'ambulance_data'=>$ambulance_data,'booking'=>$booking,'staffs'=>$staffs,'doctors'=>$doctors]);
        }
        abort(403);
    }
    public function store_assign_booking(Request $request,$id)
    {
        $start_date = $request->data[0]['start_date'];
        $end_date = $request->data[0]['end_date'];

        if($start_date != null && $end_date != null){
            $all_dates = [];
            $current_date = strtotime($start_date);
            $end_timestamp = strtotime($end_date);

            while ($current_date <= $end_timestamp) {
                $all_dates[] = date('Y-m-d', $current_date);
                $current_date = strtotime('+1 day', $current_date);
            }
            $error = [];
            $null_count = [];
            if(!empty($request->staff_data)){
                foreach($request->staff_data as $staff){
                    if($staff['staff_id'] == null){
                        $null_count[] = $staff;
                    }else{
                        if(!empty($all_dates)){
                            foreach($all_dates as $date){
                                $booking_assign_varification = BookingAssign::whereNotNull('staff_id')
                                    ->where(['staff_id' => $staff['staff_id'],'type' => $staff['type'], 'date' => $date]);
    
                                // Add shift conditions based on the staff's shift
                                if ($staff['shift'] == 3) {
                                    $booking_assign_varification->whereIn('shift', ['1', '2', '3']);
                                } elseif ($staff['shift'] == 2) {
                                    $booking_assign_varification->whereIn('shift', ['2', '3']);
                                } elseif ($staff['shift'] == 1) {
                                    $booking_assign_varification->whereIn('shift', ['1', '3']);
                                } else {
                                    $booking_assign_varification->whereIn('shift', ['1', '2', '3']);
                                }
    
                                // Execute the query and get the results
                                $ids = $booking_assign_varification->get();
    
                                // Check if any booking assignments were found
                                if (!$ids->isEmpty()) {
                                    // Staff is not available, retrieve their data
                                    $staff_data = Staff::find($staff['staff_id']);
                                    if ($staff_data) {
                                        $error[] = $staff_data->f_name . " " . $staff_data->m_name . " " . $staff_data->l_name . " are not available on date " . $date;
                                    }
                                } else {
                                    // No conflicting booking assignments, assign the staff to the booking
                                    $booking_assign = BookingAssign::where([
                                        'staff_id' => null,
                                        'booking_id' => $request->booking_id,
                                        'type' => $staff['type'],
                                        'shift' => $staff['shift'],
                                        'date' => $date
                                    ])->first();
    
                                    if ($booking_assign) {
                                        $booking_assign->staff_id = $staff['staff_id'];
                                        $booking_assign->cost_rate = $staff['rate'];
                                        $booking_assign->update();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if(!empty($error)){
                return redirect()->back()->with('bulk_error', $error);
            }else{
                if(count($null_count) == count($request->staff_data)){
                    return redirect()->back()->with('error','Please Select Staff.');
                }else{
                    return redirect()->back()->with('success','Staff Assigned Successfully.');
                }
            }
        }else{
            return redirect()->back()->with('error','Please Enter Start Date & End Date.');
        }

    }
    public function assign_single_staff(Request $request)
    {
        $booking_assign = BookingAssign::find($request->id);

        if($booking_assign){
            $booking_assign->cost_rate = $request->rate;
            $booking_assign->staff_id = $request->staff_id;
            $booking_assign->update();
            return redirect()->back()->with('success','Staff Assigned Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    public function assign_single_doctor(Request $request)
    {
        $booking_assign = BookingAssign::find($request->id);

        if($booking_assign){
            $booking_assign->cost_rate = $request->rate;
            $booking_assign->staff_id = $request->staff_id;
            $booking_assign->update();
            return redirect()->back()->with('success','Doctor Assigned Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    // public function check_staff_availability(Request $request)
    // {
    //     $staffType = StaffType::find($request->type);
    //     $booking_assign = BookingAssign::whereNotNull('staff_id')->where(['type'=>$staffType->title,'shift'=>$request->shift,'date'=>$request->date])->pluck('staff_id');
    //     if(empty($booking_assign)){
    //         $staffs = Staff::where('type',$request->type)->orderBy('id',"DESC")->get();
    //     }else{
    //         $staffs = Staff::whereNotIn('id', $booking_assign)->where('type',$request->type)->orderBy('id', "DESC")->get();
    //     }
    //     return $staffs;
    // }
    public function check_staff_availability(Request $request)
    {
        $staffType = StaffType::find($request->type);
        $booking_assign = BookingAssign::whereNotNull('staff_id')->where(['type'=>$staffType->title,'date'=>$request->date]);

        if($request->shift == 3){
            $booking_assign->whereIn('shift',['1','2','3']);
        }elseif($request->shift == 2){
            $booking_assign->whereIn('shift',['2','3']);
        }elseif($request->shift == 1){
            $booking_assign->whereIn('shift',['1','3']);
        }else{
            $booking_assign->whereIn('shift',['1','2','3']);
        }
        $ids = $booking_assign->pluck('staff_id');

        if(empty($ids)){
            $staffs = Staff::where('type',$request->type)->orderBy('id',"DESC")->get();
        }else{
            $staffs = Staff::whereNotIn('id', $ids)->where('type',$request->type)->orderBy('id', "DESC")->get();
        }

        return $staffs;
    }
    public function check_doctor_availability(Request $request)
    {
        $booking_assign = BookingAssign::whereNotNull('staff_id')->where(['type'=>'Doctor','shift'=>$request->shift,'date'=>$request->date])->pluck('staff_id');
        if(empty($booking_assign)){
            $doctors = Doctor::orderBy('id',"DESC")->get();
        }else{
            // $doctors = Doctor::whereNotIn('id', $booking_assign)->orderBy('id', "DESC")->get();
            $doctors = Doctor::orderBy('id',"DESC")->get();
        }
        return $doctors;
    }
}

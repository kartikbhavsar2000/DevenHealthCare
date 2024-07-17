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
use App\Models\BookingRating;
use App\Models\BookingPayment;

class BookingController extends Controller
{
    public function invoice($id)
    {
        $booking = Booking::with('bookingDetails')->find($id);
        $booking->customer_details = $booking->customerDetails();
        $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
        $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
        $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

        foreach($booking->bookingDetails as $detail) {
            $shift = Shifts::find($detail->shift);
            $detail->shift_name = $shift ? " (".$shift->name.")" : "";
        }
        return view('backend.bookings.invoice',['booking' => $booking]);
    }
    public function print($id)
    {
        $booking = Booking::with('bookingDetails')->find($id);
        $booking->customer_details = $booking->customerDetails();
        $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
        $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
        $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

        foreach($booking->bookingDetails as $detail) {
            $shift = Shifts::find($detail->shift);
            $detail->shift_name = $shift ? " (".$shift->name.")" : "";
        }
        return view('backend.pdf.print',['booking' => $booking]);
    }
    public function download($id)
    {
        $booking = Booking::with('bookingDetails')->find($id);
        $booking->customer_details = $booking->customerDetails();
        $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
        $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
        $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

        foreach($booking->bookingDetails as $detail) {
            $shift = Shifts::find($detail->shift);
            $detail->shift_name = $shift ? " (".$shift->name.")" : "";
        }
        return view('backend.pdf.download',['booking' => $booking]);
    }
    public function bookings()
    {
        if (in_array("bookings", Auth::user()->permissions())) {
            return view('backend.bookings.booking_list');
        }
        abort(403);
    }
    public function get_bookings_list()
    {   
        $data = Booking::whereIn('booking_status',[0,2])->with('added_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
        }
        return response()->json(['data'=>$data]);
    }
    public function closed_bookings()
    {
        if (in_array("closed_bookings", Auth::user()->permissions())) {
            return view('backend.bookings.closed_booking_list');
        }
        abort(403);
    }
    public function get_closed_bookings_list()
    {   
        $data = Booking::where('booking_status',1)->with('closed_by')->orderBy('id',"DESC")->get();
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
            $corporates = Corporate::with('state')->with('city')->with('area')->orderBy('id',"DESC")->get();
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $data = [
                'shifts' => $shifts,
                'staff_type' => $staff_type,
                'patients' => $patients,
                'equipments' => $equipments,
                'hospitals' => $hospitals,
                'corporates' => $corporates,
                'states' => $states,
                'ambulance' => $ambulance,
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
                    $booking_assign = BookingAssign::where(['booking_id'=>$bookings->booking_id,'booking_detail_id'=>$bookings->id])->first();
                    if($booking_assign){
                        $bookings->date = date('d/m/Y',strtotime($booking_assign->date));
                    }else{
                        $bookings->date = "";
                    }
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
    public function view_booking_assign_details($id)
    {
        if (in_array("bookings", Auth::user()->permissions())) {
            $data = Booking::find($id);
            $data->customer_details = $data->customerDetails();
            return view('backend.bookings.view_booking_assign',['data'=>$data]);
        }
        abort(403);
    }
    public function get_booking_assign_details(Request $request){
        $requestMonth = $request->month;
        $startDate = date('Y-m-01', strtotime($requestMonth));
        $endDate = date('Y-m-t', strtotime($requestMonth));

        $staff = BookingAssign::where('type','!=','Doctor')->where(['booking_id'=>$request->id,'att_marked'=>1,'status'=>1])->whereBetween('date', [$startDate, $endDate])->with('booking')->with('shift')->orderBy('date','asc')->get();
        $doctor = BookingAssign::where('type','Doctor')->where('booking_id',$request->id)->whereBetween('date', [$startDate, $endDate])->with('booking')->with('shift')->get();

        $data = [];

        foreach($staff as $st){
            $staff = Staff::find($st->staff_id);        
            if($staff){
                $st->staff_name = $staff->f_name ." ". $staff->m_name ." ". $staff->l_name;
                $st->staff_id = $staff->staff_id;
                $st->month = $requestMonth;
                $data[] = $st;
            }
        }

        foreach($doctor as $dt){
            $doctor = Doctor::find($dt->staff_id);
            if($doctor){
                $dt->staff_name = $doctor->name;
                $dt->staff_id = $doctor->doctor_id;
                $dt->month = $requestMonth;
                $data[] = $dt;
            }
        }

        return $data;
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

            $staff_available = false;
            $equipment_available = false;
            $doctor_available = false;
            $ambulance_available = false;

            if($request->is_staff){
                if(!empty($request->staff_data)){
                    foreach($request->staff_data as $staff){
                        if (!empty($staff['staff_type']) && !empty($staff['staff_shift']) && isset($staff['staff_rate'])) {
                            $staff_available = true;
                        }
                    }
                }
            }

            if($request->is_equipment){
                if(!empty($request->equipment_data)){
                    foreach($request->equipment_data as $equipment){
                        if (!empty($equipment['equipment_name']) && !empty($equipment['equipment_rate']) && isset($equipment['equipment_qnt'])) {
                            $equipment_available = true;
                        }
                    }
                }
            }

            if($request->is_doctor){
                if(!empty($request->doctor_data)){
                    foreach($request->doctor_data as $doctor){
                        if (!empty($doctor) && isset($doctor['doctor_shift']) && isset($doctor['doctor_rate']) && isset($doctor['doctor_name']) && isset($doctor['date'])) {
                            $doctor_available = true;
                        }
                    }
                }
            }

            if($request->is_ambulance){
                if(!empty($request->ambulance_data)){
                    foreach($request->ambulance_data as $ambulance){
                        if (!empty($ambulance['ambulance_shift']) && !empty($ambulance['ambulance_rate']) && isset($ambulance['ambulance_name'])) {
                            $ambulance_available = true;
                        }
                    }
                }
            }

            if($request->is_staff && $staff_available === false){
                return redirect()->back()->with('error','Please fill in all fields for staff');
            }
            if($request->is_equipment && $equipment_available === false){
                return redirect()->back()->with('error','Please fill in all fields for equipment');
            }
            if($request->is_doctor && $doctor_available === false){
                return redirect()->back()->with('error','Please fill in all fields for doctor');
            }
            if($request->is_ambulance &&  $ambulance_available === false){
                return redirect()->back()->with('error','Please fill in all fields for ambulance');
            }

            $booking = new Booking();
            $booking->booking_type = $request->booking_type;
            $booking->customer_id = $request->customer_id;
            $booking->start_date = $request->start_date;
            $booking->end_date = $request->end_date;
            $booking->sub_total = $request->sub_total;
            $booking->total = $request->total;
            $booking->pending_payment = $request->total;
            $booking->created_by = Auth::user()->id;
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
                                $booking_details->qnt = count($all_dates);
                                $booking_details->save();
                                foreach($all_dates as $date){
                                    $booking_assign = new BookingAssign();
                                    $booking_assign->booking_id = $booking->id;
                                    $booking_assign->booking_detail_id = $booking_details->id;
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
                                $booking_details->cost_rate = $equipment_details->sell_price;
                                $booking_details->sell_rate = $equipment['equipment_rate'];
                                $booking_details->name = $equipment_details->name;
                                $booking_details->qnt = $equipment['equipment_qnt'];
                                $booking_details->date = date('Y-m-d',strtotime($booking->start_date));
                                $booking_details->save();
                                $equipment_rate[] = $equipment['equipment_rate'];
                            }
                        }
                    }
                }
    
                if($request->is_doctor){
                    if(!empty($request->doctor_data)){
                        foreach($request->doctor_data as $doctor){
                            if (!empty($doctor) && isset($doctor['doctor_shift']) && isset($doctor['doctor_rate']) && isset($doctor['doctor_name']) && isset($doctor['date'])) {

                                $timestamp = strtotime($doctor['date']);

                                $booking_details = new BookingDetails();
                                $booking_details->booking_id = $booking->id;
                                $booking_details->type = 3;
                                $booking_details->shift = $doctor['doctor_shift'];
                                $booking_details->sell_rate = $doctor['doctor_rate'];
                                $booking_details->name = $doctor['doctor_name'];
                                $booking_details->qnt = 1;
                                $booking_details->date = date('Y-m-d', $timestamp);
                                $booking_details->save();

                                $booking_assign = new BookingAssign();
                                $booking_assign->booking_id = $booking->id;
                                $booking_assign->booking_detail_id = $booking_details->id;
                                $booking_assign->type = "Doctor";
                                $booking_assign->shift = $doctor['doctor_shift'];
                                $booking_assign->sell_rate = $doctor['doctor_rate'];

                                
                                $booking_assign->date = date('Y-m-d', $timestamp);

                                $booking_assign->save();

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
                                $booking_details->date = date('Y-m-d',strtotime($booking->start_date));
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
                foreach($all_dates as $date){
                    $staff_rate_sum += array_sum($staff_rate);
                }
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
            $booking->pending_payment = $total;
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
        $data = Booking::where(['booking_status'=>0,'is_staff'=>1])->with('bookingDetails')->with('assign_by')->orderBy('id',"DESC")->get();
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
                    if($bookings->shift == 3){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('full_cost')
                                  ->where('full_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }elseif($bookings->shift == 2){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('night_cost')
                                  ->where('night_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }elseif($bookings->shift == 1){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('day_cost')
                                  ->where('day_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }else{
                        $staff = Staff::where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }
                    $bookings->staffs = $staff;
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
    public function cancel_booking_staff($id)
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
                    $bookings->staff_type = StaffType::where('title',$bookings->name)->pluck('id')->first();
                    if($bookings->shift == 3){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('full_cost')
                                  ->where('full_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }elseif($bookings->shift == 2){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('night_cost')
                                  ->where('night_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }elseif($bookings->shift == 1){
                        $staff = Staff::where(function ($query) {
                            $query->whereNotNull('day_cost')
                                  ->where('day_cost', '>', 0);
                        })->where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }else{
                        $staff = Staff::where('type',$bookings->staff_type)->orderBy('id',"DESC")->get();
                    }
                    $bookings->staffs = $staff;
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
            return view('backend.bookings.cancel_booking_staff',['shifts'=>$shifts,'staff_data'=>$staff_data,'equipment_data'=>$equipment_data,'doctor_data'=>$doctor_data,'ambulance_data'=>$ambulance_data,'booking'=>$booking,'staffs'=>$staffs,'doctors'=>$doctors]);
        }
        abort(403);
    }
    public function cancel_staff(Request $request,$booking_id)
    {
        // return $request;
        $booking = Booking::find($booking_id);
        if (!$booking) {
            return redirect()->back()->with('error',"Data Not Found");
        }
        $isDates = false;
        foreach($request->staff_data as $key => $stafff){
            $staff = (object)$stafff;
            $start_date = $staff->start_date;
            $end_date = $staff->end_date;
            if($start_date && $end_date){
                $isDates = true;
                $bookingDetails = BookingDetails::find($staff->detail_id);
                if($bookingDetails){
                    $data = BookingAssign::where(['booking_id'=> $booking->id,'booking_detail_id'=>$bookingDetails->id])->whereBetween('date',[$start_date,$end_date])->get();

                    foreach($data as $da){
                        $da->delete();
                    }

                    $staff_and_doctor_sum = BookingAssign::where(['booking_id'=> $booking->id])->sum('sell_rate');

                    $equipment_and_ambulance_sum = BookingDetails::where('booking_id', $booking->id)
                        ->whereIn('type', [2, 4])
                        ->sum('sell_rate');

                    $paid_ammount = BookingPayment::where('booking_id', $booking->id)
                        ->sum('amount');


                    $total = $staff_and_doctor_sum + $equipment_and_ambulance_sum;
                    $pending = $total - $paid_ammount;

                    $booking->total = $total;
                    $booking->sub_total = $total;
                    $booking->pending_payment = $pending;
                    $booking->update();

                    $count = BookingAssign::where(['booking_id'=> $booking->id,'booking_detail_id'=>$bookingDetails->id])->count();

                    $bookingDetails->qnt = $count;
                    $bookingDetails->update();

                    $checkIfNull = BookingAssign::where(['booking_id'=> $booking->id,'booking_detail_id'=>$bookingDetails->id])->get();
                    if($checkIfNull->isEmpty()){
                        $bookingDetails->delete();
                    }
                }
            }
        }
        if($booking->bookingDetails->isEmpty()){
            $booking->delete();
        }
        if($isDates == false){
            return redirect()->back()->with('error','Please provide any one start date and end date for submission.');
        }else{
            return redirect('bookings')->with('success','Staff Canceled Successfully.');
        }
    }
    public function store_assign_booking(Request $request,$id)
    {
        if (isset($request->data[0]['start_date']) && isset($request->data[0]['end_date'])) {
            $start_date = $request->data[0]['start_date'];
            $end_date = $request->data[0]['end_date'];

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
                                    ->where(['booking_status'=>0,'staff_id' => $staff['staff_id'],'type' => $staff['type'], 'date' => $date]);
    
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
                                        $error_date = strtotime($date);
                                        $error_date_formated = date('d/m/Y', $error_date);
                                        $error[] = $staff_data->f_name . " " . $staff_data->m_name . " " . $staff_data->l_name . " is not available on date " . $error_date_formated;
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
            $bookss = Booking::find($id);
            if(!empty($error)){
                if(count($error) == count($request->staff_data) * count($all_dates)){
                    return redirect()->back()->with('bulk_error', $error);
                }else{
                    if($bookss){
                        $bookss->status = 1;
                        $bookss->assigned_by = Auth::user()->id;
                        $bookss->update();
                    }
                    return redirect('assign_bookings')->with('bulk_error', $error);
                }
            }else{
                if(count($null_count) == count($request->staff_data)){
                    return redirect()->back()->with('error','Please Select Staff.');
                }else{
                    if($bookss){
                        $bookss->status = 1;
                        $bookss->assigned_by = Auth::user()->id;
                        $bookss->update();
                    }
                    return redirect('assign_bookings')->with('success','Staff Assigned Successfully.');
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

            $booking = Booking::find($booking_assign->booking_id);
            $booking_assign_fetch = BookingAssign::where('type','!=',"Doctor")->whereNull('staff_id')->where('booking_id', $booking->id)->get();

            if ($booking_assign_fetch->isEmpty()) {
                $booking->status = 1;
                $booking->assigned_by = Auth::user()->id;
                $booking->update();
            }

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
    public function add_assign_single_staff(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        if($booking){
            $checkIfAvailable = BookingDetails::where(['booking_id'=>$booking->id,'type'=>1,'shift'=>$request->shift,'sell_rate'=>$request->sell_rate,'name'=>$request->staff_type])->first();
            $count = BookingDetails::where(['booking_id'=>$booking->id,'type'=>1,'shift'=>$request->shift,'sell_rate'=>$request->sell_rate,'name'=>$request->staff_type])->count();
            $count2 =  BookingAssign::where(['booking_id'=>$booking->id,'type'=>$request->staff_type,'shift'=>$request->shift,'sell_rate'=>$request->sell_rate,'date'=>$request->date])->count();
            // return $count2;
            if($checkIfAvailable && $count > $count2){
                $check = BookingDetails::where(['booking_id'=>$booking->id,'type'=>1,'shift'=>$request->shift,'sell_rate'=>$request->sell_rate,'name'=>$request->staff_type])->get();
                $abc = [];
                $booking_detail_id = "";
                foreach($check as $k => $ch){
                    if($k == $count2){
                        $ch->qnt = $ch->qnt + 1;
                        $ch->update();
                        $booking_detail_id = $ch->id;
                    }
                }
            }else{
                $booking_details = new BookingDetails();
                $booking_details->booking_id = $booking->id;
                $booking_details->type = 1;
                $booking_details->shift = $request->shift;
                $booking_details->sell_rate = $request->sell_rate;
                $booking_details->name = $request->staff_type;
                $booking_details->qnt = 1;
                $booking_details->save();

                $booking_detail_id = $booking_details->id;
            }
            
            $booking_assign = new BookingAssign();
            $booking_assign->booking_id = $booking->id;
            $booking_assign->booking_detail_id = $booking_detail_id;
            $booking_assign->type = $request->staff_type;
            $booking_assign->shift = $request->shift;
            $booking_assign->sell_rate = $request->sell_rate;
            $booking_assign->cost_rate = $request->cost_rate;
            $booking_assign->staff_id = $request->staff_id;
    
            $timestamp = strtotime($request->date);
            $booking_assign->date = date('Y-m-d', $timestamp);
    
            $booking_assign->save();

            $sub_total = $booking->sub_total + $request->sell_rate;
            $total = $booking->total + $request->sell_rate;
            $pending_payment = $booking->pending_payment + $request->sell_rate;

            $booking->sub_total = $sub_total;
            $booking->total = $total;
            $booking->pending_payment = $pending_payment;
            $booking->is_staff = 1;
            $booking->update();
    
            return redirect()->back()->with('success','Staff Added & Assign Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    public function add_assign_single_doctor(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        if($booking){
            $timestamp = strtotime($request->date);

            $booking_details = new BookingDetails();
            $booking_details->booking_id = $booking->id;
            $booking_details->type = 3;
            $booking_details->shift = $request->shift;
            $booking_details->sell_rate = $request->sell_rate;
            $booking_details->name = $request->staff_type;
            $booking_details->qnt = 1;
            $booking_details->date = date('Y-m-d', $timestamp);
            $booking_details->save();
    
            $booking_assign = new BookingAssign();
            $booking_assign->booking_id = $booking->id;
            $booking_assign->booking_detail_id = $booking_details->id;
            $booking_assign->type = $request->staff_type;
            $booking_assign->shift = $request->shift;
            $booking_assign->sell_rate = $request->sell_rate;
            $booking_assign->cost_rate = $request->cost_rate;
            $booking_assign->staff_id = $request->staff_id;
    
            
            $booking_assign->date = date('Y-m-d', $timestamp);
    
            $booking_assign->save();

            $sub_total = $booking->sub_total + $request->sell_rate;
            $total = $booking->total + $request->sell_rate;
            $pending_payment = $booking->pending_payment + $request->sell_rate;

            $booking->sub_total = $sub_total;
            $booking->total = $total;
            $booking->pending_payment = $pending_payment;
            $booking->is_doctor = 1;
            $booking->update();
    
            return redirect()->back()->with('success','Doctor Added & Assign Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    public function add_single_equipment(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        if($booking){
            $timestamp = strtotime($request->date);

            if($request->name){
                $equipment = Equipment::find($request->name);
            }else{
                $equipment = "";
            }
            $booking_details = new BookingDetails();
            $booking_details->booking_id = $booking->id;
            $booking_details->type = 2;
            $booking_details->sell_rate = $request->sell_rate;
            $booking_details->cost_rate = $request->cost_rate;
            $booking_details->name = $equipment->name;
            $booking_details->qnt = $request->qnt;
            $booking_details->date = date('Y-m-d', $timestamp);
            $booking_details->save();

            $sub_total = $booking->sub_total + $request->sell_rate;
            $total = $booking->total + $request->sell_rate;
            $pending_payment = $booking->pending_payment + $request->sell_rate;

            $booking->sub_total = $sub_total;
            $booking->total = $total;
            $booking->pending_payment = $pending_payment;
            $booking->is_equipment = 1;
            $booking->update();
    
            return redirect()->back()->with('success','Equipment Added Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    public function add_single_ambulance(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        if($booking){
            $timestamp = strtotime($request->date);
            
            $booking_details = new BookingDetails();
            $booking_details->booking_id = $booking->id;
            $booking_details->type = 4;
            $booking_details->sell_rate = $request->sell_rate;
            $booking_details->name = $request->type;
            $booking_details->shift = $request->shift;
            $booking_details->qnt = 1;
            $booking_details->date = date('Y-m-d', $timestamp);
            $booking_details->save();

            $sub_total = $booking->sub_total + $request->sell_rate;
            $total = $booking->total + $request->sell_rate;
            $pending_payment = $booking->pending_payment + $request->sell_rate;
            
            $booking->sub_total = $sub_total;
            $booking->total = $total;
            $booking->pending_payment = $pending_payment;
            $booking->is_ambulance = 1;
            $booking->update();
    
            return redirect()->back()->with('success','Ambulance Added Successfully.');
        }else{
            return redirect()->back()->with('error','Data Not Found.');
        }
    }
    public function check_staff_availability(Request $request)
    {
        $staffType = StaffType::find($request->type);
        $booking_assign = BookingAssign::whereNotNull('staff_id')->where(['booking_status'=>0,'type'=>$staffType->title,'date'=>$request->date]);

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
            if($request->shift == 3){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('full_cost')
                          ->where('full_cost', '>', 0);
                })->where('type',$request->type)->orderBy('id',"DESC")->get();
            }elseif($request->shift == 2){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('night_cost')
                          ->where('night_cost', '>', 0);
                })->where('type',$request->type)->orderBy('id',"DESC")->get();
            }elseif($request->shift == 1){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('day_cost')
                          ->where('day_cost', '>', 0);
                })->where('type',$request->type)->orderBy('id',"DESC")->get();
            }else{
                $staffs = Staff::where('type',$request->type)->orderBy('id',"DESC")->get();
            }
        }else{
            if($request->shift == 3){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('full_cost')
                          ->where('full_cost', '>', 0);
                })->whereNotIn('id', $ids)->where('type',$request->type)->orderBy('id', "DESC")->get();
            }elseif($request->shift == 2){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('night_cost')
                          ->where('night_cost', '>', 0);
                })->whereNotIn('id', $ids)->where('type',$request->type)->orderBy('id', "DESC")->get();
            }elseif($request->shift == 1){
                $staffs = Staff::where(function ($query) {
                    $query->whereNotNull('day_cost')
                          ->where('day_cost', '>', 0);
                })->whereNotIn('id', $ids)->where('type',$request->type)->orderBy('id', "DESC")->get();
            }else{
                $staffs = Staff::whereNotIn('id', $ids)->where('type',$request->type)->orderBy('id', "DESC")->get();
            }
        }

        return $staffs;
    }
    public function check_doctor_availability(Request $request)
    {
        $booking_assign = BookingAssign::whereNotNull('staff_id')->where(['booking_status'=>0,'type'=>'Doctor','shift'=>$request->shift,'date'=>$request->date])->pluck('staff_id');
        if(empty($booking_assign)){
            if($request->shift == 3){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('full_cost')
                          ->where('full_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }elseif($request->shift == 2){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('night_cost')
                          ->where('night_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }elseif($request->shift == 1){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('day_cost')
                          ->where('day_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }else{
                $doctors = Doctor::orderBy('id',"DESC")->get();
            }
        }else{
            // $doctors = Doctor::whereNotIn('id', $booking_assign)->orderBy('id', "DESC")->get();
            if($request->shift == 3){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('full_cost')
                          ->where('full_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }elseif($request->shift == 2){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('night_cost')
                          ->where('night_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }elseif($request->shift == 1){
                $doctors = Doctor::where(function ($query) {
                    $query->whereNotNull('day_cost')
                          ->where('day_cost', '>', 0);
                })->orderBy('id',"DESC")->get();
            }else{
                $doctors = Doctor::orderBy('id',"DESC")->get();
            }
        }
        return $doctors;
    }
    public function staff_attendance()
    {
        if (in_array("staff_attendance", Auth::user()->permissions())) {
            return view('backend.staff_attendance.staff_attendance_list');
        }
        abort(403);
    }
    public function get_staff_attendance_list(Request $request)
    {   
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        if($startDate && $endDate){
            $data = BookingAssign::when($startDate === $endDate, function ($query) use ($startDate) {
                return $query->whereDate('date', $startDate);
            }, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })->where('att_marked',1)->with('updated_by_user')->with('booking')->with('staff')->with('shift')->orderBy('id',"DESC")->get();
        }else{
            $date =  date('Y-m-d');
            $data = BookingAssign::whereDate('date',$date)->where('att_marked',1)->with('booking')->with('updated_by_user')->with('staff')->with('shift')->orderBy('id',"DESC")->get();
        }
        return response()->json(['data'=>$data]);
    }
    public function approve_reject_staff_attendance(Request $request)
    {
        $data = BookingAssign::find($request->id);
        if($data){
            $data->status = $request->status;
            $data->updated_by = Auth::user()->id;
            if($request->status == 2){
                $data->rej_reason = $request->reason;
            }
            $data->update();
            return "Done";
        }else{
            return "NoData";
        }
    }
    public function make_attandance_pending(Request $request)
    {
        $data = BookingAssign::find($request->id);
        if($data){
            $data->status = 0;
            $data->att_marked = 0;
            $data->staff_payment = 0;
            $data->updated_by = Auth::user()->id;
            $data->update();
            return "Done";
        }else{
            return "NoData";
        }
    }
    public function booking_reviews()
    {
        if (in_array("booking_reviews", Auth::user()->permissions())) {
            return view('backend.booking_reviews.booking_reviews_list');
        }
        abort(403);
    }
    public function get_booking_reviews_list()
    {   
        $data = Booking::where('booking_status',1)->with('added_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
        }
        return response()->json(['data'=>$data]);
    }
    public function add_booking_reviews($id)
    {   
        $booking = Booking::find($id);
    
        if (!$booking) {
            return redirect()->back()->with('error', "No Data Found");
        }
    
        $doctorIds = BookingAssign::where('type', 'Doctor')
            ->whereNotNull('staff_id')
            ->where('booking_id', $booking->id)
            ->distinct()
            ->orderBy('id', 'DESC')
            ->pluck('staff_id');
    
        $staffIds = BookingAssign::where('type', '!=', 'Doctor')
            ->whereNotNull('staff_id')
            ->where('booking_id', $booking->id)
            ->distinct()
            ->orderBy('id', 'DESC')
            ->pluck('staff_id');
    
        $ratings = BookingRating::where('booking_id', $id)->get();
    
        $data = [];
        // $this->addDoctors($doctorIds, $ratings, $data);
        $this->addStaff($staffIds, $ratings, $data);
    
        return view('backend.booking_reviews.add_booking_reviews', ['data' => $data, 'booking' => $booking]);
    }
    private function addDoctors($doctorIds, $ratings, &$data)
    {
        foreach ($doctorIds as $docId) {
            $doctor = Doctor::find($docId);
            if ($doctor) {
                $doctor->type_name = "Doctor";
                $doctor->unique_id = $doctor->doctor_id;
                $doctor->staff_name = $doctor->name;
    
                if ($this->isNotRated($ratings, $doctor->id, $doctor->type_name)) {
                    $data[] = $doctor;
                }
            }
        }
    }
    private function addStaff($staffIds, $ratings, &$data)
    {
        foreach ($staffIds as $staffId) {
            $staff = Staff::find($staffId);
            if ($staff) {
                $staff->type_name = StaffType::where('id', $staff->type)->pluck('title')->first();
                $staff->unique_id = $staff->staff_id;
                $staff->staff_name = "{$staff->f_name} {$staff->m_name} {$staff->l_name}";
    
                if ($this->isNotRated($ratings, $staff->id, $staff->type_name)) {
                    $data[] = $staff;
                }
            }
        }
    }
    private function isNotRated($ratings, $staffId, $typeName)
    {
        foreach ($ratings as $rate) {
            if ($rate->staff_id == $staffId && $rate->type == $typeName) {
                return false;
            }
        }
        return true;
    }
    public function create_booking_reviews(Request $request){
        $request->validate([
            'staff_id' => 'required',
        ],[
            'staff_id.required' => 'The staff field is required.',
        ]);

        $rating = new BookingRating();
        $rating->booking_id = $request->booking_id;
        $rating->staff_id = $request->staff_id;
        $rating->type = $request->staff_type;
        $rating->rating = $request->rating;
        $rating->description = $request->description;
        $rating->added_by = Auth::user()->id;
        $rating->save();

        return redirect()->back()->with('success',"Rating Added Successfully!");
    }
    public function get_staff_reviews_list($id)
    {   
        $data = BookingRating::where('type','!=',"Doctor")->where('booking_id',$id)->with('created_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            // if($da->type == "Doctor"){
            //     $doctor = Doctor::find($da->staff_id);
            //     if($doctor){
            //         $da->staff_name = $doctor->name;
            //     }else{
            //         $da->staff_name = "";
            //     }
            // }else{
                $staff = Staff::find($da->staff_id);
                if($staff){
                    $da->staff_name = $staff->f_name . " " . $staff->m_name . " " . $staff->l_name;;
                }else{
                    $da->staff_name = "";
                }
            }
        // }
        return response()->json(['data'=>$data]);
    }
    public function pause_booking(Request $request)
    {   
        $booking = Booking::find($request->id);
        if (!$booking) {
            return "Error";
        }
        

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $start_date = $booking->start_date;
        $end_date = $booking->end_date;
        if($end_date <= $yesterday){
            return "Date";
        }

        $all_dates = [];
        $current_date = strtotime($start_date);
        $end_timestamp = strtotime($yesterday);

        while ($current_date <= $end_timestamp) {
            $all_dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }

        $days_count = count($all_dates);

        $bookingDetails = BookingDetails::where(['booking_id'=> $booking->id,'type'=>1])->get();

        foreach($bookingDetails as $details){
            $details->qnt = $days_count;
            $details->update();
        }

        $data = BookingAssign::where('booking_id', $booking->id)->whereBetween('date',[$today,$end_date])->get();

        foreach($data as $da){
            // $da->staff_id = NULL;
            // $da->cost_rate = NULL;
            // $da->att_marked = 0;
            // $da->status = 0;
            // $da->booking_status = 1;
            // $da->staff_payment = 0;
            // $da->updated_by = Auth::user()->id;
            $da->delete();
        }

        $staff_and_doctor_sum = BookingAssign::where('booking_id', $booking->id)
            ->whereBetween('date', [$booking->start_date, $yesterday])
            ->sum('sell_rate');

        $equipment_and_ambulance_sum = BookingDetails::where('booking_id', $booking->id)
            ->whereIn('type', [2, 4])
            ->sum('sell_rate');

        $paid_ammount = BookingPayment::where('booking_id', $booking->id)
            ->sum('amount');


        $total = $staff_and_doctor_sum + $equipment_and_ambulance_sum;
        $pending = $total - $paid_ammount;

        $booking->end_date = $yesterday;
        $booking->total = $total;
        $booking->sub_total = $total;
        $booking->pending_payment = $pending;
        $booking->booking_status = 2;

        if($request->reason){
            $booking->pause_reason = $request->reason;
        }
        $booking->update();

        return "Done";
    }
    
}

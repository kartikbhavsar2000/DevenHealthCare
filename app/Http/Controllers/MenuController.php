<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\Hospital;
use App\Models\Corporate;
use App\Models\Doctor;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\StaffDocuments;
use App\Models\AdvanceSalary;
use App\Models\AdvanceSalaryHistory;
use App\Models\Booking;
use App\Models\BookingDetails;
use App\Models\BookingAssign;
use App\Models\BookingRating;
use App\Models\BookingPayment;

class MenuController extends Controller
{
    public function patients()
    {
        if (in_array("patients", Auth::user()->permissions())) {
            return view('backend.patients.patient_list');
        }
        abort(403);
    }
    public function get_patients_list()
    {   
        $data = Patient::with('state')->with('city')->with('area')->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_patient()
    {
        if (in_array("patients", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $hospitals = Hospital::orderBy('id',"DESC")->get();
            return view('backend.patients.add_patient',['states'=>$states,'hospitals'=>$hospitals]);
        }
        abort(403);
    }
    public function edit_patient($id)
    {
        if (in_array("patients", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $data = Patient::find($id);
            $hospitals = Hospital::orderBy('id',"DESC")->get();
            return view('backend.patients.edit_patient',['states'=>$states,'cities'=>$cities,'area'=>$area,'data'=>$data,'hospitals'=>$hospitals]);
        }
        abort(403);
    }
    public function view_patient_history($id)
    {
        if (in_array("patients", Auth::user()->permissions())) {
            $data = Patient::find($id);
            return view('backend.patients.view_patient_history',['data'=>$data]);
        }
        abort(403);
    }
    public function get_patient_history_list($id){
        $data = Booking::where(['booking_type'=>'Patient','customer_id'=>$id])->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function delete_patient(Request $request)
    {
        // Find the patient
        $patient = Patient::find($request->id);

        // If patient does not exist, return an error response
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        // Delete the patient
        $patient->delete();

        // Find all bookings associated with the patient
        $bookings = Booking::where(['booking_type' => 'Patient', 'customer_id' => $request->id])->get();

        foreach ($bookings as $booking) {
            // Delete associated records
            BookingAssign::where('booking_id', $booking->id)->delete();
            BookingRating::where('booking_id', $booking->id)->delete();
            BookingDetails::where('booking_id', $booking->id)->delete();
            BookingPayment::where('booking_id', $booking->id)->delete();

            // Delete the booking
            $booking->delete();
        }

        // Return success response
        return "Deleted";
    }
    public function create_patient(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'h_type' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'nullable|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
        ],[
            'mobile.min' => "Please enter valid contact number.",
            'mobile.numeric' => "Please enter valid contact number.",
            'mobile2.min' => "Please enter valid alternet contact number.",
            'mobile2.numeric' => "Please enter valid alternet contact number.",
            'h_type.required' => "Please select hospital type.",
        ]);

        if($request->h_type == "Other"){
            $request->validate([
                'h_other_type' => 'required'
            ],[
                'h_other_type.required' => "Please select hospital.",
            ]);
        }

        $data = new Patient();
        $data->name = $request->name;
        $data->email = $request->email;
        if($request->h_type == "Other"){
            $data->h_type = $request->h_other_type;
        }else{
            $data->h_type = $request->h_type;
        }
        $data->dob = $request->dob;
        $data->age = $request->age;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->area = $request->area;
        $data->mobile = $request->mobile;
        $data->mobile2 = $request->mobile2;
        $data->reference = $request->reference;
        $data->save();
        return redirect()->back()->with('success','The Patient Added Successfully');
    }
    public function update_patient(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'h_type' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'nullable|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
        ],[
            'mobile.min' => "Please enter valid contact number.",
            'mobile.numeric' => "Please enter valid contact number.",
            'mobile2.min' => "Please enter valid alternet contact number.",
            'mobile2.numeric' => "Please enter valid alternet contact number.",
            'h_type.required' => "Please select hospital type.",
        ]);

        if($request->h_type == "Other"){
            $request->validate([
                'h_other_type' => 'required'
            ],[
                'h_other_type.required' => "Please select hospital.",
            ]);
        }

        $data = Patient::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->email = $request->email;
            if($request->h_type == "Other"){
                $data->h_type = $request->h_other_type;
            }else{
                $data->h_type = $request->h_type;
            }
            $data->dob = $request->dob;
            $data->age = $request->age;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->state = $request->state;
            $data->city = $request->city;
            $data->area = $request->area;
            $data->mobile = $request->mobile;
            $data->mobile2 = $request->mobile2;
            $data->reference = $request->reference;
            $data->update();
            return redirect('patients')->with('success','The Patient Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function staff()
    {
        if (in_array("staff", Auth::user()->permissions())) {
            return view('backend.staff.staff_list');
        }
        abort(403);
    }
    public function get_staff_list()
    {   
        $data = Staff::with('documents')->with('area')->with('types')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $ratings = BookingRating::where('staff_id',$da->id)->with('created_by')->orderBy('id',"DESC")->pluck('rating');
            // Calculate the sum of ratings
            $sumOfRatings = $ratings->sum();
            
            // Calculate the number of ratings
            $numberOfRatings = $ratings->count();
            
            // Calculate the average rating out of 5 if there are ratings available
            $da->rating = $numberOfRatings > 0 ? ($sumOfRatings / $numberOfRatings) : 0;
        }
        return response()->json(['data'=>$data]);
    }
    public function add_staff()
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $staff_type = StaffType::orderBy('title','asc')->get();
            return view('backend.staff.add_staff',['states'=>$states,'staff_type'=>$staff_type]);
        }
        abort(403);
    }
    public function edit_staff($id)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $staff_type = StaffType::orderBy('title','asc')->get();
            $data = Staff::find($id);
            return view('backend.staff.edit_staff',['states'=>$states,'cities'=>$cities,'area'=>$area,'staff_type'=>$staff_type,'data'=>$data]);
        }
        abort(403);
    }
    public function change_staff_status(Request $request)
    {
        $data = Staff::find($request->id);
        if($data->status == 1){
            $data->status = 0;
        }else{
            $data->status = 1;
        }
        $data->update();
        return "Changed";
    }
    public function view_staff_reviews($id)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $staff = Staff::find($id);
            return view('backend.staff.view_staff_reviews',['staff'=>$staff]);
        }
        abort(403);
    }
    public function get_staff_all_reviews_list($id)
    {   
        $data = BookingRating::where('staff_id',$id)->with('created_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $da->booking = Booking::find($da->booking_id);
        }
        return response()->json(['data'=>$data]);
    }
    public function view_staff_details($id)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $staff_type = StaffType::orderBy('title','asc')->get();
            $data = Staff::find($id);
            return view('backend.staff.view_staff',['states'=>$states,'cities'=>$cities,'area'=>$area,'staff_type'=>$staff_type,'data'=>$data]);
        }
        abort(403);
    }
    public function get_staff_salary_slip_data(Request $request)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            // Extract month and year from the request
            $requestMonth = $request->month; // Assuming 'Jul 2024' format
            $startDate = date('Y-m-01', strtotime($requestMonth));
            $endDate = date('Y-m-t', strtotime($requestMonth));
            
            $total = BookingAssign::where('is_cancled',0)->where([
                'staff_id' => $request->staff_id,
                'att_marked' => 1,
                'status' => 1,
                'staff_payment' => 1
            ])->whereBetween('date', [$startDate, $endDate])->pluck('cost_rate')->sum();

            $checkMonth = AdvanceSalary::where(['staff_id'=>$request->staff_id,'month'=>$requestMonth])->first();
            if($request->deduct == "true" && $checkMonth){
                $deduct = $checkMonth->amount;
            }else{
                $deduct = 0;
            }
            $data = [
                'total' => $total,
                'deduct' => $deduct,
            ];

            return $data;
        }
        
        abort(403);
    }
    public function staff_salary_slip($id)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $data = Staff::with('types')->find($id);
            return view('backend.staff.salary_slip',['data'=>$data]);
        }
        abort(403);
    }
    public function change_staff_password($id)
    {
        if (in_array("staff", Auth::user()->permissions())) {
            $data = Staff::with('types')->find($id);
            return view('backend.staff.change_staff_password',['data'=>$data]);
        }
        abort(403);
    }
    public function change_staff_password_post(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ]);

        $data = Staff::find($request->id);
        if($data){
            $data->password = Hash::make($request->password);
            $data->update();
    
            return redirect('staff')->with('success','The Staff Password Updated Successfully');
        }
        return redirect()->back()->with('error','Data Not Found');
    }
    public function delete_staff(Request $request)
    {
        $staff = Staff::find($request->id);
        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        $staff->delete();

        $adSalary = AdvanceSalary::where('staff_id',$request->id)->delete();
        $adSalaryHistory = AdvanceSalaryHistory::where('staff_id',$request->id)->delete();
        $assign = BookingAssign::where('type','!=','Doctor')->where('staff_id', $request->id)->get();
        foreach($assign as $aa){
            $aa->staff_id = NULL;
            $aa->update();
        }
        $rating = BookingRating::where('type','!=','Doctor')->where('staff_id', $request->id)->delete();
        $documents = StaffDocuments::where('staff_id', $request->id)->delete();
        
        return "Deleted";
    }
    public function create_staff(Request $request)
    {
        $request->validate([
            'f_name' => 'required|max:255|alpha',
            'm_name' => 'nullable|max:255|alpha',
            'l_name' => 'nullable|max:255|alpha',
            'type' => 'required',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'nullable|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
            'experience' => 'required|numeric',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ],[
            'f_name.alpha' => "The first name field must only contain letters.",
            'm_name.alpha' => "The middle name field must only contain letters.",
            'l_name.alpha' => "The last name field must only contain letters.",
            'doj.required' => "The date of joining field is required.",
            'f_name.required' => "The first name field is required.",
            'mobile.min' => "Please enter valid contact number.",
            'mobile.numeric' => "The contact number field must be a number.",
            'mobile2.min' => "Please enter valid alternet contact number.",
            'mobile2.numeric' => "The alternet contact number field must be a number.",
            'day_cost.digits_between' => "The amount for cost price is too big.",
            'day_cost.numeric' => "Please enter valid amount.",
            'night_cost.digits_between' => "The amount for cost price is too big.",
            'night_cost.numeric' => "Please enter valid amount.",
            'full_cost.digits_between' => "The amount for cost price is too big.",
            'full_cost.numeric' => "Please enter valid amount.",
        ]);

        $data = new Staff();
        $data->f_name = $request->f_name;
        $data->m_name = $request->m_name;
        $data->l_name = $request->l_name;
        $data->password = Hash::make($request->password);
        $data->type = $request->type;
        $data->email = $request->email;
        $data->dob = $request->dob;
        $data->doj = $request->doj;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->area = $request->area;
        $data->mobile = $request->mobile;
        $data->mobile2 = $request->mobile2;
        $data->age = $request->age;
        $data->experience = $request->experience;
        $data->reference = $request->reference;
        $data->qualification = $request->qualification;
        $data->specification = $request->specification;
        $data->bank_name = $request->bank_name;
        $data->acc_no = $request->acc_no;
        $data->branch = $request->branch;
        $data->ifsc_code = $request->ifsc_code;
        $data->day_cost = $request->day_cost;
        $data->night_cost = $request->night_cost;
        $data->full_cost = $request->full_cost;
        $data->save();

        if($request->documents){
            foreach($request->documents as $key => $document){
                $imageName = time(). '_' . $key . '.' . $document->extension();  
                $document->move(public_path('staff_documents'), $imageName);

                $staff_docs = new StaffDocuments();
                $staff_docs->staff_id = $data->id;
                $staff_docs->name = $imageName;
                $staff_docs->save();
            }
        }

        return redirect('staff')->with('success','The Staff Added Successfully');
    }
    public function update_staff(Request $request)
    {
        $request->validate([
            'f_name' => 'required|max:255|alpha',
            'm_name' => 'nullable|max:255|alpha',
            'l_name' => 'nullable|max:255|alpha',
            'type' => 'required',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'nullable|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
            'experience' => 'required|numeric',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'f_name.alpha' => "The first name field must only contain letters.",
            'm_name.alpha' => "The middle name field must only contain letters.",
            'l_name.alpha' => "The last name field must only contain letters.",
            'doj.required' => "The date of joining field is required.",
            'f_name.required' => "The first name field is required.",
            'mobile.min' => "Please enter valid contact number.",
            'mobile.numeric' => "The contact number field must be a number.",
            'mobile2.min' => "Please enter valid alternet contact number.",
            'mobile2.numeric' => "The alternet contact number field must be a number.",
            'day_cost.digits_between' => "The amount for cost price is too big.",
            'day_cost.numeric' => "Please enter valid amount.",
            'night_cost.digits_between' => "The amount for cost price is too big.",
            'night_cost.numeric' => "Please enter valid amount.",
            'full_cost.digits_between' => "The amount for cost price is too big.",
            'full_cost.numeric' => "Please enter valid amount.",
        ]);

        $data = Staff::find($request->id);
        if($data){
            $data->f_name = $request->f_name;
            $data->m_name = $request->m_name;
            $data->l_name = $request->l_name;
            $data->type = $request->type;
            $data->email = $request->email;
            $data->dob = $request->dob;
            $data->doj = $request->doj;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->state = $request->state;
            $data->city = $request->city;
            $data->area = $request->area;
            $data->mobile = $request->mobile;
            $data->mobile2 = $request->mobile2;
            $data->age = $request->age;
            $data->experience = $request->experience;
            $data->reference = $request->reference;
            $data->qualification = $request->qualification;
            $data->specification = $request->specification;
            $data->bank_name = $request->bank_name;
            $data->acc_no = $request->acc_no;
            $data->branch = $request->branch;
            $data->ifsc_code = $request->ifsc_code;
            $data->day_cost = $request->day_cost;
            $data->night_cost = $request->night_cost;
            $data->full_cost = $request->full_cost;
            $data->update();

            if($request->documents){
                foreach($request->documents as $key => $document){
                    $imageName = time(). '_' . $key . '.' . $document->extension();  
                    $document->move(public_path('staff_documents'), $imageName);
    
                    $staff_docs = new StaffDocuments();
                    $staff_docs->staff_id = $data->id;
                    $staff_docs->name = $imageName;
                    $staff_docs->save();
                }
            }

            return redirect('staff')->with('success','The Staff Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function remove_staff_document(Request $request){
        $staff_docs = StaffDocuments::find($request->id);
        if($staff_docs){
            $staff_docs->delete();
        }
        return "Removed";
    }
    public function corporates()
    {
        if (in_array("corporates", Auth::user()->permissions())) {
            return view('backend.corporates.corporate_list');
        }
        abort(403);
    }
    public function get_corporates_list()
    {   
        $data = Corporate::with('state')->with('city')->with('area')->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_corporate()
    {
        if (in_array("corporates", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            return view('backend.corporates.add_corporate',['states'=>$states]);
        }
        abort(403);
    }
    public function edit_corporate($id)
    {
        if (in_array("corporates", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $data = Corporate::find($id);
            return view('backend.corporates.edit_corporate',['data'=>$data,'states'=>$states,'cities'=>$cities,'area'=>$area]);
        }
        abort(403);
    }
    public function view_corporate_history($id)
    {
        if (in_array("corporates", Auth::user()->permissions())) {
            $data = Patient::find($id);
            return view('backend.corporates.view_corporate_history',['data'=>$data]);
        }
        abort(403);
    }
    public function get_corporate_history_list($id){
        $data = Booking::where(['booking_type'=>'Corporate','customer_id'=>$id])->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function delete_corporate(Request $request)
    {
        $corporate = Corporate::find($request->id);

        // If corporate does not exist, return an error response
        if (!$corporate) {
            return response()->json(['error' => 'Corporate not found'], 404);
        }

        // Delete the corporate
        $corporate->delete();

        // Find all bookings associated with the corporate
        $bookings = Booking::where(['booking_type' => 'Corporate', 'customer_id' => $request->id])->get();

        foreach ($bookings as $booking) {
            // Delete associated records
            BookingAssign::where('booking_id', $booking->id)->delete();
            BookingRating::where('booking_id', $booking->id)->delete();
            BookingDetails::where('booking_id', $booking->id)->delete();
            BookingPayment::where('booking_id', $booking->id)->delete();

            // Delete the booking
            $booking->delete();
        }
        
        return "Deleted";
    }
    public function create_corporate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'area' => 'required',
            'mobile1' => 'required|numeric|min:7',
        ],[
            'mobile1.min' => "Please enter valid contact number.",
            'mobile1.numeric' => "Please enter valid contact number.",
            'mobile1.required' => "The contact number 1 field is required.",
        ]);

        $data = new Corporate();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->state = $request->state;
        $data->area = $request->area;
        $data->mobile1 = $request->mobile1;
        $data->mobile2 = $request->mobile2;
        $data->save();
        return redirect()->back()->with('success','The Corporate Added Successfully');
    }
    public function update_corporate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'area' => 'required',
            'mobile1' => 'required|numeric|min:7',
        ],[
            'mobile1.min' => "Please enter valid contact number.",
            'mobile1.numeric' => "Please enter valid contact number.",
            'mobile1.required' => "The contact number 1 field is required.",
        ]);

        $data = Corporate::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->area = $request->area;
            $data->mobile1 = $request->mobile1;
            $data->mobile2 = $request->mobile2;
            $data->update();
            return redirect('corporates')->with('success','The Corporate Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function doctors()
    {
        if (in_array("doctors", Auth::user()->permissions())) {
            return view('backend.doctors.doctor_list');
        }
        abort(403);
    }
    public function get_doctors_list()
    {   
        $data = Doctor::with('area')->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_doctor()
    {
        if (in_array("doctors", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            return view('backend.doctors.add_doctor',['states'=>$states]);
        }
        abort(403);
    }
    public function edit_doctor($id)
    {
        if (in_array("doctors", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $data = Doctor::find($id);
            return view('backend.doctors.edit_doctor',['states'=>$states,'cities'=>$cities,'area'=>$area,'data'=>$data]);
        }
        abort(403);
    }
    public function change_doctor_status(Request $request)
    {
        $data = Doctor::find($request->id);
        if($data->status == 1){
            $data->status = 0;
        }else{
            $data->status = 1;
        }
        $data->update();
        return "Changed";
    }
    public function view_doctor_details($id)
    {
        if (in_array("doctors", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $area = Area::orderBy('name','asc')->get();
            $data = Doctor::find($id);
            return view('backend.doctors.view_doctor',['states'=>$states,'cities'=>$cities,'area'=>$area,'data'=>$data]);
        }
        abort(403);
    }
    public function delete_doctor(Request $request)
    {
        $doctor = Doctor::find($request->id);

        // If doctor does not exist, return an error response
        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        // Delete the doctor
        $doctor->delete();

        $assign = BookingAssign::where('type','Doctor')->where('staff_id', $request->id)->delete();
        $rating = BookingRating::where('type','Doctor')->where('staff_id', $request->id)->delete();

        return "Deleted";
    }
    public function create_doctor(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'email' => 'nullable|email',
            'gender' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'experience' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'name.required' => "The full name field is required.",
            'mobile.min' => "Please enter valid contact number.",
            'mobile.required' => "The contact number field is required.",
            'mobile.numeric' => "Please enter valid contact number.",
            'day_cost.digits_between' => "The amount for cost price is too big.",
            'day_cost.numeric' => "Please enter valid amount.",
            'night_cost.digits_between' => "The amount for cost price is too big.",
            'night_cost.numeric' => "Please enter valid amount.",
            'full_cost.digits_between' => "The amount for cost price is too big.",
            'full_cost.numeric' => "Please enter valid amount.",
        ]);

        $data = new Doctor();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->dob = $request->dob;
        $data->doj = $request->doj;
        $data->gender = $request->gender;
        $data->address = $request->address;
        $data->state = $request->state;
        $data->city = $request->city;
        $data->area = $request->area;
        $data->mobile = $request->mobile;
        $data->age = $request->age;
        $data->experience = $request->experience;
        $data->reference = $request->reference;
        $data->qualification = $request->qualification;
        $data->specification = $request->specification;
        $data->bank_name = $request->bank_name;
        $data->acc_no = $request->acc_no;
        $data->branch = $request->branch;
        $data->ifsc_code = $request->ifsc_code;
        $data->day_cost = $request->day_cost;
        $data->night_cost = $request->night_cost;
        $data->full_cost = $request->full_cost;
        $data->save();

        return redirect('doctors')->with('success','The Doctor Added Successfully');
    }
    public function update_doctor(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'email' => 'nullable|email',
            'gender' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'experience' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'name.required' => "The full name field is required.",
            'mobile.min' => "Please enter valid contact number.",
            'mobile.required' => "The contact number field is required.",
            'mobile.numeric' => "Please enter valid contact number.",
            'day_cost.digits_between' => "The amount for cost price is too big.",
            'day_cost.numeric' => "Please enter valid amount.",
            'night_cost.digits_between' => "The amount for cost price is too big.",
            'night_cost.numeric' => "Please enter valid amount.",
            'full_cost.digits_between' => "The amount for cost price is too big.",
            'full_cost.numeric' => "Please enter valid amount.",
        ]);

        $data = Doctor::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->email = $request->email;
            $data->dob = $request->dob;
            $data->doj = $request->doj;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->state = $request->state;
            $data->city = $request->city;
            $data->area = $request->area;
            $data->mobile = $request->mobile;
            $data->age = $request->age;
            $data->experience = $request->experience;
            $data->reference = $request->reference;
            $data->qualification = $request->qualification;
            $data->specification = $request->specification;
            $data->bank_name = $request->bank_name;
            $data->acc_no = $request->acc_no;
            $data->branch = $request->branch;
            $data->ifsc_code = $request->ifsc_code;
            $data->day_cost = $request->day_cost;
            $data->night_cost = $request->night_cost;
            $data->full_cost = $request->full_cost;
            $data->update();
            return redirect('doctors')->with('success','The Doctor Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
}

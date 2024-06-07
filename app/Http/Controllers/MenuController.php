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
    public function delete_patient(Request $request)
    {
        $data = Patient::find($request->id)->delete();
        return "Deleted";
    }
    public function create_patient(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'h_type' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
        ],[
            'mobile.min' => "Please enter valid contact number.",
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
            'age' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
        ],[
            'mobile.min' => "Please enter valid contact number.",
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
        $data = Staff::with('area')->with('types')->orderBy('id',"DESC")->get();
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
    public function delete_staff(Request $request)
    {
        $data = Staff::find($request->id)->delete();
        return "Deleted";
    }
    public function create_staff(Request $request)
    {
        $request->validate([
            'f_name' => 'required|max:255',
            'type' => 'required',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
            'experience' => 'required',
            'bank_name' => 'required',
            'acc_no' => 'required',
            'branch' => 'required',
            'ifsc_code' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6'
        ],[
            'f_name.required' => "The first name field is required.",
            'acc_no.required' => "The account number field is required.",
            'mobile.min' => "Please enter valid contact number.",
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

        return redirect('staff')->with('success','The Staff Added Successfully');
    }
    public function update_staff(Request $request)
    {
        $request->validate([
            'f_name' => 'required|max:255',
            'type' => 'required',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'mobile2' => 'nullable|numeric|min:7',
            'experience' => 'required',
            'bank_name' => 'required',
            'acc_no' => 'required',
            'branch' => 'required',
            'ifsc_code' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'f_name.required' => "The first name field is required.",
            'acc_no.required' => "The account number field is required.",
            'mobile.min' => "Please enter valid contact number.",
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
            return redirect('staff')->with('success','The Staff Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
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
        $data = Corporate::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_corporate()
    {
        if (in_array("corporates", Auth::user()->permissions())) {
            return view('backend.corporates.add_corporate');
        }
        abort(403);
    }
    public function edit_corporate($id)
    {
        if (in_array("corporates", Auth::user()->permissions())) {
        $data = Corporate::find($id);
            return view('backend.corporates.edit_corporate',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_corporate(Request $request)
    {
        $data = Corporate::find($request->id)->delete();
        return "Deleted";
    }
    public function create_corporate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'mobile1' => 'required|numeric|min:7',
            'mobile2' => 'required|numeric|min:7',
        ],[
            'mobile1.min' => "Please enter valid contact number.",
            'mobile2.min' => "Please enter valid contact number.",
        ]);

        $data = new Corporate();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->mobile1 = $request->mobile1;
        $data->mobile2 = $request->mobile2;
        $data->save();
        return redirect()->back()->with('success','The Corporate Added Successfully');
    }
    public function update_corporate(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'mobile1' => 'required|numeric|min:7',
            'mobile2' => 'required|numeric|min:7',
        ],[
            'mobile1.min' => "Please enter valid contact number.",
            'mobile2.min' => "Please enter valid contact number.",
        ]);

        $data = Corporate::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->address = $request->address;
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
        $data = Doctor::find($request->id)->delete();
        return "Deleted";
    }
    public function create_doctor(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'experience' => 'required',
            'bank_name' => 'required',
            'acc_no' => 'required',
            'branch' => 'required',
            'ifsc_code' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'acc_no.required' => "The account number field is required.",
            'mobile.min' => "Please enter valid contact number.",
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
            'name' => 'required|max:255',
            'email' => 'nullable|email',
            'doj' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'area' => 'required',
            'mobile' => 'required|numeric|min:7',
            'experience' => 'required',
            'bank_name' => 'required',
            'acc_no' => 'required',
            'branch' => 'required',
            'ifsc_code' => 'required',
            'day_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'night_cost' => 'nullable|numeric|min:0|digits_between:1,12',
            'full_cost' => 'nullable|numeric|min:0|digits_between:1,12',
        ],[
            'acc_no.required' => "The account number field is required.",
            'mobile.min' => "Please enter valid contact number.",
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

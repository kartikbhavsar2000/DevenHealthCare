<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shifts;
use App\Models\Equipment;
use App\Models\Staff;
use App\Models\StaffType;
use App\Models\Ambulance;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Hospital;

class MasterController extends Controller
{
    public function hospitals()
    {
        if (in_array("hospitals", Auth::user()->permissions())) {
            return view('backend.hospitals.hospital_list');
        }
        abort(403);
    }
    public function get_hospitals_list()
    {   
        $data = Hospital::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_hospital()
    {
        if (in_array("hospitals", Auth::user()->permissions())) {
            return view('backend.hospitals.add_hospital');
        }
        abort(403);
    }
    public function edit_hospital($id)
    {
        if (in_array("hospitals", Auth::user()->permissions())) {
            $data = Hospital::find($id);
            return view('backend.hospitals.edit_hospital',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_hospital(Request $request)
    {
        $data = Hospital::find($request->id)->delete();
        return "Deleted";
    }
    public function create_hospital(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'address' => 'required',
            'mobile1' => 'required|numeric|min:7',
            'mobile2' => 'required|numeric|min:7',
        ],[
            'mobile1.required' => "The contact number 1 field is required.",
            'mobile2.required' => "The contact number 2 field is required.",
            'mobile1.numeric' => "Please enter valid contact number 1.",
            'mobile2.numeric' => "Please enter valid contact number 2.",
            'mobile1.min' => "Please enter valid contact number 1.",
            'mobile2.min' => "Please enter valid contact number 2.",
        ]);

        $data = new Hospital();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->mobile1 = $request->mobile1;
        $data->mobile2 = $request->mobile2;
        $data->save();
        return redirect('hospitals')->with('success','The Hospital Added Successfully');
    }
    public function update_hospital(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'address' => 'required',
            'mobile1' => 'required|numeric|min:7',
            'mobile2' => 'required|numeric|min:7',
        ],[
            'mobile1.required' => "The contact number 1 field is required.",
            'mobile2.required' => "The contact number 2 field is required.",
            'mobile1.numeric' => "Please enter valid contact number 1.",
            'mobile2.numeric' => "Please enter valid contact number 2.",
            'mobile1.min' => "Please enter valid contact number 1.",
            'mobile2.min' => "Please enter valid contact number 2.",
        ]);

        $data = Hospital::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->address = $request->address;
            $data->mobile1 = $request->mobile1;
            $data->mobile2 = $request->mobile2;
            $data->update();
            return redirect('hospitals')->with('success','The Hospital Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function shifts()
    {
        if (in_array("shifts", Auth::user()->permissions())) {
            return view('backend.shifts.shift_list');
        }
        abort(403);
    }
    public function get_shifts()
    {
        $data = Shifts::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function edit_shift($id)
    {
        if (in_array("shifts", Auth::user()->permissions())) {
            $shift = Shifts::find($id);
            return view('backend.shifts.edit_shift',['shift' => $shift]);
        }
        abort(403);
    }
    public function update_shift(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $data = Shifts::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->type = $request->type;
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            $data->update();
    
            return redirect()->back()->with('success','The Shift Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function equipments()
    {
        if (in_array("equipments", Auth::user()->permissions())) {
            return view('backend.equipments.equipment_list');
        }
        abort(403);
    }
    public function get_equipments_list()
    {   
        $data = Equipment::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_equipment()
    {
        if (in_array("equipments", Auth::user()->permissions())) {
            return view('backend.equipments.add_equipment');
        }
        abort(403);
    }
    public function edit_equipment($id)
    {
        if (in_array("equipments", Auth::user()->permissions())) {
            $data = Equipment::find($id);
            return view('backend.equipments.edit_equipment',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_equipment(Request $request)
    {
        $data = Equipment::find($request->id)->delete();
        return "Deleted";
    }
    public function create_equipment(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'type' => 'required',
            'cost_price' => 'required|numeric|min:0|digits_between:1,12',
            'sell_price' => 'required|numeric|min:0|digits_between:1,12',
        ],[
            'cost_price.digits_between' => "The amount for cost price is too big.",
            'sell_price.digits_between' => "The amount for sell price is too big.",
            'cost_price.numeric' => "Please enter valid amount.",
            'sell_price.numeric' => "Please enter valid amount."
        ]);

        $data = new Equipment();
        $data->name = $request->name;
        $data->type = $request->type;
        $data->cost_price = $request->cost_price;
        $data->sell_price = $request->sell_price;
        $data->save();
        return redirect('equipments')->with('success','The Equipment Added Successfully');
    }
    public function update_equipment(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'type' => 'required',
            'cost_price' => 'required|numeric|min:0|digits_between:1,12',
            'sell_price' => 'required|numeric|min:0|digits_between:1,12',
        ],[
            'cost_price.digits_between' => "The amount for cost price is too big.",
            'sell_price.digits_between' => "The amount for sell price is too big.",
            'cost_price.numeric' => "Please enter valid amount.",
            'sell_price.numeric' => "Please enter valid amount."
        ]);

        $data = Equipment::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->type = $request->type;
            $data->cost_price = $request->cost_price;
            $data->sell_price = $request->sell_price;
            $data->update();
    
            return redirect()->back()->with('success','The Equipment Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function ambulance()
    {
        if (in_array("ambulance", Auth::user()->permissions())) {
            return view('backend.ambulance.ambulance_list');
        }
        abort(403);
    }
    public function get_ambulance_list()
    {   
        $data = Ambulance::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function edit_ambulance($id)
    {
        if (in_array("ambulance", Auth::user()->permissions())) {
            $data = Ambulance::find($id);
            return view('backend.ambulance.edit_ambulance',['data'=>$data]);
        }
        abort(403);
    }
    public function update_ambulance(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'day_cost' => 'required|numeric|min:0|digits_between:1,12',
            'night_cost' => 'required|numeric|min:0|digits_between:1,12',
            'full_cost' => 'required|numeric|min:0|digits_between:1,12',
        ],[
            'day_cost.digits_between' => "The amount for cost price is too big.",
            'day_cost.numeric' => "Please enter valid amount.",
            'night_cost.digits_between' => "The amount for cost price is too big.",
            'night_cost.numeric' => "Please enter valid amount.",
            'full_cost.digits_between' => "The amount for cost price is too big.",
            'full_cost.numeric' => "Please enter valid amount.",
            'day_cost.required' => "This field is required.",
            'night_cost.required' => "This field is required.",
            'full_cost.required' => "This field is required.",
        ]);

        $data = Ambulance::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->day_cost = $request->day_cost;
            $data->night_cost = $request->night_cost;
            $data->full_cost = $request->full_cost;
            $data->update();
            return redirect('ambulance')->with('success','The Ambulance Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function staff_type()
    {
        if (in_array("staff_type", Auth::user()->permissions())) {
            return view('backend.staff_type.staff_type_list');
        }
        abort(403);
    }
    public function get_staff_type_list()
    {   
        $data = StaffType::orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_staff_type()
    {
        if (in_array("staff_type", Auth::user()->permissions())) {
            return view('backend.staff_type.add_staff_type');
        }
        abort(403);
    }
    public function edit_staff_type($id)
    {
        if (in_array("staff_type", Auth::user()->permissions())) {
            $data = StaffType::find($id);
            return view('backend.staff_type.edit_staff_type',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_staff_type(Request $request)
    {
        $data = StaffType::find($request->id)->delete();
        return "Deleted";
    }
    public function create_staff_type(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|regex:/^([^0-9]*)$/|unique:staff_type,title',
        ]);

        $data = new StaffType();
        $data->title = $request->title;
        $data->save();
        return redirect('staff_type')->with('success','The Staff Type Added Successfully');
    }
    public function update_staff_type(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255|regex:/^([^0-9]*)$/|unique:staff_type,title,'.$request->id,
        ]);

        $data = StaffType::find($request->id);
        if($data){
            $data->title = $request->title;
            $data->update();
            return redirect('staff_type')->with('success','The Staff Type Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function states()
    {
        if (in_array("states", Auth::user()->permissions())) {
            return view('backend.states.state_list');
        }
        abort(403);
    }
    public function get_states_list(Request $request)
    {   
        $data = State::orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function change_state_status(Request $request)
    {
        $data = State::find($request->id);
        if($data->status == 1){
            $data->status = 0;
        }else{
            $data->status = 1;
        }
        $data->update();
        return "Changed";
    }
    public function add_state()
    {
        if (in_array("states", Auth::user()->permissions())) {
            return view('backend.states.add_state');
        }
        abort(403);
    }
    public function edit_state($id)
    {
        if (in_array("states", Auth::user()->permissions())) {
            $data = State::find($id);
            return view('backend.states.edit_state',['data'=>$data]);
        }
        abort(403);
    }
    public function delete_state(Request $request)
    {
        $data = State::find($request->id)->delete();
        return "Deleted";
    }
    public function create_state(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
        ]);

        $find = State::where(['name'=>$request->name])->first();
        if($find){
            return redirect()->back()->with('error','The State Is Already Exist With The Same City');
        }

        $data = new State();
        $data->name = $request->name;
        $data->save();
        return redirect('states')->with('success','The State Added Successfully');
    }
    public function update_state(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
        ]);

        $find = State::where('id','!=',$request->id)->where(['name'=>$request->name])->first();
        if($find){
            return redirect()->back()->with('error','The State Is Already Exist With The Same City');
        }

        $data = State::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->update();
            return redirect('states')->with('success','The State Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function cities()
    {
        if (in_array("cities", Auth::user()->permissions())) {
            return view('backend.cities.city_list');
        }
        abort(403);
    }
    public function get_cities_list(Request $request)
    {   
        $data = City::with('state')->orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function change_city_status(Request $request)
    {
        $data = City::find($request->id);
        if($data->status == 1){
            $data->status = 0;
        }else{
            $data->status = 1;
        }
        $data->update();
        return "Changed";
    }
    public function add_city()
    {
        if (in_array("cities", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            return view('backend.cities.add_city',['states'=>$states]);
        }
        abort(403);
    }
    public function edit_city($id)
    {
        if (in_array("cities", Auth::user()->permissions())) {
            $states = State::where('status',1)->orderBy('name','asc')->get();
            $data = City::find($id);
            return view('backend.cities.edit_city',['states'=>$states,'data'=>$data]);
        }
        abort(403);
    }
    public function delete_city(Request $request)
    {
        $data = City::find($request->id)->delete();
        return "Deleted";
    }
    public function create_city(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'state' => 'required',
        ]);

        $find = City::where(['name'=>$request->name,'state_id'=>$request->state])->first();
        if($find){
            return redirect()->back()->with('error','The City Is Already Exist With The Same City');
        }

        $data = new City();
        $data->name = $request->name;
        $data->state_id = $request->state;
        $data->save();
        return redirect('cities')->with('success','The City Added Successfully');
    }
    public function update_city(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([^0-9]*)$/',
            'state' => 'required',
        ]);

        $find = City::where('id','!=',$request->id)->where(['name'=>$request->name,'state_id'=>$request->state])->first();
        if($find){
            return redirect()->back()->with('error','The City Is Already Exist With The Same City');
        }

        $data = City::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->state_id = $request->state;
            $data->update();
            return redirect('cities')->with('success','The City Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
    public function area()
    {
        if (in_array("area", Auth::user()->permissions())) {
            return view('backend.area.area_list');
        }
        abort(403);
    }
    public function get_area_list(Request $request)
    {   
        $data = Area::with('city')->orderBy('name',"asc")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_area()
    {
        if (in_array("area", Auth::user()->permissions())) {
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            return view('backend.area.add_area',['cities'=>$cities]);
        }
        abort(403);
    }
    public function edit_area($id)
    {
        if (in_array("area", Auth::user()->permissions())) {
            $cities = City::where('status',1)->orderBy('name','asc')->get();
            $data = Area::find($id);
            return view('backend.area.edit_area',['cities'=>$cities,'data'=>$data]);
        }
        abort(403);
    }
    public function delete_area(Request $request)
    {
        $data = Area::find($request->id)->delete();
        return "Deleted";
    }
    public function create_area(Request $request)
    {
        $request->validate([
            'city' => 'required',
        ]);

        $allNull = true;
        
        foreach($request->name as $name){
            $find = Area::where(['name'=>$name,'city_id'=>$request->city])->first();
            if($find){
                return redirect()->back()->with('error','The Area Is Already Exist With The Same City');
            }
            if (!empty($name)) {
                $data = new Area();
                $data->name = $name;
                $data->city_id = $request->city;
                $data->save();

                $allNull = false;
            }
        }

        if ($allNull) {
            return redirect()->back()->with('error', 'The area name is required');
        }

        return redirect('area')->with('success','The Area Added Successfully');
    }
    public function update_area(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'city' => 'required',
        ]);

        $find = Area::where('id','!=',$request->id)->where(['name'=>$request->name,'city_id'=>$request->city])->first();
        if($find){
            return redirect()->back()->with('error','The Area Is Already Exist With The Same City');
        }

        $data = Area::find($request->id);
        if($data){
            $data->name = $request->name;
            $data->city_id = $request->city;
            $data->update();
            return redirect('area')->with('success','The Area Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
}

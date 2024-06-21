<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use App\Models\Staff;

class PaymentController extends Controller
{
    public function advance_salary()
    {
        if (in_array("advance_salary", Auth::user()->permissions())) {
            return view('backend.advance_salary.advance_salary_list');
        }
        abort(403);
    }
    public function get_advance_salary_list()
    {   
        $data = AdvanceSalary::with('staff')->orderBy('id',"DESC")->get();
        return response()->json(['data'=>$data]);
    }
    public function add_advance_salary()
    {
        if (in_array("advance_salary", Auth::user()->permissions())) {
            $staff = Staff::orderBy('f_name',"ASC")->get();
            return view('backend.advance_salary.add_advance_salary',['staff'=>$staff]);
        }
        abort(403);
    }
    public function edit_advance_salary($id)
    {
        if (in_array("advance_salary", Auth::user()->permissions())) {
            $data = AdvanceSalary::find($id);
            $staff = Staff::orderBy('f_name',"ASC")->get();
            return view('backend.advance_salary.edit_advance_salary',['staff'=>$staff,'data'=>$data]);
        }
        abort(403);
    }
    public function create_advance_salary(Request $request)
    {
        // return $request;
        $request->validate([
            'staff_id' => 'required',
            'amount' => 'required|numeric|min:0|digits_between:1,12',
            'description' => 'required',
        ]);

        $data = new AdvanceSalary();
        $data->staff_id = $request->staff_id;
        $data->amount = $request->amount;
        $data->description = $request->description;
        $data->save();
        return redirect('advance_salary')->with('success','The Advance Salary Added Successfully');
    }
    public function update_advance_salary(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'amount' => 'required|numeric|min:0|digits_between:1,12',
            'description' => 'required',
        ]);

        $data = AdvanceSalary::find($request->id);
        if($data){
            $data->staff_id = $request->staff_id;
            $data->amount = $request->amount;
            $data->description = $request->description;
            $data->update();
            return redirect('advance_salary')->with('success','The Advance Salary Updated Successfully');
        }else{
            return redirect()->back()->with('error','Data Not Found');
        }
    }
}

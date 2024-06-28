<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\BookingAssign;
use App\Models\Shifts;
use App\Models\Booking;

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
        $data = AdvanceSalary::with('staff')->with('created_by_user')->with('updated_by_user')->orderBy('id',"DESC")->get();
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
    public function advance_salary_change_status(Request $request)
    {
        if (in_array("advance_salary", Auth::user()->permissions())) {
            $data = AdvanceSalary::find($request->id);
            if($data){
                $data->status = 1;
                $data->updated_by = Auth::user()->id;
                $data->update();
            }
            return "Done";
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
        $data->added_by = Auth::user()->id;
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
    public function salary()
    {
        if (in_array("salary", Auth::user()->permissions())) {
            $staff = Staff::orderBy('f_name',"ASC")->get();
            return view('backend.salary.salary',['staff'=>$staff]);
        }
        abort(403);
    }
    public function get_staff_doctor_list(Request $request){

        if($request->type == "Doctor"){
            $data = Doctor::orderBy('name','ASC')->get();
            foreach($data as $da){
                $da->staff_name = $da->name;
                $da->unique_id = $da->doctor_id;
            }
        }else{
            $data = Staff::orderBy('f_name','ASC')->get();
            foreach($data as $da){
                $da->staff_name = $da->f_name . " " . $da->m_name . " " . $da->l_name;
                $da->unique_id = $da->staff_id;
            }
        }
        return $data;
    }
    // public function get_staff_doctor_salary_details(Request $request) {
    //     $data = [];
    
    //     foreach ($request->weeks as $week) {
    //         // Decode the JSON string for each week
    //         $weekData = json_decode($week, true);
    //         $startDate = $weekData['startDate'];
    //         $endDate = $weekData['endDate'];
    
    //         if ($request->type == "Doctor") {
    //             $doctor = Doctor::find($request->staff_id);
    //             if ($doctor) {
    //                 $booking_assign = BookingAssign::where(['type' => $request->type, 'staff_id' => $doctor->id])->whereBetween('date', [$startDate, $endDate])->get();
    //                 foreach($booking_assign as $ba){
    //                     $booking_id = Booking::find($ba->booking_id);
    //                     $shift_name = Shifts::find($ba->shift);
    //                     if($booking_id){
    //                         $ba->booking_unique_id = $booking_id->unique_id;
    //                     }
    //                     if($shift_name){
    //                         $ba->shift_name = $shift_name->name;
    //                     }
    //                 }
    //                 if (!$booking_assign->isEmpty()) {
    //                     $data = array_merge($data, $booking_assign->toArray());
    //                 }
    //             }
    //         } else {
    //             $staff = Staff::find($request->staff_id);
    //             if ($staff) {
    //                 $booking_assign = BookingAssign::where('staff_id', $staff->id)->whereBetween('date', [$startDate, $endDate])->get();
    //                 foreach($booking_assign as $ba){
    //                     $booking_id = Booking::find($ba->booking_id);
    //                     $shift_name = Shifts::find($ba->shift);
    //                     if($booking_id){
    //                         $ba->booking_unique_id = $booking_id->unique_id;
    //                     }
    //                     if($shift_name){
    //                         $ba->shift_name = $shift_name->name;
    //                     }
    //                 }
    //                 if (!$booking_assign->isEmpty()) {
    //                     $data = array_merge($data, $booking_assign->toArray());
    //                 }
    //             }
    //         }
    //     }
    
    //     return response()->json($data);
    // }
    public function get_staff_doctor_salary_details(Request $request) {
        $data = [];
    
        foreach ($request->staff_id as $st_id) {
            $staff = Staff::find($st_id);
            if ($staff) {
                $staff->staff_name = $staff->f_name . " " . $staff->m_name . " " . $staff->l_name;
                $total_assign = 0;
                $absent_count = 0;
                $pending_count = 0;
                $approved_count = 0;
                $rejected_count = 0;
                $staff_paid_count = 0;
                $staff_unpaid_count = 0;
                $total_salary = 0;
    
                foreach ($request->weeks as $week) {
                    // Decode the JSON string for each week
                    $weekData = json_decode($week, true);
                    $startDate = $weekData['startDate'];
                    $endDate = $weekData['endDate'];
    
                    $booking_assign = BookingAssign::where(['staff_id' => $staff->id])->whereBetween('date', [$startDate, $endDate])->get();
                    $total_assign += count($booking_assign);
    
                    foreach ($booking_assign as $ba) {
                        if ($ba->att_marked == 0) {
                            $absent_count++;
                        } elseif ($ba->att_marked == 1) {
                            if ($ba->status == 0) {
                                $pending_count++;
                            } elseif ($ba->status == 1) {
                                $approved_count++;
                                if($ba->staff_payment == 0){
                                    $staff_unpaid_count++;
                                    $total_salary += (int)$ba->cost_rate;
                                }else{
                                    $staff_paid_count++;
                                }
                            } elseif ($ba->status == 2) {
                                $rejected_count++;
                            }
                        }
                    }
                }
    
                $staff_data = [
                    'staff' => $staff,
                    'total_assign' => $total_assign,
                    'absent_count' => $absent_count,
                    'pending_count' => $pending_count,
                    'approved_count' => $approved_count,
                    'rejected_count' => $rejected_count,
                    'staff_unpaid_count' => $staff_unpaid_count,
                    'staff_paid_count' => $staff_paid_count,
                    'total_salary' => $total_salary,
                ];
    
                $data[] = $staff_data;
            }
        }
    
        return response()->json($data);
    }
    public function staff_salary_pay(Request $request) {
        foreach ($request->staff_id as $st_id) {
            $staff = Staff::find($st_id);
            if ($staff) {
    
                foreach ($request->weeks as $week) {
                    // Decode the JSON string for each week
                    $weekData = json_decode($week, true);
                    $startDate = $weekData['startDate'];
                    $endDate = $weekData['endDate'];
    
                    $booking_assign = BookingAssign::where(['staff_id' => $staff->id, 'att_marked' => 1, 'status' => 1, 'staff_payment' => 0])->whereBetween('date', [$startDate, $endDate])->get();
    
                    foreach ($booking_assign as $ba) {
                        $ba->staff_payment = 1;
                        $ba->update();
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Payment completed successfully.');
    }
    
}

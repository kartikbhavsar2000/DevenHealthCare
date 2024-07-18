<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary;
use App\Models\AdvanceSalaryHistory;
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
    public function advance_salary_history($id)
    {
        if (in_array("advance_salary", Auth::user()->permissions())) {
            $data = AdvanceSalaryHistory::where('adv_id',$id)->with('staff')->with('created_by_user')->get();
            return view('backend.advance_salary.advance_salary_history',['data'=>$data]);
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
            'month' => 'required',
            'staff_id' => 'required',
            'amount' => 'required|numeric|min:0|digits_between:1,12',
        ]);

        $checkMonth = AdvanceSalary::where(['staff_id'=>$request->staff_id,'month'=>$request->month])->first();
        if($checkMonth){
            $checkMonth->amount = $request->amount + $checkMonth->amount;
            $checkMonth->updated_by = Auth::user()->id;
            $checkMonth->update();

            $ad_Data = new AdvanceSalaryHistory();
            $ad_Data->adv_id = $checkMonth->id;
            $ad_Data->staff_id = $request->staff_id;
            $ad_Data->month = $request->month;
            $ad_Data->amount = $request->amount;
            $ad_Data->added_by = Auth::user()->id;
            if($request->description){
                $ad_Data->description = $request->description;
            }
            $ad_Data->type = 1;
            $ad_Data->is_salary = 0;
            $ad_Data->save();

        }else{
            $data = new AdvanceSalary();
            $data->staff_id = $request->staff_id;
            $data->month = $request->month;
            $data->amount = $request->amount;
            if($request->description){
                $data->description = $request->description;
            }
            $data->added_by = Auth::user()->id;
            $data->save();

            $ad_Data = new AdvanceSalaryHistory();
            $ad_Data->adv_id = $data->id;
            $ad_Data->staff_id = $request->staff_id;
            $ad_Data->month = $request->month;
            $ad_Data->amount = $request->amount;
            $ad_Data->added_by = Auth::user()->id;
            if($request->description){
                $ad_Data->description = $request->description;
            }
            $ad_Data->type = 1;
            $ad_Data->is_salary = 0;
            $ad_Data->save();
        }
        
        return redirect('advance_salary')->with('success','The Advance Salary Added Successfully');
    }
    public function update_advance_salary(Request $request)
    {
        $request->validate([
            'pay_amount' => 'required|numeric|min:0|digits_between:1,12',
        ]);

        $data = AdvanceSalary::find($request->id);
        if($data){
            $amount = $data->amount - $request->pay_amount;
            $data->amount = $amount;
            $data->updated_by = Auth::user()->id;
            $data->update();

            $ad_Data = new AdvanceSalaryHistory();
            $ad_Data->adv_id = $data->id;
            $ad_Data->staff_id = $data->staff_id;
            $ad_Data->month = $data->month;
            $ad_Data->amount = $request->pay_amount;
            $ad_Data->added_by = Auth::user()->id;
            if($request->description){
                $ad_Data->description = $request->description;
            }
            $ad_Data->type = 0;
            $ad_Data->is_salary = 0;
            $ad_Data->save();

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
                    $startDate = date('Y-m-d',strtotime($weekData['startDate']));
                    $endDate = date('Y-m-d',strtotime($weekData['endDate']));
                    // $startDate = $weekData['startDate'];
                    // $endDate = $weekData['endDate'];
    
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

                $inputMonth = $request->month;

                list($month, $year) = explode('-', $inputMonth);

                $monthName = date('M', mktime(0, 0, 0, $month, 1));

                $month = $monthName . ' ' . $year;

                $checkMonth = AdvanceSalary::where(['staff_id'=>$staff->id,'month'=>$month])->first();
                if($checkMonth){
                    $advance_salary = $checkMonth->amount;
                }else{
                    $advance_salary = 0;
                }

                // if ($total_salary <= $advance_salary) {
                //     $main_total = 0;
                //     $remaining_advance_salary = $advance_salary - $total_salary;
                // } else {
                //     $main_total = $total_salary - $advance_salary;
                //     $remaining_advance_salary = 0;
                // }

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
                    'advance_salary' => $advance_salary,
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
                $total_salary = 0;
                foreach ($request->weeks as $week) {
                    // Decode the JSON string for each week
                    $weekData = json_decode($week, true);
                    $startDate = date('Y-m-d',strtotime($weekData['startDate']));
                    $endDate = date('Y-m-d',strtotime($weekData['endDate']));
                    // $startDate = $weekData['startDate'];
                    // $endDate = $weekData['endDate'];
    
                    $booking_assign = BookingAssign::where(['staff_id' => $staff->id, 'att_marked' => 1, 'status' => 1, 'staff_payment' => 0])->whereBetween('date', [$startDate, $endDate])->get();
    
                    foreach ($booking_assign as $ba) {
                        $ba->staff_payment = 1;
                        $ba->update();

                        $total_salary += (int)$ba->cost_rate;
                    }
                }

                $inputMonth = $request->month;

                list($month, $year) = explode('-', $inputMonth);

                $monthName = date('M', mktime(0, 0, 0, $month, 1));

                $nextMonthName = date('M', mktime(0, 0, 0, $month + 1, 1));

                $month = $monthName . ' ' . $year;

                $nextMonth = $nextMonthName . ' ' . $year;
               
                $checkMonth = AdvanceSalary::where(['staff_id'=>$staff->id,'month'=>$month])->first();
                if($checkMonth){
                    $advance_salary = $checkMonth->amount;

                    if ($total_salary <= $advance_salary) {
                        $main_total = 0;
                        $remaining_advance_salary = $advance_salary - $total_salary;

                        $checkMonth->amount = 0;
                        $checkMonth->updated_by = Auth::user()->id;
                        $checkMonth->update();

                        $ad_Data = new AdvanceSalaryHistory();
                        $ad_Data->adv_id = $checkMonth->id;
                        $ad_Data->staff_id = $checkMonth->staff_id;
                        $ad_Data->month = $checkMonth->month;
                        $ad_Data->amount = $total_salary;
                        $ad_Data->added_by = Auth::user()->id;
                        $ad_Data->description = "Deducted from the salary.";
                        $ad_Data->type = 0;
                        $ad_Data->is_salary = 1;
                        $ad_Data->save();

                        $data = new AdvanceSalary();
                        $data->staff_id = $staff->id;
                        $data->month = $nextMonth;
                        $data->amount = $remaining_advance_salary;
                        $data->description = "Carryover from the previous month.";
                        $data->added_by = Auth::user()->id;
                        $data->save();

                        $ad_Data = new AdvanceSalaryHistory();
                        $ad_Data->adv_id = $data->id;
                        $ad_Data->staff_id = $data->staff_id;
                        $ad_Data->month = $data->month;
                        $ad_Data->amount = $data->amount;
                        $ad_Data->added_by = Auth::user()->id;
                        $ad_Data->description = "Carryover from the previous month.";
                        $ad_Data->type = 1;
                        $ad_Data->is_salary = 0;
                        $ad_Data->save();

                    } else {
                        $checkMonth->amount = 0;
                        $checkMonth->updated_by = Auth::user()->id;
                        $checkMonth->update();

                        $ad_Data = new AdvanceSalaryHistory();
                        $ad_Data->adv_id = $checkMonth->id;
                        $ad_Data->staff_id = $checkMonth->staff_id;
                        $ad_Data->month = $checkMonth->month;
                        $ad_Data->amount = $advance_salary;
                        $ad_Data->added_by = Auth::user()->id;
                        $ad_Data->description = "Deducted from the salary.";
                        $ad_Data->type = 0;
                        $ad_Data->is_salary = 1;
                        $ad_Data->save();
                    }
                }

                
            }
        }
        return redirect('staff_salary_report')->with('success', 'Payment completed successfully.');
    }
    
}

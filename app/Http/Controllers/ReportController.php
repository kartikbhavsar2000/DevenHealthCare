<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingAssign;
use App\Models\Staff;
use App\Models\AdvanceSalary;
use App\Models\AdvanceSalaryHistory;
use App\Models\Booking;

class ReportController extends Controller
{
    public function staff_salary_report(){
        if (in_array("staff_salary_report", Auth::user()->permissions())) {
            return view('backend.reports.staff_salary_report');
        }
        abort(403);
    }
    public function get_staff_salary_report_data(Request $request){
        if (in_array("staff_salary_report", Auth::user()->permissions())) {
            // Extract month and year from the request
            $requestMonth = $request->month; // Assuming 'Jul 2024' format
            $startDate = date('Y-m-01', strtotime($requestMonth));
            $endDate = date('Y-m-t', strtotime($requestMonth));

            $staff = Staff::all();
            $data = [];
            foreach($staff as $st){
                $st->staff_name = $st->f_name . " " . $st->m_name . " " . $st->l_name;
                $total = BookingAssign::where([
                    'staff_id' => $st->id,
                    'att_marked' => 1,
                    'status' => 1,
                    'staff_payment' => 1
                ])->whereBetween('date', [$startDate, $endDate])->pluck('cost_rate')->sum();
                $total_days = BookingAssign::where([
                    'staff_id' => $st->id,
                    'att_marked' => 1,
                    'status' => 1,
                    'staff_payment' => 1
                ])->whereBetween('date', [$startDate, $endDate])->count();
                $checkMonth = AdvanceSalary::where(['staff_id'=>$st->id,'month'=>$requestMonth])->first();
                $checkMonthSum = AdvanceSalaryHistory::where(['staff_id'=>$st->id,'month'=>$requestMonth,'type'=>0,'is_salary'=>1])->sum('amount');
                if($checkMonth){
                    $deduct = $checkMonth->amount;
                }else{
                    $deduct = 0;
                }
                $data[] = [
                    'staff' => $st,
                    'total' => $total,
                    'deduct' => $checkMonthSum,
                    'month' => $requestMonth,
                    'days' => $total_days,
                ];
            }

            return $data;
        }
        
        abort(403);
    }
    public function paused_booking_report(){
        if (in_array("paused_booking_report", Auth::user()->permissions())) {
            return view('backend.reports.paused_booking_report');
        }
        abort(403);
    }
    public function get_paused_booking_report_data(Request $request){
        if (in_array("paused_booking_report", Auth::user()->permissions())) {
            $data = Booking::where('booking_status',2)->with('added_by')->orderBy('id',"DESC")->get();
            foreach($data as $da){
                $customer_details = $da->customerDetails();
                $da->customer_details = $customer_details;
            }
            return $data;
        }
        abort(403);
    }
    
}

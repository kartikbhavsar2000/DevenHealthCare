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
use App\Models\StaffType;
use DB;

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

            $staff = Staff::with('types')->get();
            $data = [];
            foreach($staff as $st){
                $st->staff_name = $st->f_name . " " . $st->m_name . " " . $st->l_name;
                $total = BookingAssign::where('is_cancled',0)->where([
                    'staff_id' => $st->id,
                    'att_marked' => 1,
                    'status' => 1,
                    'staff_payment' => 1
                ])->whereBetween('date', [$startDate, $endDate])->pluck('cost_rate')->sum();
                $total_days = BookingAssign::where('is_cancled',0)->where([
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
            // $data = Booking::where('booking_status',2)->with('added_by')->orderBy('id',"DESC")->get();
            $data = Booking::whereNotNull('pause_reason')->with('added_by')->orderBy('id',"DESC")->get();
            $allData = [];
            foreach($data as $da){
                $customer_details = $da->customerDetails();
                $da->customer_details = $customer_details;

                if(Auth::user()->type == "CRP"){
                    if($da->booking_type == "Corporate"){
                        $allData[] = $da;
                    }
                }elseif(Auth::user()->type == "HSP"){
                    if($da->booking_type != "Corporate" && $customer_details->h_type != "DHC"){
                        $allData[] = $da;
                    }
                }elseif(Auth::user()->type == "DHC"){
                    if($da->booking_type != "Corporate" && $customer_details->h_type == "DHC"){
                        $allData[] = $da;
                    }
                }else{
                    $allData[] = $da;
                }
            }
            return $allData;
        }
        abort(403);
    }
    public function started_booking_report(){
        if (in_array("started_booking_report", Auth::user()->permissions())) {
            $staff_type = StaffType::get();
            return view('backend.reports.started_booking_report',['staff_type'=>$staff_type]);
        }
        abort(403);
    }
    public function get_started_booking_report_data(Request $request) {
        if (in_array("started_booking_report", Auth::user()->permissions())) {
            $category = $request->category;
            $services = $request->services;
            $status = $request->status;
            $type = $request->type;
            $dateRange = $request->date_range;
    
            $dates = explode(' - ', $dateRange);
    
            $startDate = date('Y-m-d', strtotime(str_replace('/', '-', $dates[0])));
            $endDate = date('Y-m-d', strtotime(str_replace('/', '-', $dates[1])));
    
            $data = DB::table('booking_assign')
                ->join('bookings', 'booking_assign.booking_id', '=', 'bookings.id')
                ->join('patient', 'bookings.customer_id', '=', 'patient.id')
                ->join('staff', 'booking_assign.staff_id', '=', 'staff.id')
                ->leftJoin('corporate', function($join) {
                    $join->on('bookings.customer_id', '=', 'corporate.id')
                         ->where('bookings.booking_type', 'Corporate');
                })
                ->where('booking_assign.type', '!=', 'Doctor')
                ->whereNull('patient.deleted_at')
                ->whereNull('booking_assign.deleted_at')
                ->whereNull('bookings.deleted_at');
    
            if ($status == "1") {
                $data->where('booking_assign.is_cancled', "0")->where('bookings.booking_status', "0");
            }
            if ($status == "2") {
                $data->where('booking_assign.is_cancled', "0")->where('bookings.booking_status', "1");
            }
            if ($status == "3") {
                $data->where('booking_assign.is_cancled', "0")->where('bookings.booking_status', "2");
            }
            if ($status == "4") {
                $data->where('booking_assign.is_cancled', "1");
            }
    
            if ($category) {
                if ($category == "DHC") {
                    $data->where('bookings.booking_type', '!=', 'Corporate')
                         ->where('patient.h_type', 'DHC');
                }
                if ($category == "HSP") {
                    $data->where('bookings.booking_type', '!=', 'Corporate')
                         ->where('patient.h_type', '!=', 'DHC');
                }
                if ($category == "CRP") {
                    $data->where('bookings.booking_type', 'Corporate');
                }
            }
    
            if ($services) {
                $staff_type = StaffType::find($services);
                $data->where('booking_assign.type', $staff_type->title);
            }
    
            if ($type) {
                if ($type == 12) {
                    $data->whereIn('booking_assign.shift', [1, 2]);
                } else {
                    $data->where('booking_assign.shift', 3);
                }
            }
    
            if ($startDate && $endDate) {
                $data->whereBetween('booking_assign.date', [$startDate, $endDate]);
            }
    
            $all_data = $data->select(
                'bookings.booking_status',
                'bookings.booking_type',
                'booking_assign.shift',
                'bookings.unique_id',
                'staff.f_name',
                'staff.m_name',
                'staff.l_name',
                DB::raw('CASE 
                            WHEN bookings.booking_type = "Corporate" THEN corporate.name 
                            ELSE patient.name 
                         END as customer_name'),
                DB::raw('CASE 
                            WHEN bookings.booking_type = "Corporate" THEN "-" 
                            ELSE patient.h_type 
                         END as h_type'),
                'booking_assign.type',
                'booking_assign.date',
                'booking_assign.sell_rate',
                'booking_assign.is_cancled'
            )->get();

            $allData = [];

            foreach($all_data as $da){
                if(Auth::user()->type == "CRP"){
                    if($da->booking_type == "Corporate"){
                        $allData[] = $da;
                    }
                }elseif(Auth::user()->type == "HSP"){
                    if($da->booking_type != "Corporate" && $da->h_type != "DHC"){
                        $allData[] = $da;
                    }
                }elseif(Auth::user()->type == "DHC"){
                    if($da->booking_type != "Corporate" && $da->h_type == "DHC"){
                        $allData[] = $da;
                    }
                }else{
                    $allData[] = $da;
                }
            }
    
            return response()->json($allData);
        }
        abort(403);
    }
    
}

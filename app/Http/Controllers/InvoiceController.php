<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\Booking;
use App\Models\BookingDetails;
use App\Models\BookingAssign;
use App\Models\Shifts;
use App\Models\BookingPayment;

class InvoiceController extends Controller
{
    public function active_invoice()
    {
        if (in_array("active_invoice", Auth::user()->permissions())) {
            return view('backend.invoice.active_invoice_list');
        }
        abort(403);
    }
    public function get_active_invoice_list()
    {   
        $data = Booking::where('booking_status',0)->with('added_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
        }
        return response()->json(['data'=>$data]);
    }
    public function closed_invoice()
    {
        if (in_array("closed_invoice", Auth::user()->permissions())) {
            return view('backend.invoice.closed_invoice_list');
        }
        abort(403);
    }
    public function generate_invoice($id)
    {
        if (in_array("active_invoice", Auth::user()->permissions())) {
            $booking = Booking::with('bookingDetails')->find($id);
            $booking->customer_details = $booking->customerDetails();
            $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
            $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
            $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

            foreach($booking->bookingDetails as $detail) {
                $shift = Shifts::find($detail->shift);
                $detail->shift_name = $shift ? " (".$shift->name.")" : "";
            }

            $payments = BookingPayment::where(['booking_id'=>$booking->id])->with('created_by')->get();
            return view('backend.invoice.generate_invoice',['booking' => $booking,'payments'=>$payments]);
        }
        abort(403);
    }
    public function get_closed_invoice_list()
    {   
        $data = Booking::where('booking_status',1)->with('closed_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
        }
        return response()->json(['data'=>$data]);
    }
    public function close_booking(Request $request)
    {   
        $data = Booking::find($request->id);
        if($data){
            $data->booking_status = 1;
            $data->closed_by = Auth::user()->id;
            $data->update();
        }
        return "Closed";
    }
    public function invoice_details_by_dates(Request $request)
    {
        $booking = Booking::with('BookingDetails')->find($request->id);
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $all_dates = [];
        $current_date = strtotime($startDate);
        $end_timestamp = strtotime($endDate);

        while ($current_date <= $end_timestamp) {
            $all_dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 day', $current_date);
        }

        $data = [];

        foreach($booking->BookingDetails as $details){
            $price = $details->sell_rate;
            $shift = Shifts::find($details->shift);
            if($shift){
                $description = "<b>".$details->name."</b><br><span style='font-size:12px;'>(".$shift->name.")</span>";
            }else{
                $description = "<b>".$details->name."</b>";
            }

            if($details->type == 1){
                $qnt = count($all_dates);
            }else{
                $qnt = $details->qnt;
            }
            if($details->type == 2){
                $total = (int)$price;
            }else{
                $total = $price * $qnt;
            }
            
            if($details->type != 2 && $details->type != 3 && $details->type != 4){
                $data[] = [
                    'description' => $description,
                    'price' => $price,
                    'qnt' => $qnt,
                    'total' => $total,
                ];
            }elseif($details->type == 2 || $details->type == 4){
                if($booking->end_date == $request->endDate){
                    $data[] = [
                        'description' => $description,
                        'price' => $price,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
                }else{
                    
                }
            }
        }
        if ($startDate && $endDate) {
            $booking_assign = BookingAssign::when($startDate && $startDate === $endDate, function ($query) use ($startDate) {
                    return $query->whereDate('date', $startDate);
                }, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('date', [$startDate, $endDate]);
                })->where(['booking_id' => $booking->id,'type'=>'Doctor'])->get();

            foreach($booking_assign as $doctor){
                $price = (int)$doctor->sell_rate;
                $shift = Shifts::find($doctor->shift);
                if($shift){
                    $description = "<b>".$doctor->type."</b><br><span style='font-size:12px;'>".date('d/m/Y',strtotime($doctor->date))."(".$shift->name.")</span>";
                }else{
                    $description = "<b>".$doctor->type."</b>";
                }
                $data[] = [
                    'description' => $description,
                    'price' => $price,
                    'qnt' => 1,
                    'total' => $price,
                ];
            }
        } 

        return($data);
    }
    public function add_booking_payment(Request $request){
        $booking = Booking::find($request->id);
        if($booking){
            $payment = new BookingPayment();
            $payment->booking_id = $booking->id;
            $payment->amount = $request->amount;
            $payment->date = $request->date;
            $payment->start_date = $request->start_date;
            $payment->end_date = $request->end_date;
            $payment->added_by = Auth::user()->id;
            $payment->save();

            $pending_payment = $booking->pending_payment - $request->amount;
            $booking->pending_payment = $pending_payment;
            $booking->update();

            return redirect()->back()->with('success',"Payment Added.");
        }else{
            return redirect()->back()->with('error',"Data Not Found.");
        }
    }
}

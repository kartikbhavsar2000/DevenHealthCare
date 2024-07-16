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
use Mail;
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
        $data = Booking::whereIn('booking_status',[0,2])->with('added_by')->orderBy('id',"DESC")->get();
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
                $detail->shift_name = $shift ? $shift->name : "-";
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
            $payments = BookingPayment::where(['booking_id'=>$data->id])->get();
            if ($payments->isEmpty() && $data->total > 0) {
                return "Error";
            }else{
                $assign_data = BookingAssign::where('booking_id',$data->id)->get();
                foreach($assign_data as $ad){
                    $ad->booking_status = 1;
                    $ad->update();
                }
                $data->booking_status = 1;
                $data->closed_by = Auth::user()->id;
                $data->update();
            }
        }
        return "Closed";
    }
    public function invoice_details_by_dates(Request $request)
    {
        $booking = Booking::with('BookingDetails')->find($request->id);
        $enddate = strtotime($request->endDate);
        $startDate = $request->startDate;
        $endDate = date('Y-m-d', $enddate);
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
                if($startDate && $endDate){
                    $staff_assign_count = BookingAssign::when($startDate && $startDate === $endDate, function ($query) use ($startDate) {
                        return $query->whereDate('date', $startDate);
                    }, function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween('date', [$startDate, $endDate]);
                    })->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->count();

                    $total_price = BookingAssign::when($startDate && $startDate === $endDate, function ($query) use ($startDate) {
                        return $query->whereDate('date', $startDate);
                    }, function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween('date', [$startDate, $endDate]);
                    })->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->sum('sell_rate');

                    $qnt = $staff_assign_count;
                    $total = $total_price;
                }else{
                    $qnt = count($all_dates);
                    $total = $price * $qnt;
                }
            }elseif($details->type == 2){
                $qnt = $details->qnt;
                $total = (int)$price;
            }else{
                $qnt = $details->qnt;
                $total = $price * $qnt;
            }

            if($details->type == 1){
                if($total > 0){
                    $data[] = [
                        'description' => $description,
                        'price' => $price,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
                }
            }elseif($details->type == 2){
                if($booking->start_date == $request->startDate && $booking->end_date == $request->endDate){
                    $data[] = [
                        'description' => $description,
                        'price' => $details->cost_rate,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
                }
            }elseif($details->type == 4){
                if($booking->start_date == $request->startDate && $booking->end_date == $request->endDate){
                    $data[] = [
                        'description' => $description,
                        'price' => $price,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
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
                if($price > 0){
                    $data[] = [
                        'description' => $description,
                        'price' => $price,
                        'qnt' => 1,
                        'total' => $price,
                    ];
                }
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
    // public function send_invoice_in_mail(Request $request)
    // {
    //     $request->validate([
    //         'pdf' => 'required|file|mimes:pdf',
    //     ]);

    //     $pdf = $request->file('pdf');
    //     $pdfPath = $pdf->getRealPath();
    //     $pdfName = $pdf->getClientOriginalName();

    //     $to = 'kartik.budtech@gmail.com';
    //     $subject = 'Your PDF';
    //     $message = 'See attached document.';

    //     $separator = md5(time());
    //     $eol = PHP_EOL;
    //     $filename = $pdfName;
    //     $attachment = chunk_split(base64_encode(file_get_contents($pdfPath)));

    //     // Main headers
    //     $headers = "From: kartikbhavsar1757@gmail.com" . $eol;
    //     $headers .= "MIME-Version: 1.0" . $eol;
    //     $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol . $eol;
    //     $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    //     $headers .= "This is a MIME encoded message." . $eol . $eol;

    //     // Message
    //     $headers .= "--" . $separator . $eol;
    //     $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    //     $headers .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
    //     $headers .= $message . $eol . $eol;

    //     // Attachment
    //     $headers .= "--" . $separator . $eol;
    //     $headers .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    //     $headers .= "Content-Transfer-Encoding: base64" . $eol;
    //     $headers .= "Content-Disposition: attachment" . $eol . $eol;
    //     $headers .= $attachment . $eol . $eol;
    //     $headers .= "--" . $separator . "--";

    //     if (mail($to, $subject, "", $headers)) {
    //         return "Done";
    //     } else {
    //         return "Error";
    //     }
    // }
    public function send_invoice_in_mail(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf',
            'email' => 'required|email',
        ]);
    
        // Retrieve file details
        $pdf = $request->file('pdf');
        $pdfPath = $pdf->getRealPath();
        $pdfName = $pdf->getClientOriginalName();
    
        // Recipient and email details
        $to = $request->email;
        $subject = 'Your Invoice';
        $message = 'See attached document.';
    
        // Generate a unique boundary string
        $boundary = md5(time());
    
        // Headers
        $headers = [
            'From' => 'devenhealthcare202@gmail.com',
            'Reply-To' => 'devenhealthcare202@gmail.com',
            'MIME-Version' => '1.0',
            'Content-Type' => "multipart/mixed; boundary=\"$boundary\"",
        ];
    
        // Message content
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";
    
        // Attachment content
        $fileContent = file_get_contents($pdfPath);
        $encodedContent = chunk_split(base64_encode($fileContent));
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"$pdfName\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$pdfName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $encodedContent . "\r\n";
    
        $body .= "--$boundary--";
    
        // Prepare headers
        $headers_str = '';
        foreach ($headers as $key => $value) {
            $headers_str .= "$key: $value\r\n";
        }

        // Send email
        if (mail($to, $subject, $body, $headers_str)) {
            return "Done";
        } else {
            return "Error";
        }
    }
}

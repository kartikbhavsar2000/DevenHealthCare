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
use App\Models\Invoice;
use Mail;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceController extends Controller
{
    public function testing($id)
    {
        $booking = Booking::with('BookingDetails')->find($id);
        $booking->customer_details = $booking->customerDetails();
        $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
        $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
        $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

        foreach($booking->bookingDetails as $detail) {
            $shift = Shifts::find($detail->shift);
            $detail->shift_name = $shift ? $shift->name : "-";
        }

        $enddate = strtotime('24-07-2024');
        $startDate = '23-07-2024';
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
                    })->where('is_cancled',0)->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->count();

                    $total_price = BookingAssign::when($startDate && $startDate === $endDate, function ($query) use ($startDate) {
                        return $query->whereDate('date', $startDate);
                    }, function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween('date', [$startDate, $endDate]);
                    })->where('is_cancled',0)->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->sum('sell_rate');

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
                $dateToCheckTimee = strtotime($details->date);
                $dateToCheck = date('Y-m-d', $dateToCheckTimee);
                if (($dateToCheck >= $startDate && $dateToCheck <= $endDate) || $dateToCheck == $startDate || $dateToCheck == $endDate) {
                    $data[] = [
                        'description' => $description,
                        'price' => $details->cost_rate,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
                }
            }elseif($details->type == 4){
                $dateToCheckTimee = strtotime($details->date);
                $dateToCheck = date('Y-m-d', $dateToCheckTimee);
                if (($dateToCheck >= $startDate && $dateToCheck <= $endDate) || $dateToCheck == $startDate || $dateToCheck == $endDate) {
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
                })->where('is_cancled',0)->where(['booking_id' => $booking->id,'type'=>'Doctor'])->get();

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

        $pdf = Pdf::loadView('backend.pdf.invoice', ['booking'=>$booking])->setOptions(['defaultFont' => 'sans-serif']);

        // Stream the PDF
        return $pdf->stream('document.pdf');

        return view('backend.pdf.invoice')->with(['booking'=>$booking]);
    }
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
            $booking_amount_diffrence = BookingAssign::where('is_cancled',0)->where('type','!=','Doctor')->where('status','!=',1)->where(['booking_id'=>$da->id,'att_marked'=>0])->sum('sell_rate');
            $da->booking_amount_diffrence = $booking_amount_diffrence;
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
    public function get_closed_invoice_list()
    {   
        $data = Booking::where('booking_status',1)->with('closed_by')->orderBy('id',"DESC")->get();
        foreach($data as $da){
            $customer_details = $da->customerDetails();
            $da->customer_details = $customer_details;
            $booking_amount_diffrence = BookingAssign::where('is_cancled',0)->where('type','!=','Doctor')->where('status','!=',1)->where(['booking_id'=>$da->id,'att_marked'=>0])->sum('sell_rate');
            $da->booking_amount_diffrence = $booking_amount_diffrence;
        }
        return response()->json(['data'=>$data]);
    }
    public function generate_invoice($id)
    {
        if (in_array("active_invoice", Auth::user()->permissions())) {
            $booking = Booking::with('bookingDetails')->find($id);
            $booking_amount_diffrence = BookingAssign::where('is_cancled',0)->where('type','!=','Doctor')->where('status','!=',1)->where(['booking_id'=>$booking->id,'att_marked'=>0])->sum('sell_rate');
            $booking->customer_details = $booking->customerDetails();
            $booking->state = State::where('id',$booking->customer_details->state)->pluck('name')->first();
            $booking->city = City::where('id',$booking->customer_details->city)->pluck('name')->first();
            $booking->area = Area::where('id',$booking->customer_details->area)->pluck('name')->first();

            foreach($booking->bookingDetails as $detail) {
                $shift = Shifts::find($detail->shift);
                $detail->shift_name = $shift ? $shift->name : "-";
            }
            $invoices = Invoice::where('booking_id',$id)->with('created_by')->orderBy('id','desc')->get();
            $payments = BookingPayment::where(['booking_id'=>$booking->id])->with('created_by')->get();
            return view('backend.invoice.generate_invoice',['booking_amount_diffrence' => $booking_amount_diffrence,'invoices' => $invoices,'booking' => $booking,'payments'=>$payments]);
        }
        abort(403);
    }
    public function close_booking(Request $request)
    {   
        $data = Booking::find($request->id);
        if($data){
            $payments = BookingPayment::where(['booking_id'=>$data->id])->get();
            if ($payments->isEmpty() && $data->total > 0) {
                return "Error";
            }else{
                $assign_data = BookingAssign::where('is_cancled',0)->where('booking_id',$data->id)->get();
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
    public function store_invoice(Request $request)
    {
        if ($request->hasFile('file')) {
            $invoice = Invoice::find($request->id);
            if ($invoice) {

                $file = $request->file('file');
                $filePath = $invoice->inv_no . ".pdf";
                $file->move(public_path('invoices'), $filePath);
            
                $invoice->file = $filePath;
                $invoice->update();

                return response()->json(['file_path' => $filePath], 200);
            } else {
                return response()->json(['error' => 'Invoice not found'], 404);
            }
        } else {
            return response()->json(['error' => 'No file uploaded'], 400);
        }
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
                    })->where('is_cancled',0)->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->count();

                    $total_price = BookingAssign::when($startDate && $startDate === $endDate, function ($query) use ($startDate) {
                        return $query->whereDate('date', $startDate);
                    }, function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween('date', [$startDate, $endDate]);
                    })->where('is_cancled',0)->where(['booking_id' => $booking->id,'booking_detail_id'=> $details->id,'att_marked'=>1,'status'=>1])->sum('sell_rate');

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
                $dateToCheckTimee = strtotime($details->date);
                $dateToCheck = date('Y-m-d', $dateToCheckTimee);
                if (($dateToCheck >= $startDate && $dateToCheck <= $endDate) || $dateToCheck == $startDate || $dateToCheck == $endDate) {
                    $data[] = [
                        'description' => $description,
                        'price' => $details->cost_rate,
                        'qnt' => $qnt,
                        'total' => $total,
                    ];
                }
            }elseif($details->type == 4){
                $dateToCheckTimee = strtotime($details->date);
                $dateToCheck = date('Y-m-d', $dateToCheckTimee);
                if (($dateToCheck >= $startDate && $dateToCheck <= $endDate) || $dateToCheck == $startDate || $dateToCheck == $endDate) {
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
                })->where('is_cancled',0)->where(['booking_id' => $booking->id,'type'=>'Doctor'])->get();

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
        $grandTotal = 0;
        foreach($data as $d){
            $grandTotal += $d['total'];
        }
        $invoice = null;

        if ($booking) {
            if($grandTotal > 0){
                // Retrieve the latest invoice for the booking
                $latestInvoice = Invoice::where('booking_id', $booking->id)
                ->orderBy('id', 'desc') // Order by ID or a timestamp to get the latest invoice
                ->first();

                $currentYear = date('Y');
                $prefix = "INV" . $currentYear . $booking->id;

                if ($latestInvoice) {
                    // Extract the numeric part of the inv_no if it matches the current year and booking ID
                    if (strpos($latestInvoice->inv_no, $prefix) === 0) {
                        // Get the remaining part as the numeric count
                        $latestInvNo = (int)substr($latestInvoice->inv_no, strlen($prefix));
                        $latestInvNo++; // Increment the count
                    } else {
                        // If the prefix does not match, start a new count
                        $latestInvNo = 1;
                    }
                } else {
                    // No previous invoice, start with 1
                    $latestInvNo = 1;
                }

                // Generate the new invoice number
                $invoiceNumber = $prefix . $latestInvNo;


                // Create the new invoice record
                $invoice = new Invoice();
                $invoice->booking_id = $booking->id;
                $invoice->inv_no = $invoiceNumber;
                $invoice->start_date = $startDate;
                $invoice->end_date = $endDate;
                $invoice->amount = $grandTotal;
                $invoice->added_by = Auth::user()->id;
                $invoice->save();
            }else{
                $invoice = "No";
            }
        }

        return(['data'=>$data,'invoice'=>$invoice]);
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
    public function send_invoice_in_mail(Request $request)
    {

        $invoice = Invoice::find($request->id);
        if($invoice && $invoice->file){
            $booking = Booking::find($invoice->booking_id);
            $name = "Sir";
            if($booking){
                $cust_data = $booking->customerDetails();
                if($cust_data){
                    $name = $cust_data->name ?? "Sir";
                }
            }
            $pdfName = $invoice->file;
            $pdfPath = public_path('invoices')."/".$pdfName;

            // Recipient and email details
            $to = $request->email;
            $subject = 'Invoice #'. $invoice->inv_no.' from Deven Health Care';
            
            $message = "Dear ".$name.",\r\n\r\nPlease find your invoice attached to this email.\r\n\r\nBest regards,\rDeven Health Care";
        
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
        }else{
            return "Error";
        }
    }
}

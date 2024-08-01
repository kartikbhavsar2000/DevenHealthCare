@extends('backend.components.header')

@section('css')

@endsection

@section('content')
@if(session()->has('success'))
    <div class="alert alert-success d-flex align-items-center p-3 mt-4" role="alert">
        <span>{{ session()->get('success') }}</span>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger d-flex align-items-center p-3 mt-4" role="alert">
        <span>{{ session()->get('error') }}</span>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-6 mb-5">
        <h4 class="mt-1 mb-1">Booking Invoice | {{$booking->unique_id ?? ""}}</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Booking Invoice</p>
    </div>
    <div class="col-6 mb-5 text-end pt-1 pe-5">
        <button class="btn btn-white text-dark waves-effect me-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="ri-history-line text-dark"></i>&nbsp;Payment History
        </button>
        @if($booking->booking_status == 0 || $booking->booking_status == 2)
            <button class="btn btn-primary waves-effect" onclick="openAddPaymentCanvas()"><i class="ri-money-rupee-circle-line"></i>&nbsp;Add Payment</button>
        @endif
    </div>
    <div class="col-12 mb-5">
        <div class="collapse" id="collapseExample">
            <div class="card">
                <h5 class="card-header"><i class="ri-history-line ri-22px"></i>&nbsp;Payment History</h5>
                <div class="card-body">
                    <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                        <thead>
                          <tr>
                            <th>Sr No.</th>
                            <th>Payment Date</th>
                            <th>Invoice Start Date</th>
                            <th>Invoice End Date</th>
                            <th>Added By</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(!empty($payments))
                            @foreach($payments as $key => $payment)
                              <tr>
                                <td class="text-nowrap text-heading">{{$key+1}}</td>
                                <td class="text-nowrap">{{date('d/m/Y',strtotime($payment->date)) ?? "-"}}</td>
                                <td class="text-nowrap">{{date('d/m/Y',strtotime($payment->start_date)) ?? "-"}}</td>
                                <td class="text-nowrap">{{date('d/m/Y',strtotime($payment->end_date)) ?? "-"}}</td>
                                <td>{{$payment->created_by->name ?? "-"}}</td>
                                <td>₹{{ number_format($payment->amount ?? "0") }}</td>
                              </tr>
                            @endforeach
                          @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                                <div>
                                    <h4 class="mb-0">₹{{number_format($booking->total) ?? "0"}}</h4>
                                    <p class="mb-0">Total Amount</p>
                                </div>
                                <div class="avatar me-lg-6">
                                    <span class="avatar-initial rounded-3 bg-label-secondary">
                                        <i class="ri-money-rupee-circle-line text-heading ri-26px"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                                <div>
                                    <h4 class="mb-0">₹{{number_format($booking->total - $booking->pending_payment) ?? "0"}}</h4>
                                    <p class="mb-0">Paid Amount</p>
                                </div>
                                <div class="avatar me-sm-6">
                                    <span class="avatar-initial rounded-3 bg-label-secondary">
                                        <i class="ri-money-rupee-circle-line text-heading ri-26px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                                <div>
                                    <h4 class="mb-0">₹{{number_format($booking->pending_payment - $booking_amount_diffrence) ?? "0"}}</h4>
                                    <p class="mb-0">Pending Amount</p>
                                </div>
                                <div class="avatar me-sm-6">
                                    <span class="avatar-initial rounded-3 bg-label-secondary">
                                        <i class="ri-money-rupee-circle-line text-heading ri-26px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start ">
                                <div>
                                    <h4 class="mb-0">₹{{number_format($booking_amount_diffrence) ?? "0"}}</h4>
                                    <p class="mb-0">Diffrence Amount</p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded-3 bg-label-secondary">
                                        <i class="ri-money-rupee-circle-line text-heading ri-26px"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="col-12">
                            <b class="text-danger">Note :- </b><span class="m-0 text-dark">The difference amount represents instances where staff are absent, attendance is unmarked, or staff members are not allocated.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h5></i>Booking Details</h5>
                    <div class="col-6">
                        <div class="mt-1 row">
                            <div class="col-4">
                                <b style="color:#4cb7e5;">Booking Id</b>
                            </div>
                            <div class="col-8">
                                : {{$booking->unique_id ?? "-"}}
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-4">
                                <b style="color:#4cb7e5;">Type</b>
                            </div>
                            <div class="col-8">
                                : {{$booking->booking_type ?? "-"}}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-1 row">
                            <div class="col-4">
                                <b style="color:#4cb7e5;">Start Date</b>
                            </div>
                            <div class="col-8">
                                : {{date('d/m/Y',strtotime($booking->start_date)) ?? "-"}}
                            </div>
                        </div>
                        <div class="mt-1 row">
                            <div class="col-4">
                                <b style="color:#4cb7e5;">End Date</b>
                            </div>
                            <div class="col-8">
                                : {{date('d/m/Y',strtotime($booking->end_date)) ?? "-"}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Shift</th>
                                    <th>Days/Qnt</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody id="cust_BookingData">
                                @if(!empty($booking->bookingDetails))
                                    @foreach($booking->bookingDetails as $keyy => $detail)
                                        @php 
                                        if($detail->type == 1){
                                            $type = "Staff";
                                        }elseif($detail->type == 2){
                                            $type = "Equipment";
                                        }elseif($detail->type == 3){
                                            $type = "Doctor";
                                        }elseif($detail->type == 4){
                                            $type = "Ambulance";
                                        }else{
                                            $type = "-";
                                        }
                                        $rate = $detail->sell_rate;
                                        if($detail->type == 1){
                                            $rate *= $detail->qnt;
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{$keyy+1}}</td>
                                            <td>{{$detail->name ?? "-"}}</td>
                                            <td>{{$type ?? "-"}}</td>
                                            <td>{{$detail->shift_name ?? "-"}}</td>
                                            <td>{{$detail->qnt ?? "-"}}</td>
                                            <td>₹{{ number_format($rate) ?? "0"}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="col-12 mt-5">
        <div class="card mb-6">
            <h5 class="card-header">Generate Invoice</h5>
            <div class="card-body">
                <div class="row g-6">
                    <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                        <div class="form-floating form-floating-outline">
                            {{-- <input type="text" class="form-control" name="start_date" placeholder="DD-MM-YYYY" value="{{date('Y-m-d',strtotime($booking->start_date))}}" id="BookingStartDate" readonly/> --}}
                            <input type="text" class="form-control" name="start_date" placeholder="DD-MM-YYYY" id="BookingStartDate" readonly/>
                            <label for="BookingStartDate">Start Date</label>
                        </div>
                        <span class="text-danger" id="StartError"></span>
                    </div>
                    <div class="mb-2 col-lg-6 col-xl-6 col-12 mb-0">
                        <div class="form-floating form-floating-outline">
                            {{-- <input type="text" class="form-control" name="end_date" placeholder="DD-MM-YYYY" value="{{date('d-m-Y',strtotime($booking->end_date))}}" id="BookingEndDate" readonly/> --}}
                            <input type="text" class="form-control" name="end_date" placeholder="DD-MM-YYYY" id="BookingEndDate" readonly/>
                            <label for="BookingEndDate">End Date</label>
                        </div>
                        <span class="text-danger" id="EndError"></span>
                    </div>
                </div>
                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4 waves-effect waves-light" onclick="submit({{$booking->id}})">Generate</button>
                    <div class="mt-5">
                        <b class="text-danger">Note :- </b><span class="m-0 text-dark">This invoice is generated based on staff attendance. If the attendance is marked and approved by the admin, it will be reflected in the invoice.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-5">
        <div class="card">
            <h5 class="card-header"><i class="ri-file-list-3-line ri-22px"></i>&nbsp;Invoice History</h5>
            <div class="card-body">
                <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                    <thead>
                        <tr>
                        <th>Sr No.</th>
                        <th>Invoice No</th>
                        <th>Invoice Start Date</th>
                        <th>Invoice End Date</th>
                        <th>Added By</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($invoices))
                        @foreach($invoices as $key => $invoice)
                            <tr>
                            <td class="text-nowrap text-heading">{{$key+1}}</td>
                            <td class="text-nowrap">{{$invoice->inv_no ?? "-"}}</td>
                            <td class="text-nowrap">{{date('d/m/Y',strtotime($invoice->start_date)) ?? "-"}}</td>
                            <td class="text-nowrap">{{date('d/m/Y',strtotime($invoice->end_date)) ?? "-"}}</td>
                            <td>{{$invoice->created_by->name ?? "-"}}</td>
                            @if($invoice->file)
                                <td>
                                    <a href="{{asset("/")}}public/invoices/{{$invoice->file}}" target="_blank" class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-eye-line ri-20px"></i></a>
                                    <a href="{{asset("/")}}public/invoices/{{$invoice->file}}" download class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-download-line ri-20px"></i></a>
                                    @if($booking->customer_details->email)
                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light" onclick="sendEmailWithPDF('{{$invoice->id}}','{{$booking->customer_details->email}}')"><i class="ri-mail-line"></i></button>
                                    @endif
                                </td>
                            @else
                                <td><button disabled class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-eye-line ri-20px"></i></button><button disabled class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i class="ri-download-line ri-20px"></i></button></td>
                            @endif
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 d-none" id="InvoicePreview">
        <div class="row invoice-preview">
            <div class="col-6 mb-5">
                <h4 class="mt-1 mb-1">Invoice</h4>
            </div>
            {{-- <div class="col-6 mb-5 text-end pt-1 pe-5">
                @if($booking->customer_details->email)
                <button class="btn btn-info waves-effect me-2" onclick="sendEmailWithPDF('{{$booking->customer_details->email}}')"><i class="ri-mail-line"></i>&nbsp; Send to the mail</button>
                @endif
                <button class="btn btn-danger waves-effect me-2" onclick="PrintInvoice()"><i class="ri-printer-line"></i>&nbsp; Print</button>
                <button class="btn btn-dark waves-effect me-2" onclick="DownloadInvoice()"><i class="ri-download-2-line"></i>&nbsp; Download</button>
            </div> --}}
            <!-- Invoice -->
            <div class="col-12 mb-md-0 mb-6" id="invoiceContent">
              <div class="card invoice-preview-card p-sm-12 p-6" >
                <div class="card-body invoice-preview-header rounded-4 p-6" style="background-color: rgba(38, 43, 67, .06);">
                  <div
                    class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">
                    <div>
                        <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                          <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png" style="height: 80px!important;" />
                        </div>
                        
                      </div>
                      <div>
                        <p class="mb-1">FF-2, 1ST Floor Block A in Malabar County -2,</p>
                        <p class="mb-1">Nirma University cirket ground,</p>
                        <p class="mb-1">off SG road Chhatrodi, Ahmedabad.</p>
                        <p class="mb-1">+91 8866451769</p>
                        <p class="mb-1">devenhealthcare202@gmail.com</p>
                        <p class="mb-0"> www.devenhealthcare.com</p>
                      </div>
                  </div>
                </div>
                <div class="card-body py-6 px-3">
                  {{-- <div class="d-flex justify-content-between flex-wrap gap-6">
                    <div>
                      <h6>Invoice To:</h6>
                      @if($booking->booking_type == "Patient")
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (@if($booking->customer_details->h_type != "DHC") HSP @else DHC @endif)</p>
                        @if($booking->customer_details->h_type != "DHC")
                          <p class="mb-1">{{$booking->customer_details->h_type ?? ""}}</p>
                        @endif
                      @else
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (<b>{{$booking->booking_type ?? ""}}</b>)</p>
                      @endif
                      <p class="mb-1">{{$booking->customer_details->address ?? ""}}</p>
                      <p class="mb-1">{{$booking->area ?? ""}}, {{$booking->city ?? ""}}, {{$booking->state ?? ""}}</p>
                      <p class="mb-1">{{$booking->customer_details->mobile ?? ""}} @if($booking->customer_details->mobile2) , @endif {{$booking->customer_details->mobile2 ?? ""}}</p>
                      <p class="mb-0">{{$booking->customer_details->email ?? ""}}</p>
                    </div>
                    <div>
                      <h6>Booking & Invoice</h6>
                      <table>
                        <tbody>
                            <tr>
                                <td class="pe-4">Invoice No.:</td>
                                <td>{{$booking->unique_id ?? ""}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Date Issues:</td>
                                <td>{{date('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Service Period:</td>
                                <td>{{date('d/m/Y',strtotime($booking->start_date))}} To {{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Invoice Start Date:</td>
                                <td id="DataStartDate">{{date('d/m/Y',strtotime($booking->start_date))}}</td>
                            </tr>
                            <tr>
                              <td class="pe-4">Invoice End Date:</td>
                              <td id="DataEndDate">{{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div> --}}
                  <div class="d-flex justify-content-between flex-wrap gap-6">
                    <div style="flex: 1; min-width: 45%;">
                      <h6>Invoice To:</h6>
                      @if($booking->booking_type == "Patient")
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (@if($booking->customer_details->h_type != "DHC") HSP @else DHC @endif)</p>
                        @if($booking->customer_details->h_type != "DHC")
                          <p class="mb-1">{{$booking->customer_details->h_type ?? ""}}</p>
                        @endif
                      @else
                        <p class="mb-1">{{$booking->customer_details->name ?? ""}} (<b>{{$booking->booking_type ?? ""}}</b>)</p>
                      @endif
                      <p class="mb-1">{{$booking->customer_details->address ?? ""}}</p>
                      <p class="mb-1">{{$booking->area ?? ""}}, {{$booking->city ?? ""}}, {{$booking->state ?? ""}}</p>
                    </div>
                    <div style="flex: 1; min-width: 45%; padding-left:10rem;">
                      <h6>Booking & Invoice</h6>
                      <table>
                        <tbody>
                            <tr>
                                <td class="pe-4">Invoice No.:</td>
                                <td id="INV_NO"></td>
                            </tr>
                            <tr>
                                <td class="pe-4">Date Issues:</td>
                                <td>{{date('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Service Period:</td>
                                <td>{{date('d/m/Y',strtotime($booking->start_date))}} To {{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                            <tr>
                                <td class="pe-4">Invoice Start Date:</td>
                                <td id="DataStartDate">{{date('d/m/Y',strtotime($booking->start_date))}}</td>
                            </tr>
                            <tr>
                              <td class="pe-4">Invoice End Date:</td>
                              <td id="DataEndDate">{{date('d/m/Y',strtotime($booking->end_date))}}</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="table-responsive border rounded-4 border-bottom-0 mx-3">
                  <table class="kt_datatable table table-row-bordered table-row-gray-300" style="margin-bottom: 0px!important">
                    <thead>
                      <tr>
                        <th>Sr No.</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Days/Qty</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody id="table-body">
            
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive px-3">
                  <table class="table m-0 table-borderless">
                    <tbody>
                      <tr>
                        <td class="align-top px-0 py-6">
                          <p class="mb-1">
                            <span class="me-2 fw-medium text-heading">Signature:</span>
                          </p>
                        </td>
                        <td class="pe-0 py-6 w-px-100">
                          <p class="mb-1 border-bottom pb-2">Subtotal:</p>
                          <p class="mb-0 pt-2">Total:</p>
                        </td>
                        <td class="text-end px-0 py-6 w-px-100">
                          <p class="fw-medium mb-1 border-bottom pb-2" id="grand-sub-total">₹{{$booking->sub_total ?? "00"}}</p>
                          <p class="fw-medium mb-0 pt-2" id="grand-total">₹{{$booking->total ?? "00"}}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /Invoice -->
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="AddPaymentCanvas" aria-labelledby="AddPaymentCanvasLabel">
    <div class="offcanvas-header">
      <h5 id="AddPaymentCanvasLabel">Add Payment | {{$booking->unique_id ?? ""}}</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="d-flex justify-content-between bg-lighter p-2 px-5 mb-5">
        <p class="mb-0">Pending Amount:</p>
        <p class="fw-medium mb-0">₹{{$booking->pending_payment  - $booking_amount_diffrence ?? "00"}}</p>
    </div>
    <div class="offcanvas-body">
      <form action="{{route('add_booking_payment')}}" method="POST" id="AddPaymentForm">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control d-none" name="id" id="BookingId" value="{{$booking->id}}">
                    <input type="text" class="form-control" name="date" value="{{ date('Y-m-d') }}" placeholder="DD-MM-YYYY" id="AssignDate" readonly/>
                    <label for="AssignDate">Payment Date</label>
                </div>
                <span class="text-danger" id="DateError"></span>
            </div>
            <div class="col-12 mt-5">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="start_date" placeholder="DD-MM-YYYY" id="PaymentStartDate" value="" readonly required/>
                    <label for="PaymentStartDate">Invoice Start Date</label>
                </div>
                <span class="text-danger" id="StartError1"></span>
            </div>
            <div class="col-12 mt-5">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" name="end_date" placeholder="DD-MM-YYYY" id="PaymentEndDate" value="" readonly required/>
                    <label for="PaymentEndDate">Invoice End Date</label>
                </div>
                <span class="text-danger" id="EndError1"></span>
            </div>
            <div class="col-12 mt-5">
                <div class="input-group input-group-merge">
                    <span class="input-group-text text-secondary">₹</span>
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control" name="amount" min="1" max="{{$booking->pending_payment  - $booking_amount_diffrence ?? '0'}}" placeholder="00" required id="PaymentAmount" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        <label for="PaymentAmount">Amount</label>
                    </div>
                </div>
                <span class="text-danger" id="AmountError"></span>
            </div>
            <div class="col-12 mt-8">
                <button type="submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1" onclick="return checkValidation()">Submit</button>
            </div>
        </div>
    </form>
    </div>
  </div>
@endsection


@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
    $('.kt_datatable').DataTable({
        dom:'',
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all",
        }],
    });
    function checkValidation() {
        let isValid = true;

        const startDate = document.getElementById('PaymentStartDate').value;
        const endDate = document.getElementById('PaymentEndDate').value;
        const amount = document.getElementById('PaymentAmount').value;

        // Clear previous error messages
        document.getElementById('StartError1').innerText = '';
        document.getElementById('EndError1').innerText = '';
        document.getElementById('AmountError').innerText = '';

        if (!startDate) {
            document.getElementById('StartError1').innerText = 'Invoice Start Date is required.';
            isValid = false;
        }
        if (!endDate) {
            document.getElementById('EndError1').innerText = 'Invoice End Date is required.';
            isValid = false;
        }
        if (!amount) {
            document.getElementById('AmountError').innerText = 'Amount is required.';
            isValid = false;
        }

        return isValid;
    }
    function openAddPaymentCanvas(){
        $('#AddPaymentCanvas').offcanvas('show');
    }
    function PrintInvoice() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const padding = 0;

        html2canvas(document.querySelector("#invoiceContent")).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pageWidth = 210;
            const pageHeight = 295;
            const imgWidth = pageWidth - 2 * padding;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;
            let position = padding;

            pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight + padding;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            // Output PDF as blob
            const blob = pdf.output('blob');

            // Open print dialog for the PDF blob
            const url = URL.createObjectURL(blob);
            const iframe = document.createElement('iframe');
            iframe.style.cssText = 'position:absolute;width:0px;height:0px;top:-10px;left:-10px;';
            document.body.appendChild(iframe);
            iframe.src = url;

            // Wait for iframe to load PDF
            iframe.onload = function() {
                // Call print() after PDF is loaded
                iframe.contentWindow.print();
            };
        });
    }
    function sendEmailWithPDF(id,email) {
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('email', email);
        formData.append('id', id);

        $.ajax({
            url: '{{ route("send_invoice_in_mail") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if(response == "Error"){
                    Swal.fire({
                        title: 'Error!',
                        text: "Email sending failed!",
                        icon: 'error',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        },
                        buttonsStyling: false
                    });
                } else {
                    Swal.fire({
                        title: 'Success!',
                        text: "Email sent successfully!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        },
                        buttonsStyling: false
                    });
                    setTimeout(function(){ window.location.reload(); }, 500);
                }
                console.log(response);
            },
            error: function (error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error sending email: ' + error.responseText,
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonText: 'ok',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    },
                    buttonsStyling: false
                });
            }
        });
    }

    function DownloadInvoice(){
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const padding = 0;

        html2canvas(document.querySelector("#invoiceContent")).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pageWidth = 210; 
            const pageHeight = 295;
            const imgWidth = pageWidth - 2 * padding;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;

            let position = padding;

            pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight + padding;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }
            var name = "{{$booking->unique_id}}" + ".pdf";
            pdf.save(name);
        });
    }
    function formatDate(dateString) {
        // Parse the date string
        var date = new Date(dateString);

        // Check if the parsed date is valid
        if (isNaN(date)) {
            console.error("Invalid date:", dateString);
            return dateString; // or handle the error appropriately
        }

        var day = date.getDate();
        var month = date.getMonth() + 1; // Months are zero-based
        var year = date.getFullYear();

        // Pad day and month with leading zeros if necessary
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }

        return day + '/' + month + '/' + year;
    }
    function formatDate(dateString) {
            // Helper function to pad day and month with leading zeros
            function pad(num) {
                return num < 10 ? '0' + num : num;
            }

            // Split the date string into components
            var parts = dateString.split('-');
            if (parts.length !== 3) {
                console.error("Invalid date format:", dateString);
                return dateString;
            }

            var day, month, year;

            // Check if the format is YYYY-MM-DD or DD-MM-YYYY
            if (parseInt(parts[0], 10) > 31) {
                // Assuming YYYY-MM-DD
                year = parseInt(parts[0], 10);
                month = parseInt(parts[1], 10) - 1; // Months are zero-based in JavaScript Date
                day = parseInt(parts[2], 10);
            } else {
                // Assuming DD-MM-YYYY
                day = parseInt(parts[0], 10);
                month = parseInt(parts[1], 10) - 1; // Months are zero-based in JavaScript Date
                year = parseInt(parts[2], 10);
            }

            // Create a new date object
            var date = new Date(year, month, day);

            // Check if the parsed date is valid
            if (isNaN(date.getTime())) {
                console.error("Invalid date:", dateString);
                return dateString; // or handle the error appropriately
            }

            // Format the date as DD/MM/YYYY
            var formattedDay = pad(day);
            var formattedMonth = pad(month + 1); // Adjust month back to 1-based
            var formattedYear = year;

            return formattedDay + '/' + formattedMonth + '/' + formattedYear;
    }

    function StoreInvoice(id) {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const padding = 0;

        html2canvas(document.querySelector("#invoiceContent")).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pageWidth = 210;
            const pageHeight = 295;
            const imgWidth = pageWidth - 2 * padding;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;

            let position = padding;

            pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight + padding;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', padding, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            // Create a blob from the PDF
            const blob = pdf.output('blob');
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('file', blob, 'invoice.pdf');
            formData.append('id', id);  // Append other necessary data

            $('#InvoicePreview').addClass('d-none');

            // Send the blob to the server via AJAX
            $.ajax({
                url: "{{route('store_invoice')}}",
                method: "POST",
                data:formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting content type
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(result) {
                    Swal.fire({
                        title: 'Success!',
                        text: "Invoice Generated Successfully!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'ok',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        },
                        buttonsStyling: false
                    });
                    setTimeout(function(){ window.location.reload(); }, 500);
                },
                error: function(err) {
                    console.error(err);
                }
            });
        });
    }


    function submit(id){
        var startDate = $('#BookingStartDate').val();
        var endDate = $('#BookingEndDate').val();
        if (!startDate) {
            $('#StartError').text('Please Select Start Date');
        } else {
            $('#StartError').text('');
        }
        if (!endDate) {
            $('#EndError').text('Please Select End Date');
        } else {
            $('#EndError').text('');
        }
        $('#InvoicePreview').addClass('d-none');
        if(startDate && endDate){
            $.ajax({
                url:"{{route('invoice_details_by_dates')}}",
                method:"POST",
                data:{'id':id,'startDate':startDate,'endDate':endDate,_token:"{{ csrf_token() }}"},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(result)
                {
                    $('#DataStartDate').text(formatDate(startDate));
                    $('#DataEndDate').text(formatDate(endDate));
                    console.log(result);
                    var data = result['data'];
                    var invoice = result['invoice'];

                    // Clear the table body
                    $('#table-body').empty();

                    var grandTotal = 0;

                    // Populate the table with the data received
                    $.each(data, function(index, item) {
                        $('#table-body').append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + item.description + '</td>' +
                            '<td>' + '₹' + parseInt(item.price,10).toLocaleString() + '</td>' +
                            '<td>' + item.qnt + '</td>' +
                            '<td>' + '₹' + item.total.toLocaleString() + '</td>' +
                            '</tr>'
                        );
                        grandTotal += item.total;
                    });

                    $('#grand-sub-total').text('₹' + grandTotal.toLocaleString());
                    $('#grand-total').text('₹' + grandTotal.toLocaleString());
                    $('#InvoicePreview').removeClass('d-none');
                    if(invoice != null){
                        $('#INV_NO').text(invoice.inv_no);
                        setTimeout(function() 
                        {
                            StoreInvoice(invoice.id);
                        }, 1000);
                    }else{
                        $('#InvoicePreview').addClass('d-none');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Invoice not generated!',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'ok',
                            customClass: {
                                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                            },
                            buttonsStyling: false
                        });
                        setTimeout(function(){ window.location.reload(); }, 500);
                    }
                }
            });
        }
    }
    $(document).ready(function() {
        var start_date = @json($booking->start_date);
        var end_date = @json($booking->end_date);
        var id = @json($booking->id);

        // submit(id);
        
        $('#AssignDate').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            defaultDate: 'today',
            minDate: 'today',
            maxDate: 'today'
        });
        $('#BookingStartDate').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: start_date,
            maxDate: end_date
        });
        $('#BookingStartDate').on('change', function(){
            $('#StartError').text('');
            var mindate = $('#BookingStartDate').val();
            $('#BookingEndDate').flatpickr({
                altInput: true,
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: mindate,
                maxDate: end_date
            });
        });
        $('#PaymentStartDate').flatpickr({
            altInput: true,
            altFormat: 'd-m-Y',
            dateFormat: 'Y-m-d',
            minDate: start_date,
            maxDate: end_date
        });
        $('#PaymentStartDate').on('change', function(){
            $('#StartError').text('');
            var mindate = $('#PaymentStartDate').val();
            $('#PaymentEndDate').flatpickr({
                altInput: true,
                altFormat: 'd-m-Y',
                dateFormat: 'Y-m-d',
                minDate: mindate,
                maxDate: end_date
            });
        });
        $('#BookingEndDate').on('click', function(){
          var startDate = $('#BookingStartDate').val();
          if (startDate) {
              $('#StartError').text('Please Change The Start Date First');
          } else {
              $('#StartError').text('');
          }
        });
    });
</script>
@endsection
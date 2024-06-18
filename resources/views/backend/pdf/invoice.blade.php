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
<div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-6">
      <div class="card invoice-preview-card p-sm-12 p-6"  id="DivIdToPrint">
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
          <div class="d-flex justify-content-between flex-wrap gap-6">
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
              <p class="mb-1">{{$booking->state ?? ""}} , {{$booking->city ?? ""}}, {{$booking->area ?? ""}}</p>
              <p class="mb-1">{{$booking->customer_details->mobile ?? ""}}</p>
              <p class="mb-0">{{$booking->customer_details->email ?? ""}}</p>
            </div>
            <div>
              <h6>Invoice</h6>
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
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive border rounded-4 border-bottom-0 mx-3">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Sr No.</th>
                <th>Description</th>
                <th>Price</th>
                <th>Days/Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($booking->bookingDetails))
                @foreach($booking->bookingDetails as $key => $detail)
                  <tr>
                    <td class="text-nowrap text-heading">{{$key+1}}</td>
                    <td class="text-nowrap">{{$detail->name}}</td>
                    <td>₹{{$detail->sell_rate ?? "0"}}</td>
                    <td>{{$detail->qnt}}</td>
                    @if($detail->type == 1)
                      <td>₹{{$detail->sell_rate * $detail->qnt ?? "0"}}</td>
                    @else
                      <td>₹{{$detail->sell_rate ?? "0"}}</td>
                    @endif
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <div class="table-responsive px-3">
          <table class="table m-0 table-borderless">
            <tbody>
              <tr>
                <td class="align-top px-0 py-6">
                  <p class="mb-1">
                    <span class="me-2 fw-medium text-heading">Signatur:</span>
                  </p>
                </td>
                <td class="pe-0 py-6 w-px-100">
                  <p class="mb-1 border-bottom pb-2">Subtotal:</p>
                  <p class="mb-0 pt-2">Total:</p>
                </td>
                <td class="text-end px-0 py-6 w-px-100">
                  <p class="fw-medium mb-1 border-bottom pb-2">₹{{$booking->sub_total ?? "00"}}</p>
                  <p class="fw-medium mb-0 pt-2">₹{{$booking->total ?? "00"}}</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <a class="btn btn-outline-secondary d-grid w-100 me-4" onclick="printDiv();">Print</a>
            <a href="#" class="btn btn-outline-secondary d-grid w-100"> Download </a>
          </div>
        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>
@endsection


@section('javascript')
<script>
  function printDiv() {
    var printContents = $("#DivIdToPrint").html();
    var originalContents = $('body').html();
    var printWindow = window.open('', '', 'height=800,width=1000');
    
    // Collect all the styles from the current document
    var styles = '';
    $('link[rel="stylesheet"], style').each(function() {
      styles += this.outerHTML;
    });

    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write(styles); // Append styles to the new document
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Wait for the new window to load the content and then print
    printWindow.onload = function() {
      printWindow.print();
    };
  }
</script>
@endsection

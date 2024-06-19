<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="{{asset('public')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('public')}}/assets/images/logo.png">

    <title>Invoice | {{$booking->unique_id ?? ""}}</title>
  </head>
  <body>
    <div class="row invoice-preview">
        <!-- Invoice -->
        <div class="col-12 mb-md-0 mb-6">
          <div class="card invoice-preview-card p-sm-12 p-6 border-0"  id="DivIdToPrint">
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
            <div class="card-body py-5 px-3">
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
                            <td class="pe-4">Service Start Date:</td>
                            <td>{{date('d/m/Y',strtotime($booking->start_date))}}</td>
                        </tr>
                        <tr>
                          <td class="pe-4">Service End Date:</td>
                          <td>{{date('d/m/Y',strtotime($booking->end_date))}}</td>
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
                        <td class="text-nowrap"><b>{{$detail->name}}</b><span style="font-size: 12px;">{{$detail->shift_name}}</span></td>
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
                    <td class="align-top px-0 py-5" style="width:75%;">
                      <p class="mb-1">
                        <span class="me-2 fw-medium text-heading">Signatur:</span>
                      </p>
                    </td>
                    <td class="pe-0 py-5">
                      <p class="mb-1 border-bottom pb-2">Subtotal:</p>
                      <p class="mb-0 pt-2">Total:</p>
                    </td>
                    <td class="text-end px-0 py-5">
                      <p class="fw-medium mb-1 border-bottom pb-2">₹{{$booking->sub_total ?? "00"}}</p>
                      <p class="fw-medium mb-0 pt-2">₹{{$booking->total ?? "00"}}</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{asset('public')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
  </body>
</html>
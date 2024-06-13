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
      <div class="card invoice-preview-card p-sm-12 p-6">
        <div class="card-body invoice-preview-header rounded-4 p-6" style="background-color: rgba(38, 43, 67, .06);">
          <div
            class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column text-heading align-items-xl-center align-items-md-start align-items-sm-center flex-wrap gap-6">
            {{-- <div>
              <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png" style="height: 60px!important;" />
              </div>
              <p class="mb-1">FF-2, 1ST Floor Block A in Malabar County -2,</p>
              <p class="mb-1">Nirma University cirket ground,</p>
              <p class="mb-1">off SG road Chhatrodi, Ahmedabad.</p>
              <p class="mb-1">+91 8866451769</p>
              <p class="mb-1">devenhealthcare202@gmail.com</p>
              <p class="mb-0"> www.devenhealthcare.com</p>
            </div>
            <div>
              <h5 class="mb-6">Invoice #86423</h5>
              <div class="mb-1">
                <span>Date Issues:</span>
                <span>April 25, 2021</span>
              </div>
              <div>
                <span>Date Due:</span>
                <span>May 25, 2021</span>
              </div>
            </div> --}}
            <div>
                <div class="d-flex svg-illustration align-items-center gap-2 mb-6">
                  <img alt="Logo" src="{{asset('public')}}/assets/images/full_logo.png" style="height: 100px!important;" />
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
        <div class="card-body py-6 px-0">
          <div class="d-flex justify-content-between flex-wrap gap-6">
            <div>
              <h6>Invoice To:</h6>
              <p class="mb-1">Thomas shelby</p>
              <p class="mb-1">Shelby Company Limited</p>
              <p class="mb-1">Small Heath, B10 0HF, UK</p>
              <p class="mb-1">718-986-6062</p>
              <p class="mb-0">peakyFBlinders@gmail.com</p>
            </div>
            <div>
              <h6>Invoice</h6>
              <table>
                <tbody>
                    <tr>
                        <td class="pe-4">Invoice No.:</td>
                        <td>#86423</td>
                    </tr>
                    <tr>
                    <td class="pe-4">Invoice No.:</td>
                        <td>#86423</td>
                    </tr>
                    <tr>
                        <td class="pe-4">Total Amount:</td>
                        <td>$12,110.55</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive border rounded-4 border-bottom-0">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Cost</th>
                <th>Qty</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-nowrap text-heading">Vuexy Admin Template</td>
                <td class="text-nowrap">HTML Admin Template</td>
                <td>$32</td>
                <td>1</td>
                <td>$32.00</td>
              </tr>
              <tr>
                <td class="text-nowrap text-heading">Frest Admin Template</td>
                <td class="text-nowrap">Angular Admin Template</td>
                <td>$22</td>
                <td>1</td>
                <td>$22.00</td>
              </tr>
              <tr>
                <td class="text-nowrap text-heading">Apex Admin Template</td>
                <td class="text-nowrap">HTML Admin Template</td>
                <td>$17</td>
                <td>2</td>
                <td>$34.00</td>
              </tr>
              <tr class="border-bottom">
                <td class="text-nowrap text-heading">Robust Admin Template</td>
                <td class="text-nowrap">React Admin Template</td>
                <td>$66</td>
                <td>1</td>
                <td>$66.00</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table m-0 table-borderless">
            <tbody>
              <tr>
                <td class="align-top px-0 py-6">
                  <p class="mb-1">
                    <span class="me-2 fw-medium text-heading">Salesperson:</span>
                    <span>Alfie Solomons</span>
                  </p>
                  <span>Thanks for your business</span>
                </td>
                <td class="pe-0 py-6 w-px-100">
                  <p class="mb-1">Subtotal:</p>
                  <p class="mb-1">Discount:</p>
                  <p class="mb-1 border-bottom pb-2">Tax:</p>
                  <p class="mb-0 pt-2">Total:</p>
                </td>
                <td class="text-end px-0 py-6 w-px-100">
                  <p class="fw-medium mb-1">$154.25</p>
                  <p class="fw-medium mb-1">$00.00</p>
                  <p class="fw-medium mb-1 border-bottom pb-2">$50.00</p>
                  <p class="fw-medium mb-0 pt-2">$204.25</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <hr class="mt-0 mb-6" />
        <div class="card-body p-0">
          <div class="row">
            <div class="col-12">
              <span class="fw-medium text-heading">Note:</span>
              <span
                >It was a pleasure working with you and your team. We hope you will keep us in mind for
                future freelance projects. Thank You!</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
      <div class="card">
        <div class="card-body">
          <button
            class="btn btn-primary d-grid w-100 mb-4"
            data-bs-toggle="offcanvas"
            data-bs-target="#sendInvoiceOffcanvas">
            <span class="d-flex align-items-center justify-content-center text-nowrap"
              ><i class="ri-send-plane-line ri-16px scaleX-n1-rtl me-2"></i>Send Invoice</span
            >
          </button>
          <button class="btn btn-outline-secondary d-grid w-100 mb-4">Download</button>
          <div class="d-flex mb-4">
            <a
              class="btn btn-outline-secondary d-grid w-100 me-4"
              target="_blank"
              href="./app-invoice-print.html">
              Print
            </a>
            <a href="./app-invoice-edit.html" class="btn btn-outline-secondary d-grid w-100"> Edit </a>
          </div>
          <button
            class="btn btn-success d-grid w-100"
            data-bs-toggle="offcanvas"
            data-bs-target="#addPaymentOffcanvas">
            <span class="d-flex align-items-center justify-content-center text-nowrap"
              ><i class="ri-money-dollar-circle-line ri-16px me-2"></i>Add Payment</span
            >
          </button>
        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>

  <!-- Offcanvas -->
  <!-- Send Invoice Sidebar -->
  <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title">Send Invoice</h5>
      <button
        type="button"
        class="btn-close text-reset"
        data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form>
        <div class="form-floating form-floating-outline mb-5">
          <input
            type="text"
            class="form-control"
            id="invoice-from"
            value="shelbyComapny@email.com"
            placeholder="company@email.com" />
          <label for="invoice-from">From</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <input
            type="text"
            class="form-control"
            id="invoice-to"
            value="qConsolidated@email.com"
            placeholder="company@email.com" />
          <label for="invoice-to">To</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <input
            type="text"
            class="form-control"
            id="invoice-subject"
            value="Invoice of purchased Admin Templates"
            placeholder="Invoice regarding goods" />
          <label for="invoice-subject">Subject</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <textarea class="form-control" name="invoice-message" id="invoice-message" style="height: 190px">
Dear Queen Consolidated,
Thank you for your business, always a pleasure to work with you!
We have generated a new invoice in the amount of $95.59
We would appreciate payment of this invoice by 05/11/2021</textarea
          >
          <label for="invoice-message">Message</label>
        </div>
        <div class="mb-5">
          <span class="badge bg-label-primary rounded-pill">
            <i class="ri-links-line ri-14px me-1"></i>
            <span class="align-middle">Invoice Attached</span>
          </span>
        </div>
        <div class="mb-4 d-flex flex-wrap">
          <button type="button" class="btn btn-primary me-4" data-bs-dismiss="offcanvas">Send</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- /Send Invoice Sidebar -->

  <!-- Add Payment Sidebar -->
  <div class="offcanvas offcanvas-end" id="addPaymentOffcanvas" aria-hidden="true">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title">Add Payment</h5>
      <button
        type="button"
        class="btn-close text-reset"
        data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <div class="d-flex justify-content-between bg-lighter p-2 mb-5">
        <p class="mb-0">Invoice Balance:</p>
        <p class="fw-medium mb-0">$5000.00</p>
      </div>
      <form>
        <div class="input-group input-group-merge mb-5">
          <span class="input-group-text">$</span>
          <div class="form-floating form-floating-outline">
            <input
              type="text"
              id="invoiceAmount"
              name="invoiceAmount"
              class="form-control invoice-amount"
              placeholder="100" />
            <label for="invoiceAmount">Payment Amount</label>
          </div>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <input id="payment-date" class="form-control invoice-date" type="text" />
          <label for="payment-date">Payment Date</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <select class="form-select" id="payment-method">
            <option value="" selected disabled>Select payment method</option>
            <option value="Cash">Cash</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Debit Card">Debit Card</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Paypal">Paypal</option>
          </select>
          <label for="payment-method">Payment Method</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <textarea class="form-control" id="payment-note" style="height: 62px"></textarea>
          <label for="payment-note">Internal Payment Note</label>
        </div>
        <div class="d-flex flex-wrap">
          <button type="button" class="btn btn-primary me-4" data-bs-dismiss="offcanvas">Send</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- /Add Payment Sidebar -->
@endsection


@section('javascript')

@endsection
@extends('backend.components.header')

@section('css')
<style>
    #Payslip .pay-slip {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 20px;
        margin: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    #Payslip .header {
        background-color: #86cdec;
        color: #ffffff;
        padding: 15px;
        border-radius: 0.25rem 0.25rem 0 0;
        text-align: center;
        font-size: 1.75rem;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    #Payslip .content {
        margin-top: 20px;
    }
    #Payslip .footer-slip {
        background-color: #707384;
        color: #ffffff;
        padding: 10px;
        border-radius: 0 0 0.25rem 0.25rem;
        text-align: center;
        margin-top: 20px;
        font-size: 0.9rem;
        font-weight: bold;
    }
    #Payslip .title {
        font-weight: bold;
        color: #707384;
        text-transform: uppercase;
    }
    #Payslip .details-row {
        margin-bottom: 15px;
    }
    #Payslip .amount {
        font-size: 1.2rem;
        font-weight: bold;
        color: #343a40;
    }
    hr {
        border-top: 1px solid #dee2e6;
    }
    #Payslip .form-label {
        font-weight: bold;
        color: #343a40;
    }
    #Payslip i{
        font-weight: 500;
    }
</style>
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
<div class="row" id="Payslip">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0">Generate Salary Slip</h5>
            </div>
            <hr>
            <div class="card-body py-0">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="monthpicker">Select Month:</label>
                            <input type="text" class="form-control" id="monthpicker" name="month" placeholder="Select Month" readonly>
                            <div id="monthError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="col-2 mb-3 mt-8">
                        <div class="mb-4">
                            <button class="btn btn-label-primary w-100" type="button" onclick="getStaffSalaryDetails()">Generate</button>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
                <div class="col-12"  id="slipContent">
                    <div class="container pt-5">
                        <div class="pay-slip">
                            <div class="header">
                                Pay Slip
                            </div>
                            <div class="content">
                                <div class="row details-row">
                                    <div class="col-6">
                                        <p class="title">Employee Name:</p>
                                        <p>{{$data->f_name ?? "-"}} {{$data->m_name ?? ""}} {{$data->l_name ?? ""}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="title">Employee ID:</p>
                                        <p>{{$data->staff_id ?? "-"}}</p>
                                    </div>
                                </div>
                                <div class="row details-row">
                                    <div class="col-6">
                                        <p class="title">Department:</p>
                                        <p>Staff</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="title">Designation:</p>
                                        <p>{{$data->types->title ?? "-"}}</p>
                                    </div>
                                </div>
                                <div class="row details-row">
                                    <div class="col-6">
                                        <p class="title">Pay Date:</p>
                                        <p>{{date('d/m/Y')}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="title">Pay Period:</p>
                                        <p id="PayMonth"></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row details-row">
                                    <div class="col-6">
                                        <p class="title">Basic Salary:</p>
                                        <p class="amount">₹3000</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="title">Allowances:</p>
                                        <p class="amount">₹500</p>
                                    </div>
                                </div>
                                <div class="row details-row">
                                    <div class="col-6">
                                        <p class="title">Deductions:</p>
                                        <p class="amount">₹200</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="title">Net Pay:</p>
                                        <p class="amount">₹3300</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-slip">
                                <i class="ri-registered-line"></i> Deven Health Care | <i class="ri-mail-line"></i> devenhealthcare202@gmail.com | <i class="ri-phone-line"></i> +91 8866451769 | <i class="ri-global-line"></i> www.devenhealthcare.com
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center my-10">
                    <button class="btn btn-danger waves-effect me-2" onclick="PrintInvoice()"><i class="ri-printer-line"></i>&nbsp; Print</button>
                    <button class="btn btn-dark waves-effect" onclick="DownloadInvoice()"><i class="ri-download-2-line"></i>&nbsp; Download</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script>
    function PrintInvoice() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const padding = 0;

        html2canvas(document.querySelector("#slipContent")).then(canvas => {
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

    function DownloadInvoice(){
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const padding = 0;

        html2canvas(document.querySelector("#slipContent")).then(canvas => {
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
            var name = "{{$data->staff_id}}" + ".pdf";
            pdf.save(name);
        });
    }
    function getStaffSalaryDetails(){
        var month = $('#monthpicker').val();
        $('#PayMonth').text(month);
    }
    $(document).ready(function() {
        // Get the current date
        var currentDate = new Date();
        // Format the date to yyyy-mm
        var formattedDate =  ('0' + (currentDate.getMonth() + 1)).slice(-2) + ' ' + currentDate.getFullYear();

        // Initialize the datepicker
        $('#monthpicker').datepicker({
            format: "M yyyy",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        }).datepicker('setDate', formattedDate);

        getStaffSalaryDetails();
    });
</script>
@endsection

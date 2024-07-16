@extends('backend.components.header')

@section('css')
<style>
    #dt-length-0{
        margin-top: 25px;
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

<div class="row">
    <div class="col-6 mb-5">
        <h4 class="mt-1 mb-1">Staff Advance Salary History</h4>
        <p class="mb-0"><a href="{{route('dashboard')}}">Home</a> / Advance Salary /Staff Advance Salary History</p>
    </div>
    <div class="col-6 mb-5 text-end pt-5 pe-5">
        <a id="exportLink" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 waves-effect waves-light me-2"><i class="ri-file-excel-line"></i> <span class="nav-text">Excel</span></a>
    </div>
    <div class="col-12">
        <!-- Role Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="kt_datatable" class="table table-row-bordered table-row-gray-300">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Month</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Added By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody id="TData">
                        @if(!empty($data))
                            @foreach($data as $key => $da)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$da->staff->staff_id ?? "-"}}</td>
                                    <td>{{$da->staff->f_name . " " . $da->staff->m_name . " " . $da->staff->l_name ?? "-"}}</td>
                                    <td>{{$da->month}}</td>
                                    <td>{{$da->amount}}</td>
                                    @if($da->type == 0)
                                    <td class="text-danger">Deducted</td>
                                    @else
                                    <td class="text-success">Added</td>
                                    @endif
                                    <td>{{$da->created_by_user->name ?? "-"}}</td>
                                    <td>{{date('d/m/Y H:s A',strtotime($da->created_at))}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    $('#kt_datatable').DataTable({
        dom: `<'row'<'col-sm-12'lBtr>>
        <'row'<'col-sm-12 col-md-8'i><'col-sm-12 col-md-4 d-flex justify-content-end align-items-center'p>>`,
        pageLength: 10,
        scrollX: true,
        buttons: [{
            extend: 'excel',
            title: 'Advance Salary History',
            exportOptions: {
                columns: [1,2,3,4,5,6,7]
            }
        }],
        columnDefs: [{
            "defaultContent": "-",
            "targets": "_all",
        }],
        initComplete: function() {
            var api = this.api();
            var row = $('<tr>').appendTo($(api.table().header()));
            api.columns().every(function() {
                var column = this;
                var title = $(column.header()).text(); // Get the title from the original header
                var input = $('<input>', {
                    type: 'text',
                    placeholder: 'Search ' + title,
                    class: 'form-control form-control-sm my-2'
                }).appendTo($('<th>').appendTo(row));

                input.on('keyup change clear', function() {
                    if (column.search() !== this.value) {
                        column.search(this.value).draw();
                    }
                });
            });

            var $buttons = $('.dt-buttons').hide();
            $('#exportLink').on('click', function() {
                var btnClass = ".buttons-excel";
                if (btnClass) $buttons.find(btnClass).click();
            })
        },
    });
</script>
@endsection
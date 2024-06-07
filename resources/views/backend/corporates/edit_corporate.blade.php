@extends('backend.components.header')

@section('css')

@endsection

@section('content')
<div class="container">
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
</div>
<div class="row">
    <div class="col-12">
        <div class="card py-5">
            <div class="mx-5">
                <h5 class="mb-0">Edit Corporate</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('update_corporate')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Corporate Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control d-none" value="{{$data->id}}" name="id"/>
                                <input type="text" class="form-control mb-1" value="{{$data->name}}" name="name"  placeholder="Enter full name"/>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Contact Number 1<span class="text-danger">*</span></label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{$data->mobile1}}" name="mobile1"  placeholder="Enter contact number 1"/>
                                @error('mobile1')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Contact Number 2<span class="text-danger">*</span></label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{$data->mobile2}}" name="mobile2"  placeholder="Enter contact number 2"/>
                                @error('mobile2')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{$data->address}}" name="address" placeholder="Enter address"/>
                                @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="state" id="State" onchange="selectState()">
                                    <option value=""></option>
                                    @if(!empty($states))
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if($data->state == $state->id) selected @endif>{{$state->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('state')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="city" id="City" onchange="selectCity()">
                                    <option value=""></option>
                                    @if(!empty($cities))
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" class="d-none" @if($data->city == $city->id) selected @endif data-state-id="{{$city->state_id}}">{{$city->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Area<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="area" id="Area">
                                    <option value=""></option>
                                    @if(!empty($area))
                                        @foreach($area as $ar)
                                            <option value="{{$ar->id}}" class="d-none" @if($data->area == $ar->id) selected @endif data-city-id="{{$ar->city_id}}">{{$ar->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('area')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('corporates')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
function selectState() {
    var id = $('#State').val();
    $.ajax({
        url:"{{route('get_cities_by_state')}}",
        method:"POST",
        data:{'id':id,_token:"{{ csrf_token() }}"},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(result)
        {
            var cities = result.data;
            var citySelect = $('#City');
            citySelect.empty().append('<option value=""></option>');
            cities.forEach(function(city) {
                citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
            });
            citySelect.val(null).trigger('change');
            $('#Area').val(null).trigger('change');
            
        }
    }); 
}

function selectCity() {
    var id = $('#City').val();
    $.ajax({
        url: "{{route('get_areas_by_city')}}",
        method: "POST",
        data: {
            'id': id,
            _token: "{{ csrf_token() }}"
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            var areas = result.data;
            var areaSelect = $('#Area');
            areaSelect.empty().append('<option value=""></option>');
            areas.forEach(function(area) {
                areaSelect.append('<option value="' + area.id + '">' + area.name + '</option>');
            });
            areaSelect.val(null).trigger('change');
        }
    });
}
$('#State').select2({
    placeholder: 'Select a state'
});
$('#City').select2({
    placeholder: 'Select a city'
});
$('#Area').select2({
    placeholder: 'Select a area'
});
</script>
@endsection
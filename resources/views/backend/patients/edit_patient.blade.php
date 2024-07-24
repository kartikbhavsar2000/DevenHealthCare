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
                <h5 class="mb-0">Edit Patient | {{$data->patient_id}}</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('update_patient')}}" method="POST">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-4">
                                <label class="form-label">Hospital Type <span class="text-danger">*</span></label><br>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="radio" value="DHC" name="h_type" @if($data->h_type == "DHC") checked @endif id="dhcradio" onclick="checkHospitalType()">
                                    <label class="form-check-label" for="dhcradio">
                                        DHC
                                    </label>
                                </div>
                                <div class="form-check form-check-inline mt-4 me-12">
                                    <input class="form-check-input" type="radio" value="Other" @if($data->h_type != "DHC") checked @endif name="h_type" id="otherradio" onclick="checkHospitalType()">
                                    <label class="form-check-label" for="otherradio">
                                        Other
                                    </label>
                                </div>
                                @error('h_type')
                                    <br><span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-9 mb-3 d-none OthersCheck">
                            <div class="mb-4">
                                <label class="form-label">Select Hospital <span class="text-danger">*</span></label>
                                <select id="Hospital-Select" class="select2 form-select" name="h_other_type">
                                    <option></option>
                                    @if(!empty($hospitals))
                                        @foreach($hospitals as $hospital)
                                            <option value="{{$hospital->name}}" @if($data->h_type == $hospital->name) selected @endif>{{$hospital->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('h_other_type')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-3">
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control d-none" value="{{$data->id}}" name="id"/>
                                <input type="text" class="form-control mb-1" value="{{$data->name}}" name="name"  placeholder="Enter full name"/>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Email Address</label>
                                <input type="text" class="form-control mb-1" value="{{$data->email}}" name="email"  placeholder="Enter email address"/>
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Contact Number</label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{$data->mobile}}" name="mobile"  placeholder="Enter contact number"/>
                                @error('mobile')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Alternet Contact Number</label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{$data->mobile2}}" name="mobile2"  placeholder="Enter alternet contact number"/>
                                @error('mobile2')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="gender" id="Gender">
                                    <option></option>
                                    <option value="Male" @if($data->gender == "Male") selected @endif>Male</option>
                                    <option value="Female" @if($data->gender == "Female") selected @endif>Female</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Date Of Birth</label>
                                <input type="text" class="form-control mb-1" value="{{$data->dob}}"  name="dob" placeholder="DD-MM-YYYY" id="dob" readonly />
                                @error('dob')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Age</label>
                                <input type="number" class="form-control mb-1" value="{{$data->age}}" name="age"  placeholder="Enter age"/>
                                @error('age')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
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
                                </select>
                                @error('area')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control mb-1" value="{{$data->reference}}" name="reference" placeholder="Enter reference">
                                @error('reference')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('patients')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    checkHospitalType();
    selectState();
    function checkHospitalType(){
        var value = $('input[name="h_type"]:checked').val();
        if(value == "DHC"){
            $('.OthersCheck').addClass('d-none');
        }else if(value == "Other"){
            $('.OthersCheck').removeClass('d-none');
        }
    }
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
                var cityyy = '{{$data->city}}';
                console.log("City : " + cityyy);
                citySelect.empty().append('<option value=""></option>');
                cities.forEach(function(city) {
                    if(cityyy == city.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    citySelect.append('<option value="' + city.id + '" ' + selected + '>' + city.name + '</option>');
                });
                selectCity();
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
                var areaaa = '{{$data->area}}';
                console.log("Area : " + areaaa);
                areaSelect.empty().append('<option value=""></option>');
                areas.forEach(function(area) {
                    if(areaaa == area.id){
                        var selected = "selected";
                    }else{
                        var selected = "";
                    }
                    areaSelect.append('<option value="' + area.id + '" ' + selected + '>' + area.name + '</option>');
                });
            }
        });
    }
    
</script>
<script>
$('#Hospital-Select').select2({
    placeholder: 'Select a hospital'
});
$('#Gender').select2({
    placeholder: 'Select a gender'
});
$('#State').select2({
    placeholder: 'Select a state'
});
$('#City').select2({
    placeholder: 'Select a city'
});
$('#Area').select2({
    placeholder: 'Select a area'
});
$('#dob').flatpickr({
    altInput: true,
    altFormat: 'd-m-Y',
    dateFormat: 'Y-m-d',
    maxDate: new Date()
});
</script>
@endsection
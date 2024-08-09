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
                <h5 class="mb-0">Add Staff</h5>
            </div>
            <hr>
            <form id="Form" action="{{route('create_staff')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body py-0">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('f_name')}}" name="f_name"  placeholder="Enter first name"/>
                                @error('f_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control mb-1" value="{{old('m_name')}}" name="m_name"  placeholder="Enter middle name"/>
                                @error('m_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control mb-1" value="{{old('l_name')}}" name="l_name"  placeholder="Enter last name"/>
                                @error('l_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Type<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="type" id="Type">
                                    <option></option>
                                    @if(!empty($staff_type))
                                        @foreach($staff_type as $data)
                                            <option value="{{$data->id}}" @if(old('type') == $data->id) selected @endif>{{$data->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('type')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Email Address</label>
                                <input type="text" class="form-control mb-1" value="{{old('email')}}" name="email"  placeholder="Enter email address"/>
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Contact Number</label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile')}}" name="mobile"  placeholder="Enter contact number"/>
                                @error('mobile')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Alternate Contact Number</label>
                                <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{old('mobile2')}}" name="mobile2"  placeholder="Enter alternate contact number"/>
                                @error('mobile2')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Address<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('address')}}" name="address" placeholder="Enter address"/>
                                @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('state')}}" name="state" placeholder="Enter state"/>
                                @error('state')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">City<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('city')}}" name="city" placeholder="Enter city"/>
                                @error('city')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Area<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('area')}}" name="area" placeholder="Enter area"/>
                                @error('area')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-4 mb-3">
                            <div class="mb-4">
                                <label class="form-label">State<span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="state" id="State" onchange="selectState()">
                                    <option value=""></option>
                                    @if(!empty($states))
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" @if(old('state') == $state->id) selected @endif>{{$state->name}}</option>
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
                                <div class="d-flex">
                                    <select class="form-control mb-1" name="area" id="Area">
                                        <option value=""></option>
                                    </select>
                                    <a class="ms-2 btn btn-label-primary" onclick="openCenteredWindow('{{ route('add_area') }}', 'MyWindow', 600, 600);"><i class="ri-add-line"></i></a>
                                </div>
                                @error('area')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control mb-1" name="gender" id="Gender">
                                    <option></option>
                                    <option value="Male" @if(old('gender') == "Male") selected @endif>Male</option>
                                    <option value="Female" @if(old('gender') == "Female") selected @endif>Female</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Age</label>
                                <input type="number" min="18" max="60" class="form-control mb-1" value="{{old('age')}}" name="age"  placeholder="Enter age"/>
                                @error('age')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Date Of Birth</label>
                                <input type="text" class="form-control mb-1" value="{{old('dob')}}"  name="dob" placeholder="DD-MM-YYYY" id="dob" readonly />
                                @error('dob')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Date Of Joining<span class="text-danger">*</span></label>
                                <input type="text" class="form-control mb-1" value="{{old('doj')}}" name="doj" placeholder="DD-MM-YYYY" id="doj" readonly />
                                @error('doj')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Experience <span class="text-danger">*</span></label>
                                <input type="number" class="form-control mb-1" value="{{old('experience')}}" name="experience" placeholder="Enter experience" title="Please enter a valid number (integer or decimal)." >
                                @error('experience')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Qualification</label>
                                <input type="text" class="form-control mb-1" value="{{old('qualification')}}" name="qualification" placeholder="Enter qualification" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                @error('qualification')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Specification</label>
                                <input type="text" class="form-control mb-1" value="{{old('specification')}}" name="specification" placeholder="Enter specification" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                @error('specification')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control mb-1" value="{{old('reference')}}" name="reference" placeholder="Enter reference" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                @error('reference')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-upload-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Upload Documents</h5>
                        <hr>
                        <div class="col-12 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Select Documents</label>
                                <input type="file" class="form-control mb-1" name="documents[]" multiple accept=".jpeg, .jpg, .png, .pdf">
                                @error('documents')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-bank-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Bank Detaiils</h5>
                        <hr>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control mb-1" value="{{old('bank_name')}}" name="bank_name" placeholder="Enter bank name" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                @error('bank_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control mb-1" value="{{old('acc_no')}}" name="acc_no" placeholder="Enter account number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                                @error('acc_no')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Branch</label>
                                <input type="text" class="form-control mb-1" value="{{old('branch')}}" name="branch" placeholder="Enter branch" onkeyup="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                @error('branch')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="mb-4">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" class="form-control mb-1" value="{{old('ifsc_code')}}" name="ifsc_code" placeholder="Enter IFSC code" onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
                                @error('ifsc_code')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-time-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Shifts</h5>
                        <hr>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Day Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Staff Rate / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{old('day_cost')}}" name="day_cost" placeholder="00">
                                </div>
                                @error('day_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Night Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Staff Rate / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{old('night_cost')}}" name="night_cost" placeholder="00">
                                </div>
                                @error('night_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-start align-items-center">
                            <div class="px-5">
                                <h6>Fullday Shift :</h6>
                            </div>
                        </div>
                        <div class="col-10 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Staff Rate / Shift</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{old('full_cost')}}" name="full_cost" placeholder="00">
                                </div>
                                @error('full_cost')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-lock-password-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Security</h5>
                        <hr>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control mb-1" name="password" placeholder="Enter password">
                                @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="mb-4">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control mb-1" name="password_confirmation" placeholder="Enter confirm password">
                                @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-footer">
                    <button type="submit" id="Submit" class="btn btn-flex btn-primary h-40px fs-7 fw-bold me-1">Submit</button>
                    <a href="{{route('staff')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('javascript')
<script>
    selectState();
    function openCenteredWindow(url, windowName, width, height) {
        $('#State').val("").trigger('change');
        $('#City').val("").trigger('change');
        // Calculate the position of the window to be centered
        var left = (screen.width - width) / 2;
        var top = (screen.height - height) / 2;

        // Define window options
        var options = 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left;

        // Open the window
        window.open(url, windowName, options);

        // Prevent the default behavior of the anchor tag
        return false;
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
                var cityyy = '{{old("city")}}';
                
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
                var areaaa = '{{old("area")}}';
                console.log();
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
$('#Gender').select2({
    placeholder: 'Select a gender'
});
$('#Type').select2({
    placeholder: 'Select a type'
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
$('#doj').flatpickr({
    altInput: true,
    altFormat: 'd-m-Y',
    dateFormat: 'Y-m-d',
    maxDate: new Date()
});
</script>
@endsection
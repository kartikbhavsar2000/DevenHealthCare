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
            <div class="mx-5 row">
                <div class="col-6 p-0 pt-1">
                    <h5 class="mb-0"><i class="ri-information-line fs-3"></i> View Staff Details | {{$data->staff_id}}</h5>
                </div>
                <div class="col-6 text-end p-0">
                    <a href="{{route('staff')}}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold waves-effect waves-light">Back</a>
                </div>
            </div>
            <hr>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control d-none" value="{{$data->id}}" name="id"/>
                            <input type="text" class="form-control mb-1" value="{{$data->f_name}}" name="f_name"  placeholder="Enter first name" readonly/>
                            @error('f_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" class="form-control mb-1" value="{{$data->m_name}}" name="m_name"  placeholder="Enter middle name" readonly/>
                            @error('m_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control mb-1" value="{{$data->l_name}}" name="l_name"  placeholder="Enter last name" readonly/>
                            @error('l_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Type</label>
                            <select class="form-control" name="type" id="Type" disabled>
                                <option></option>
                                @if(!empty($staff_type))
                                    @foreach($staff_type as $da)
                                        <option value="{{$da->id}}" @if($data->type == $da->id) selected @endif>{{$da->title}}</option>
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
                            <input type="email" class="form-control" value="{{$data->email}}" name="email"  placeholder="Enter email address" readonly />
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Contact Number</label>
                            <input type="text" minlength="7" maxlength="10" class="form-control" value="{{$data->mobile}}" name="mobile"  placeholder="Enter contact number" readonly />
                            @error('mobile')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Alternate Contact Number</label>
                            <input type="text" minlength="7" maxlength="10" class="form-control mb-1" value="{{$data->mobile2}}" name="mobile2"  placeholder="Enter alternate contact number" readonly/>
                            @error('mobile2')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" value="{{$data->address}}" name="address" placeholder="Enter address" readonly />
                            @error('address')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="mb-4">
                            <label class="form-label">State</label>
                            <select class="form-control mb-1" name="state" id="State" disabled>
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
                            <label class="form-label">City</label>
                            <select class="form-control mb-1" name="city" id="City" disabled>
                                <option value=""></option>
                                @if(!empty($cities))
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if($data->city == $city->id) selected @endif data-state-id="{{$city->state_id}}">{{$city->name}}</option>
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
                            <label class="form-label">Area</label>
                            <select class="form-control mb-1" name="area" id="Area" disabled>
                                <option value=""></option>
                                @if(!empty($area))
                                    @foreach($area as $ar)
                                        <option value="{{$ar->id}}" @if($data->area == $ar->id) selected @endif data-city-id="{{$ar->city_id}}">{{$ar->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('area')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Gender</label>
                            <select class="form-control" name="gender" id="Gender" disabled>
                                <option></option>
                                <option value="Male" @if($data->gender == "Male") selected @endif>Male</option>
                                <option value="Female" @if($data->gender == "Female") selected @endif>Female</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Age</label>
                            <input type="number" min="18" max="60" class="form-control" value="{{$data->age}}" name="age"  placeholder="Enter age" readonly />
                            @error('age')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Date Of Birth</label>
                            <input type="text" class="form-control" value="{{$data->dob}}"  name="dob" placeholder="Month DD, YYYY" id="dob" disabled />
                            @error('dob')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Date Of Joining</label>
                            <input type="text" class="form-control" value="{{$data->doj}}" name="doj" placeholder="Month DD, YYYY" id="doj" disabled />
                            @error('doj')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Experience</label>
                            <input type="text" class="form-control" value="{{$data->experience}}" name="experience" pattern="^\d*(\.\d+)?$" placeholder="Enter experience" title="Please enter a valid number (integer or decimal)." readonly />
                            @error('experience')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Qualification</label>
                            <input type="text" class="form-control" value="{{$data->qualification}}" name="qualification" placeholder="Enter qualification" readonly />
                            @error('qualification')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Specification</label>
                            <input type="text" class="form-control" value="{{$data->specification}}" name="specification" placeholder="Enter specification" readonly />
                            @error('specification')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Reference</label>
                            <input type="text" class="form-control" value="{{$data->reference}}" name="reference" placeholder="Enter reference" readonly />
                            @error('reference')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    @if(!empty($data->documents))
                        <hr class="mt-5 mb-3">
                        <h5><i class="ri-image-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Documents</h5>
                        <hr>
                        <div class="col-12 mb-3">
                            <div class="row my-3">
                                @foreach($data->documents as $doc)
                                <div class="col-2 border border-2 border-primary rounded ms-5 mb-5 p-2 position-relative d-flex justify-content-center align-items-center">
                                    @php
                                        $filePath = asset('public/staff_documents/' . $doc->name);
                                        $extension = pathinfo($doc->name, PATHINFO_EXTENSION);
                                    @endphp
                                
                                    @if ($extension === 'pdf')
                                        {{-- Display PDF thumbnail --}}
                                        <a href="{{ $filePath }}" target="_blank" class="text-center">
                                            <img src="{{ asset('public/assets/images/pdf_logo.png') }}" class="img-fluid" style="max-height: 100px;"><br>
                                            <i class="ri-eye-line mt-3"></i> View File
                                        </a>
                                    @else
                                        {{-- Display image --}}
                                        <a href="{{ $filePath }}" target="_blank">
                                            <img src="{{ $filePath }}" class="img-fluid" style="max-height: 200px;">
                                        </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <hr class="mt-5 mb-3">
                    <h5><i class="ri-bank-line fs-5 text-white bg-dark px-2 py-2 rounded"></i> Bank Detaiils</h5>
                    <hr>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control" value="{{$data->bank_name}}" name="bank_name" placeholder="Enter bank name" readonly/>
                            @error('bank_name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" value="{{$data->acc_no}}" name="acc_no" placeholder="Enter account number" readonly/>
                            @error('acc_no')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">Branch</label>
                            <input type="text" class="form-control" value="{{$data->branch}}" name="branch" placeholder="Enter branch" readonly/>
                            @error('branch')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-3 mb-3">
                        <div class="mb-4">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" class="form-control" value="{{$data->ifsc_code}}" name="ifsc_code" placeholder="Enter IFSC code" readonly/>
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
                                <input type="text" class="form-control" value="{{$data->day_cost}}" name="day_cost" placeholder="00" readonly/>
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
                                <input type="text" class="form-control" value="{{$data->night_cost}}" name="night_cost" placeholder="00" readonly/>
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
                                <input type="text" class="form-control" value="{{$data->full_cost}}" name="full_cost" placeholder="00" readonly/>
                            </div>
                            @error('full_cost')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
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
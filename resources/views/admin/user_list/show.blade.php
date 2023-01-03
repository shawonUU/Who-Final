{{-- @extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Details</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content-page-show">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('admin.user_list.show_fields')
                </div>
            </div>

        </div>
    </div>
@endsection --}}

@extends('layouts.app')
@section('title')
    {{__('User Details')}}
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title float-left pt-2"> {{__('User Profile')}}</h2>
                </div>
                <div class="card-body">

                    <div class="row">

                        <!-- Profile Image -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        {{-- <div class="col-md-12 text-center ">
                                            <img id="currentPhoto" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="Profile Image" style="max-height: 150px;border-radius: 10px;">
                                        </div> --}}

                                        <div class="col-md-12">
                                            <br>
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>{{__('HRS ID')}}</th>
                                                    <td>
                                                        {{ $user->hrs_id }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Status')}}</th>
                                                    <td>
                                                       @if(!$user->has_any_banned_record)
                                                           @if($user->status == 'active')
                                                               <span class="badge badge-success">{{__('Active')}}</span>
                                                            @else
                                                               <span class="badge badge-danger">{{__('Inactive')}}</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-danger">{{__('Banned')}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Phone')}}</th>
                                                    <td>
                                                        {{$user->phone}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Age')}}</th>
                                                    <td>
                                                        {{$user->age}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Gender')}}</th>
                                                    <td>
                                                        {{$user->getGender()}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Organization')}}</th>
                                                    <td>
                                                        {{$user->organization}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Designation')}}</th>
                                                    <td>
                                                        {{$user->getDesignation()}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Division')}}</th>
                                                    <td>
                                                        {{$user->getDivision()}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('District')}}</th>
                                                    <td>
                                                        {{$user->getDistrict()}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__('Upazila')}}</th>
                                                    <td>
                                                        {{$user->getUpazila()}}
                                                    </td>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Details -->
                        <div class="col-md-7">
                            <div class="card">
                                <!--Show Validation error message !-->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                <div class="card-body">
                                    <form action="{{route('admin.user.update',$user->id)}}" enctype="multipart/form-data" method="POST">
                                        @method('POST')
                                        @csrf
                                        <div class="row">
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label> {{__('Name')}}</label>
                                                <input value="{{$user->name}}"  type="text" name="name" class="form-control">
                                                <input value="{{$user->id}}" type="hidden" name="id">
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="division">{{ __('Division') }}</label>
                                                <select name="division_id" class="form-control divisionFilter"  required="required">
                                                    <option value="">{{ __('--Select One--') }}</option>
                                                    @foreach($divisions??[] as $key => $division)
                                                        <option value="{{ $key }}"  {{ $user->division_id == $key ? 'selected' : '' }}>{{ $division }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="district">{{ __('District') }}</label>
                                                <select name="district_id" class="form-control districtFilter"  required="required">
                                                    <option value="">{{ __('--Select One--') }}</option>
                                                    @foreach($districts??[] as $key => $district)
                                                        <option value="{{ $key }}"  {{ $user->district_id == $key ? 'selected' : '' }}>{{ $district }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="upazila">{{ __('Upazila') }}</label>
                                                <select name="upazila_id" class="form-control upazilaFilter"  required="required">
                                                    <option value="">{{ __('--Select One--') }}</option>
                                                    @foreach($upazilas??[] as $key => $upazila)
                                                        <option value="{{ $key }}"  {{ $user->upazila_id == $key ? 'selected' : '' }}>{{ $upazila }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label> {{__('Phone')}}</label>
                                                <input value="{{$user->phone}}"  type="number" name="phone" class="form-control">
                                            </div>

                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="age">{{ __('Designation') }}</label>
                                                <input value="{{ $user->designation  }}" type="text" class="form-control" name="designation" id="designation" required>
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="organization">{{ __('Organization') }}</label>
                                                <input value="{{ $user->organization }}" type="text" class="form-control" name="organization" id="organization" required>
                                            </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="gender">{{ __('Gender') }}</label>
                                                <select name="gender" class="form-control genderFilter"  required="required">
                                                  <option value="">{{ __('--Select One--') }}</option>
                                                  @foreach($genders_array??[] as $key => $gender)
                                                      <option value="{{ $key }}" {{ $user->gender == $key ? 'selected' : '' }}>{{ $gender['en'] }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="hrm_id">{{ __('HRS ID') }}</label>
                                                <input value="{{ $user->hrs_id }}" type="text" class="form-control" name="hrs_id" id="hrs_id" readonly required>
                                              </div>
                                            <div class=" form-group col-md-12 col-sm-12 col-12">
                                                <label for="age">{{ __('Age') }}</label>
                                                <input value="{{ $user->age  }}" type="number" class="form-control" name="age" id="age" required>
                                            </div>
                                           
                                                <div class=" form-group col-md-12 col-sm-12 col-12 text-left">
                                                    <span class="ml-4"> <input class="form-check-input checkbox" value="cps" type="checkbox"  name="change_pass" id="changePass"> {{__('Change Password')}}</span>
                                                </div>
                                                <div id="showPass" style="display: none;width: 100%">
                                                    <div class=" form-group col-md-12 col-sm-12 col-12">
                                                        <label>{{__('New Password')}}</label>
                                                        <input placeholder="{{__('Password')}}"  type="password" name="password" class="form-control">
                                                    </div>
                                                    <div class=" form-group col-md-12 col-sm-12 col-12">
                                                        <label>{{__('Confirm Password')}}</label>
                                                        <input placeholder="Confirm Password"  type="password" name="confirm_password" class="form-control">
                                                    </div>
                                                </div>
                                                <div class=" form-group col-md-12 col-sm-12 col-12">
                                                    <button class="btn btn-primary btn-block" type="submit" >{{__('Save Changes')}}</button>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@push('script')
    @include('admin.profile.script')
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
      
        $(document).ready(function () {
              $('.staffDesignationFilter').on('change', function () {
                  var designation_id = this.value;
                 if(designation_id=='')
                 designation_id ='0';
                  let designationTypeDiv = new Filter();
                  designationTypeDiv.getStaffDesignationType(designation_id);
              });
          });
      
          $(document).ready(function () {
              $('.divisionFilter').on('change', function () {
                  var division_id = this.value;
                 if(division_id=='')
                 division_id ='0';
                  let districtDiv = new Filter();
                  console.log(districtDiv);
                  districtDiv.getDistricts(division_id);
              });
          });
      
          $(document).ready(function () {
              $('.districtFilter').on('change', function () {
                  var district_id = this.value;
                  console.log(district_id);
                 if(district_id=='')
                 district_id ='0';
                  let upazilaDiv = new Filter();
                  console.log(upazilaDiv);
                  upazilaDiv.getUpazilas(district_id);
              });
          });
      
        </script>
@endpush



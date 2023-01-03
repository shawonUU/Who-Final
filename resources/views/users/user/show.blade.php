@extends('layouts.users.app')

@section('content')
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>{{ __('PROFILE') }}</h2>
          </div>
          <div class="validation-error-section section-title col-md-8 mx-auto">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="list-style-type: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

          <div class="row">

            <div class="col-lg-5 d-flex align-items-stretch ">
              <form action="{{route('user.image.update')}}" method="post" role="form" class="php-email-form" style="background: #EFFAFF" enctype="multipart/form-data"> @csrf
                <div class="container">
                  <div class="avatar-upload">
                      <div class="avatar-edit">
                          <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="photo" />
                          <label for="imageUpload"></label>
                      </div>
                      <div class="avatar-preview">
                          <div id="imagePreview" style="background-image: url({{ $user->getProfileImage() ??  'https://t4.ftcdn.net/jpg/02/15/84/43/360_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg'}});">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="text-center avatar-btn" id= 'avatar-btn' style="display:none"><button type="submit">{{ __('Change Profile Pic') }}</button></div>
            </form>
            </div>

            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
              <form action="{{route('user.update')}}" method="post" role="form" class="php-email-form" style="background: #EFFAFF">@csrf
                <div class="row">
                  <div class="form-group col-md-6">
                      <label for="name">{{ __('Full Name') }}</label>
                      <input value="{{ $user->name }}" type="text" class="form-control" name="name" id="name" required>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="division">{{ __('Division') }}</label>
                      <select name="division_id" class="form-control divisionFilter"  required="required">
                          <option value="">{{ __('--Select One--') }}</option>
                          @foreach($divisions??[] as $key => $division)
                              <option value="{{ $key }}"  {{ $user->division_id == $key ? 'selected' : '' }}>{{ $division }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="row">
                {{-- <div class="form-group col-md-6">
                  <label for="email">Email</label>
                  <input value="{{ $user->email  }}" type="email" class="form-control" name="email" id="email" required>
                </div> --}}
                <div class="form-group col-md-6">
                  <label for="district">{{ __('District') }}</label>
                  <select name="district_id" class="form-control districtFilter"  required="required">
                      <option value="">{{ __('--Select One--') }}</option>
                      @foreach($districts??[] as $key => $district)
                          <option value="{{ $key }}"  {{ $user->district_id == $key ? 'selected' : '' }}>{{ $district }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="upazila">{{ __('Upazila') }}</label>
                  <select name="upazila_id" class="form-control upazilaFilter"  required="required">
                      <option value="">{{ __('--Select One--') }}</option>
                      @foreach($upazilas??[] as $key => $upazila)
                          <option value="{{ $key }}"  {{ $user->upazila_id == $key ? 'selected' : '' }}>{{ $upazila }}</option>
                      @endforeach
                  </select>
                </div>
              </div>

              <div class="row">
                  <div class="form-group col-md-6">
                    <label for="phone">{{ __('Phone') }}</label>
                    <input value="{{ $user->phone }}" type="text" class="form-control" name="phone" id="phone" required>
                  </div>


                  <div class="form-group col-md-6">
                      <label for="hrm_id">{{ __('HRS ID') }}</label>
                      <input value="{{ $user->hrs_id }}" type="text" class="form-control" name="hrs_id" id="hrs_id" readonly required>
                    </div>
              </div>

              <div class="row">
                  {{-- <div class="form-group col-md-6">
                      <label for="designation">Designation</label>
                      <select name="designation" class="form-control designationFilter"  required="required">
                          <option value="">--Select One--</option>
                          @foreach($designation_array??[] as $key => $designation)
                              <option value="{{ $key }}"  {{$user->designation == $key ? 'selected' : '' }}>{{ $designation['en'] }}</option>
                          @endforeach
                      </select>
                  </div> --}}
                  <div class="form-group col-md-6">
                    <label for="age">{{ __('Designation') }}</label>
                    <input value="{{ $user->designation  }}" type="text" class="form-control" name="designation" id="designation" required>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="organization">{{ __('Organization') }}</label>
                      <input value="{{ $user->organization }}" type="text" class="form-control" name="organization" id="organization" required>
                  </div>
              </div>

              <div class="row">
                  <div class="form-group col-md-6">
                    <label for="gender">{{ __('Gender') }}</label>
                    <select name="gender" class="form-control genderFilter"  required="required">
                      <option value="">{{ __('--Select One--') }}</option>
                      @foreach($genders_array??[] as $key => $gender)
                          <option value="{{ $key }}" {{ $user->gender == $key ? 'selected' : '' }}>{{ $gender['en'] }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="age">{{ __('Age') }}</label>
                    <input value="{{ $user->age  }}" type="number" class="form-control" name="age" id="age" required>
                  </div>
              </div>

              <div class=" form-group col-md-12">
                <input class="checkbox" value="cps" type="checkbox"  name="change_pass" id="changePass">
                <label for="changePass"> {{__('Change Password')}} </label>
             </div>
             <div id="showPass" style="display: none;width: 100%">
                <div class="row">
                  <div class="form-group col-md-6">
                        <label class="col-md-4 control-label">{{ __('Password') }}</label>
                        <input id="password-field" type="password" class="form-control" name="password" value="">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                  </div>
                  <div class="form-group col-md-6">
                      <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                      <input value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                      <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-confirm-password"></span>
                    </div>
                </div>
            </div>

              <div class="row">

              </div>
                <div class="text-center"><button type="submit">{{ __('Update') }}</button></div>
              </form>
            </div>

          </div>

        </div>
      </section><!-- End Contact Section -->
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

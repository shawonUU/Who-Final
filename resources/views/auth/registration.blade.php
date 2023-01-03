@extends('layouts.users.app')
@section('content')
    <!-- ======= User Register Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
               <h2>{{ __('USER REGISTER') }}</h2>
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
            <div class="col-md-8 mt-5 mt-lg-0 d-flex align-items-stretch mx-auto">
              <form action="{{ route('user.create') }}" method="post" role="form" class="php-email-form" style="background: #EFFAFF">@csrf

                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('Full Name') }}</label>
                        <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="division">{{ __('Division') }}</label>
                        <select name="division_id" class="form-control divisionFilter"  required="required">
                            <option value="">{{ __('--Select One--') }}</option>
                            @foreach($divisions??[] as $key => $division)
                                <option value="{{ $key }}"  {{ old('division_id') == $division ? 'selected' : '' }}>{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                  {{-- <div class="form-group col-md-6">
                    <label for="email">{{ __('Email') }}</label>
                    <input value="{{ old('email') }}" type="email" class="form-control" name="email" id="email" required>
                  </div> --}}
                  <div class="form-group col-md-6">
                    <label for="district">{{ __('District') }}</label>
                    <select name="district_id" class="form-control districtFilter"  required="required">
                        <option value="">{{ __('--Select One--') }}</option>
                        @foreach($districts??[] as $key => $district)
                            <option value="{{ $key }}"  {{ old('district_id') == $district ? 'selected' : '' }}>{{ $district }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="upazila">{{ __('Upazila') }}</label>
                    <select name="upazila_id" class="form-control upazilaFilter"  required="required">
                        <option value="">{{ __('--Select One--') }}</option>
                        @foreach($upazilas??[] as $key => $upazila)
                            <option value="{{ $key }}"  {{ old('upazila_id') == $upazila ? 'selected' : '' }}>{{ $upazila }}</option>
                        @endforeach
                    </select>
                </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                      <label for="phone">{{ __('Phone') }}</label>
                      <input value="{{ old('phone') }}" type="text" class="form-control" name="phone" id="phone" required>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="hrm_id">{{ __('HRS ID') }}</label>
                        <input value="{{ old('hrs_id') }}" type="text" class="form-control" name="hrs_id" id="hrs_id" required>
                      </div>
                </div>

                <div class="row">
                    {{-- <div class="form-group col-md-6">
                        <label for="designation">{{ __('Designation') }}</label>
                        <select name="designation" class="form-control designationFilter"  required="required">
                            <option value="">{{ __('--Select One--') }}</option>
                            @foreach($designation_array??[] as $key => $designation)
                                <option value="{{ $key }}"  {{ old('designation') == $designation['en'] ? 'selected' : '' }}>{{ $designation['en'] }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group col-md-6">
                        <label for="phone">{{ __('Designation') }}</label>
                        <input value="{{ old('designation') }}" type="text" class="form-control" name="designation" id="designation" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="organization">{{ __('Organization') }}</label>
                        <input value="{{ old('organization') }}" type="text" class="form-control" name="organization" id="organization" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                      <label for="gender">{{ __('Gender') }}</label>
                      <select name="gender" class="form-control genderFilter"  required="required">
                        <option value="">{{ __('--Select One--') }}</option>
                        @foreach($genders_array??[] as $key => $gender)
                            <?php $name_en_bn = Session('APP_LOCALE') == 'en' ? 'en' : 'bn'; ?>
                            <option value="{{ $key }}" {{ old('gender') == $gender[$name_en_bn] ? 'selected' : '' }}>{{ $gender[$name_en_bn] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="age">{{ __('Age') }}</label>
                      <input value="{{ old('age') }}" type="number" class="form-control" name="age" id="age" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                      <label for="password">{{ __('Password') }}</label>
                      <input value="{{ old('password') }}" type="password" name="password" class="form-control" id="password-field" required>
                      <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                        <input value="{{ old('password_confirmation') }}" type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                        <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-confirm-password"></span>
                    </div>
                </div>
                <div class="text-center"><button type="submit">{{ __('Register') }}</button></div>
              </form>
            </div>
          </div>
        </div>
      </section><!-- End Contact Section -->

      @push('script')


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

  @endsection


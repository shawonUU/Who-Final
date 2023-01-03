@extends('layouts.users.app')
@section('content')
    <!-- ======= Login Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>{{ __('USER LOGIN') }}</h2>
            </div>
          <div class="row">
            <div class="col-md-8 d-flex align-items-stretch mx-auto ">
                <form action="{{ route('user.login') }}" method="post" role="form" class="php-email-form">@csrf
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="name">{{ __('Your HRS ID') }}</label>
                        <input type="text" name="hrs_id" class="form-control" id="hrs_id" required>
                      </div>
                      <div class="form-group col-12">
                        <label class="col-md-4 control-label">{{ __('Your Password') }}</label>
                        <input id="password-field" type="password" class="form-control" name="password" value="" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                      </div>
                    </div>
                    <div class="text-center"><button type="submit">{{ __('Login') }}</button></div>
                  </form>
            </div>
          </div>
        </div>
      </section><!-- End Contact Section -->
  @endsection

@extends('layouts.users.app')
@section('content')
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

          {{-- <div class="section-title">
            <h2>Contact</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
          </div>
   --}}
          <div class="row">

            <div class="col-lg-5 d-flex align-items-stretch">
                <form action="{{ route('user.login') }}" method="post" role="form" class="php-email-form">@csrf
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="name">Your Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                      </div>
                      <div class="form-group col-12">
                        <label for="name">Your Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                      </div>
                    </div>
                    <div class="text-center"><button type="submit">Login</button></div>
                  </form>

            </div>

            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
              <form action="forms/contact.php" method="post" role="form" class="php-email-form" style="background: #EFFAFF">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="user_name">User Name</label>
                    <input type="text" name="user_name" class="form-control" id="user_name" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name">Full Name</label>
                  <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                      <label for="gender">Gender</label>
                      <input type="text" name="gender" class="form-control" id="gender" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="age">Age</label>
                      <input type="number" class="form-control" name="age" id="age" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" class="form-control" name="designation" id="designation" required>
                </div>
                <div class="form-group">
                    <label for="institution">Institution</label>
                    <input type="text" class="form-control" name="institution" id="institution" required>
                </div>
                <div class="form-group">
                    <label for="division">Division</label>
                    <input type="text" class="form-control" name="division" id="division" required>
                </div>
                <div class="text-center"><button type="submit">Register</button></div>
              </form>
            </div>

          </div>

        </div>
      </section><!-- End Contact Section -->
  @endsection

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: #F6F6F6;width: 60%;
height: 70%;
position: absolute;
left: 60%;
top: 10%;
margin-left: -150px;
margin-top: -150px;
padding:20px;">
    <div class="modal-dialog modal-lg" role="document">
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
            {{-- <div class="text-center"><button type="submit">Login</button></div> --}}

          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Login')}}</button>
            </div>
          </form>
    </div>
</div>
{{-- <div class="custom-modal">
  <div class="custom-modal-content">
      <span class="custom-close-button">×</span>
      <h1>Hello, I am a modal!</h1>
  </div>
</div> --}}

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
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
      {{-- <div class="text-center"><button type="submit">Login</button></div> --}}

     <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button> --}}
          <button type="submit" class="btn btn-primary">{{__('Login')}}</button>
      </div>
    </form>
  </div>

</div>

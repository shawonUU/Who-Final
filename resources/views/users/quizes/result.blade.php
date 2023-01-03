@extends('layouts.users.app')
@section('style')

@endsection
<?php $auth = Auth::guard('admin')->user() ?>
@section('content')
<div class="container row align-items-center mx-auto mt-2">
    <div class="container-fluid mt-2">
        <div class="section-title">
            <h2 class="">Quiz Result</h2>
        </div>
    </div>
   <div class="col-md-9 mx-auto">
    <div class="form-contents-table">
        <div class="card" style="width: 100%; height:500px;">
            <img class="card-img-top" src="https://d24uab5gycr2uz.cloudfront.net/uploads/white_theme/images/quiz-img.png" alt="Card image cap" style="height:65%">
            <div class="card-body">
              <h5 class="card-title text-center text-success">Congratulations!</h5>
              <p class="card-text">
                <h4 class="text-center"> You Got {{ $result_details->total_correct }} out of {{ $result_details->total_question }}
                    <p class="text-center">Rate : {{ $result_details->result }}%</p>
              </p>
              <div class="row">
                <div class="col-6">
                    <a href="{{ $prev_content }}" class="btn btn-primary">Go back</a>
                </div>
                <div class="col-6">
                    <a href="{{ $next_content }}" class="btn btn-primary">Go Next</a>
                </div>
              </div>
            </div>
          </div>
    </div>
   </div>
</div>

@endsection

@push('script')
   
@endpush






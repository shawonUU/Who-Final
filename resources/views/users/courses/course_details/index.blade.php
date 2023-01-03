@extends('layouts.users.app')

@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
 @endsection

@section('content')
    <div class="card">
      <div class="card-body p-0">
          @include('users.courses.course_details.details')
      </div>
  </div>      
@endsection

@push('script')
 
@endpush


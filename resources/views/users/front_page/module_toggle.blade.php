@section('style')

@endsection
<div class="card mt-2 pt-3">
         <div class="section-title">
            <h2>{{ __('frontend_Course structure') }}</h2>
            {{-- <p>The course is composed of Seven modules:</p> --}}
          </div>

    <div class="accordian">
        <div class="togglediv">
              <div class="togglediv-header">
                   <h4>{{ __('পুষ্টি এক') }}</h4>
                   <span class="fa fa-minus"></span>
              </div>
              <div class="togglediv-body active">
                    <p>
                        <ul>
                              <li style="list-style-type: none">{{ __('মায়রে দুধ পান') }}</li>
                              <li style="list-style-type: none">{{ __('জি এম পি') }}</li>
                              <li style="list-style-type: none">{{ __('মুয়াক') }}</li>
                        </ul>
                    </p>
              </div>
        </div>

        <div class="togglediv">
              <div class="togglediv-header">
                   <h4>{{ __('পুষ্টি দুই') }}</h4>
                   <span class="fa fa-plus"></span>
              </div>
              <div class="togglediv-body">
                    <p>
                        <ul>
                              <li style="list-style-type: none">{{ __('মায়রে দুধ পান') }}</li>
                              <li style="list-style-type: none">{{ __('জি এম পি') }}</li>
                              <li style="list-style-type: none">{{ __('মুয়াক') }}</li>
                        </ul>
                    </p>
              </div>
        </div>
    </div>
</div>

@push('script')

@endpush

<div class="card">
    <div class="card-body">
        <form name="filter_form" method="get" class="col-12" action="{{ route($filter_route) }}">

            <div class="row py-1 px-1">

                <!--Division Filter -->
                <div class="form-group col-md-2">
                    <label for="">Division</label>
                    <select name="division_id" class="form-control divisionFilter">
                        <option value="">--Select One--</option>
                        @foreach($divisions??[] as $key => $division)
                            <option value="{{ $key }}" {{ request()->division_id == $key ? 'selected':'' }}>{{ $division }}</option>
                        @endforeach
                    </select>
                </div>
                <!--District Filter -->
                <div class="form-group col-md-2">
                    <label for="">District</label>
                    <select name="district_id" class="form-control districtFilter">
                        <option value="">--Select One--</option>
                        @foreach($districts??[] as $key => $district)
                            <option value="key" {{ request()->district_id == $key ? 'selected':'' }}>{{ $district }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="">Upazila</label>
                    <select name="upazila_id" class="form-control upazilaFilter">
                        <option value="">--Select One--</option>
                        @foreach($upazilas??[] as $key => $upazila)
                            <option value="{{ $key }}" {{ request()->upazila_id == $key ? 'selected':'' }}>{{ $upazila }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="col-auto">
                    <label for="">Action</label><br>
                    <button type="submit" class="btn btn-warning">Filter</button>
                    @if($filter === true)
                    <a href="{{ route($filter_route) }}" class="btn btn-light waves-effect waves-light ml-1"><i class="fa fa-eraser"></i> Clear</a>
                    @endif
                </div>

            </div>

        </form>
    </div>
</div>

@push('script')


<script type="text/javascript">
 var base_url = "{{ url('/') }}";

  $(document).ready(function () {
        $('.divisionFilter').on('change', function () {
            var division_id = this.value;
           if(division_id=='')
           division_id ='0';
            let districtDiv = new Filter();
            districtDiv.getDistricts(division_id);
        });
    });


    $(document).ready(function () {
        $('.districtFilter').on('change', function () {
            var district_id = this.value;
           if(district_id=='')
           district_id ='0';
            let upazilaDiv = new Filter();
            upazilaDiv.getUpazilas(district_id);
        });
    });



</script>

@endpush

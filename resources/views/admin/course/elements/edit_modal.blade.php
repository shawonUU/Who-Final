<div class="modal fade" id="courseEditModal{{$course->id}}" tabindex="-1" role="dialog" aria-labelledby="courseEditModal{{$course->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <form id="course_edit_modal_form" class="course_edit_modal_form" action="{{route('admin.course.update',[$course->id])}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Course Title == courseEditModal{{$course->id}}</label>
                        <input class="form-control" type="text" name="course_title" value="{{$course->course_title}}" placeholder="{{__('Course Title')}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
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

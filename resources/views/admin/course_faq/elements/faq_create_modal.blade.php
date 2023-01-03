<div class="modal fade" id="courseFAQCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
                
        <form id="course_edit_modal_form" class="course_faq_create_modal_form" action="{{route('admin.course_faq.store')}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>{{ __('Course') }}</label>
                        <select name="course_id" class="form-control">
                            <option value="">{{__('--Select Course--')}}</option>
                            @foreach($courses??[] as  $key=>$course)
                                <option value="{{ $key }}">{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__('FAQ Title')}}</label>
                        <input class="form-control" type="text" name="course_faq_title" value="" placeholder="Write a FAQ title">
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__('FAQ Description')}}</label>
                        <textarea class="form-control summernote"  name="course_faq_description" value="" placeholder="Write a FAQ description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('script')


<script type="text/javascript">
 
</script>

@endpush

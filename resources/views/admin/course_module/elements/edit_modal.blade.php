<div class="modal fade" id="courseEditModal{{$course_module->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
                
        <form id="course_edit_modal_form" class="course_edit_modal_form" action="{{route('admin.course_module.update',[$course_module->id])}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <input type="hidden" name="course_id" value={{ $course_id }}>   <!-- Hidden -->
                    <div class="form-group mb-3">
                        <label>{{ __('Module Title') }}</label>
                        <input class="form-control" type="text" name="module_title" value="{{$course_module->module_title}}">
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

</script>

@endpush

<div class="modal fade" id="courseResourceEditModal{{$course_resource->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
                
        <form id="course_resource_edit_modal_form" class="course_resource_edit_modal_form" action="{{route('admin.course_resource.update',[$course_resource->id])}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>{{ __('Course') }}</label>
                        <select name="course_id" class="form-control">
                            <option value="">{{__('--Select Course--')}}</option>
                            @foreach($courses??[] as  $key=>$course)
                                <option value="{{ $key }}" {{ $key == $course_resource->course_id ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>                   
                    <div class="form-group mb-3">
                        <label>{{__('Resource Title')}}</label>
                        <input class="form-control" type="text" name="resource_name" value="{{ $course_resource->resource_name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>{{__('Resource file')}}</label>
                        <input id="photo-upload" type="file" name="resource_path"/>
                        {{-- <div id="photo-upload__preview" class="upload-preview"></div> --}}
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

<div class="modal-content">
    <div class="modal-header bg-img">
    </div>
    <div class="modal-body">
        <div class="form-group mb-3">
            <label>Course Title</label>
            <input class="form-control" type="text" name="course_title" value="{{ $course->course_title }}" placeholder="{{__('Course Title')}}">
        </div>
        <div class="form-group mb-3">
            <label>Course Description</label>
            <textarea class="form-control" id="" name="course_description" >{!! $course->course_description !!}</textarea>
        </div>
        <div class="form-group mb-3">
            <label>Course Outcome</label>
            <textarea class="form-control summernote" id="" name="course_outcome" >{!! $course->course_outcome !!}</textarea>
        </div>
        <div class="form-group mb-3">
            <label>Course Cover Photo</label>
            <input id="photo-upload" type="file" name="cover_photo"/>
            <div id="photo-upload__preview" class="upload-preview p-5">
                <img src="{{ $course->getImagePath($course->id) }}" class="item-photo__preview">
            </div>
        </div>
    </div>
    <div class="modal-footer m-3">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
    </div>
</div>

{{-- action="{{ route('admin.course_sub_module.update') }}" method="post"  --}}
<form id="course_subModuleEdit_form" class="course_edit_modal_form" enctype="multipart/form-data">@csrf
  <div class="modal-body">
    <div class="modal-data">
      <input class="form-control" type="hidden" name="module_id" value="{{ $module_id }}" required>  <!--hidden -->
      <input class="form-control" type="hidden" name="sub_module_id" value="{{ $course_sub_module->id }}" required>  <!--hidden -->

      <div class="form-group mb-3 col-md-6">
          <label>{{__('Content Title')}}</label>
          <input class="form-control" type="text" name="content_title" value="{{ $course_sub_module->content_title }}" required>
      </div>
      <div class="form-group mb-3 col-md-6">
        <label>{{__('Content Duration (In minutes)')}}</label>
        <input class="form-control" type="text" name="content_duration" value="{{ $course_sub_module->timer }}" placeholder="Write contet duration in numeric" required>
      </div>
      <div class="form-group mb-3 col-md-6">
        <label>{{__('Content Type')}}</label>
        <select name="content_type" class="form-control content_typeFilter" required>
          <option value="" selected>{{ __('Select One') }}</option>
          <option value="video" {{ $course_sub_module->content_type == 'video' ? 'selected':'' }}>{{ __('Video(mp4)') }}</option>
          <option value="presentation"  {{ $course_sub_module->content_type == 'presentation' ? 'selected':'' }} >{{ __('Presentation (ppt,pptx)') }}</option>
      </select>
      </div>
      <div class="form-group mb-3 col-md-12">
          {!! Form::label('content', __('Content (mp4/ppt/pptx) *')) !!}

          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="preview-zone">
                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <div></div>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-danger btn-xs remove-preview">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <div class="box-body">
                          <p>{{ $course_sub_module->content_path }}
                      </div>
                    </div>
                  </div>
                  <div class="dropzone-wrapper">
                    <div class="dropzone-desc">
                      <i class="glyphicon glyphicon-download-alt"></i>
                      <p>Choose an video/presentation file or drag it here.</p>
                    </div>
                    <input type="file" name="content" class="dropzone" >
                  </div>
                </div>
              </div>
          </div>
          <div class=" form-group row text-left">
            <div class="col-md-4">
                <label>Select Resource Type</label>
                <select name="resourceOptionEdit" class="form-control resourceOptionEditFilter" data-id="{{ $course_sub_module->id }}">
                  <option value="" selected>{{ __('Select One') }}</option>
                  <option value="1" {{ $course_sub_module->youtube_path != null ? 'selected' : '' }}>{{ __('Add URL') }}</option>
                  <option value="2" {{ $course_sub_module->content_resource != null ? 'selected' : '' }} >{{ __('Add File') }}</option>
                </select>
            </div>
        </div>
          <div class="col-12 resource-section-edit" id="resource_section_edit{{ $course_sub_module->id }}"> <!--resource section render here -->
              @if($course_sub_module->youtube_path != null)
              <div class="card card-outline-danger text-center block-content">
                  <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                  <div class="card-block">
                      <blockquote class="card-blockquote">
                          <div class="form-group mb-3">
                                <input class="form-control" id="content_url" type="text" name="youtube_path{{ $course_sub_module->id }}" value="{{ $course_sub_module->youtube_path }}">
                          </div>
                      </blockquote>
                  </div>
              </div>
              @else
              <div class="card card-outline-danger text-center block-content">
                  <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                  <div class="card-block">
                      <blockquote class="card-blockquote">
                          <div class="form-group mb-3">
                              <label>{{ __('Files(docs/pdf)') }}
                              <div class="my-2 content">{{ $course_sub_module->content_resource }}</div>
                              <div class="input-group">
                                  <div class="custom-file">
                                    <input class="form-control" id="content_resource" type="file" name="content_resource{{ $course_sub_module->id }}" value="">
                                  </div>
                              </div>
                          </div>
                      </blockquote>
                  </div>
              </div>
              @endif


              <div class="card card-outline-danger text-center hidden-youtube-content" style="display: none">
                  <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                  <div class="card-block">
                      <blockquote class="card-blockquote">
                          <div class="form-group mb-3">
                                <input class="form-control" id="content_url" type="text" name="content_url" value="{{ $course_sub_module->youtube_path }}">
                          </div>
                      </blockquote>
                  </div>
              </div>


              <div class="card card-outline-danger text-center hidden-resource-content" style="display: none">
                  <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                  <div class="card-block">
                      <blockquote class="card-blockquote">
                          <div class="form-group mb-3">
                              <label>{{ __('Files(docs/pdf)') }}
                              <div class="my-2 content">{{ $course_sub_module->content_resource }}</div>
                              <div class="input-group">
                                  <div class="custom-file">
                                    <input class="form-control" id="content_resource" type="file" name="content_resource" value="">
                                  </div>
                              </div>
                          </div>
                      </blockquote>
                  </div>
              </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
    </div>
</form>



@push('script')

@endpush

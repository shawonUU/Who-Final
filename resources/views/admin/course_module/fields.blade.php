<div class="form-group mb-3 col-md-6">
    <label>{{ __('Course') }}</label>
    <select name="course_id" class="form-control">
        <option value="">{{__('--Select Course--')}}</option>
        @foreach($courses??[] as  $key=>$course)
            <option value="{{ $key }}">{{ $course }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mb-3 col-md-6">
    <label>{{__('Module Name')}}</label>
    <input class="form-control" type="text" name="module_title" value="" placeholder="Write a title of content">
</div>
<div class="form-group mb-3 col-md-6">
    <label>{{__('Content Title')}}</label>
    <input class="form-control" type="text" name="content_title[]" value="" placeholder="Write a title of content">
</div>
<div class="form-group mb-3 col-md-12">
    {!! Form::label('content', __('Content (mp4/ppt/pptx) *')) !!}

    <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="preview-zone hidden">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <div><b>Preview</b></div>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-danger btn-xs remove-preview">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="box-body"></div>
              </div>
            </div>
            <div class="dropzone-wrapper">
              <div class="dropzone-desc">
                <i class="glyphicon glyphicon-download-alt"></i>
                <p>Choose an video/presentation file or drag it here.</p>
              </div>
              <input type="file" name="content[]" class="dropzone">
            </div>
          </div>
        </div>
    </div>
    <div class="col-12 resource-section hidden" id="resource_section">
        {{-- <div class="card card-outline-danger text-center">
            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
            <div class="card-block">
                <blockquote class="card-blockquote">
                    <div class="form-group mb-3">
                        <label>{{ __('Files(docs/pdf)') }}
                        <div class="input-group">
                            <div class="custom-file">
                               <input class="form-control" type="file" name="resource_file" value="">
                            </div>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div> --}}
    </div>
   <div class="col-12">
    <a href="#" type="button" class="my-2" data-toggle="modal" data-target="#resourceModal">
        {{__('Add Resource')}}
    </a>
   </div>

<div class="col-12 row content_appending" id="content_appending"></div>

 <button type="button" class="btn btn-info btn-sm ml-1 float-left" id="appendNewContentArea"  onclick="addContentSection()">
                        {{__('Add More Content')}}
</button>

@include('admin.course_module.elements.resource_modal')
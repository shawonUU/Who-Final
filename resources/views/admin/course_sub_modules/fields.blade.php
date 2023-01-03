<input class="form-control" type="hidden" name="module_id" value="{{ $module_id }}">  <!--hidden -->

<div class="form-group mb-3 col-md-6">
    <label>{{__('Content Title')}}</label>
    <input class="form-control" type="text" name="content_title" value="" placeholder="Write a title of content" required>
</div>
<div class="form-group mb-3 col-md-6">
  <label>{{__('Content Duration (In minutes)')}}</label>
  <input class="form-control" type="text" name="content_duration" value="" placeholder="Write contet duration in numeric" required>
</div>
<div class="form-group mb-3 col-md-6">
  <label>{{__('Content Type')}}</label>
  <select onchange="changeVideoPresentation(this)" id="videoPresentation" name="content_type" class="form-control content_typeFilter" required> 
    <option value="" selected>{{ __('-- Select One --') }}</option>
    <option value="video">{{ __('Video(mp4)') }}</option>
    <option value="presentation">{{ __('Presentation (ppt,pptx)') }}</option>
 </select> 
</div>
<div class="form-group mb-3 col-md-12">
    {!! Form::label('content', __('Content (mp4/ppt/pptx) *')) !!}
    {{-- <div class="input-group">
        <div class="custom-file">
            {!! Form::file('content[]', ['class' => 'form-control']) !!}
        </div>
    </div> --}}


    <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="preview-zone hidden">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <div></div>
                  <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-danger btn-xs remove-preview">
                      <i class="fa fa-times"></i>
                    </button> -->
                    
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
              <input id="videoPpt" type="file" name="content" class="d-none" required>
              <!-- <input type="file" name="content" class="dropzone" required> -->
            </div>
          </div>
        </div>
    </div>
    <div class=" form-group row text-left">
      <div class="col-md-1">
          <!-- <label>Select Resource Type</label> -->
          <select name="resourceOptions" id="realResourceOptions" class="d-none form-control resourceOptionsFilter"> 
             <option value="" selected>{{ __('Select One') }}</option>
             <option value="1">{{ __('Add URL') }}</option>
             <option value="2">{{ __('Add File') }}</option>
          </select>
          <input id="realFile" type="file" class="d-none">
          <input id="realUrl" type="text" class="d-none">
      </div>
   </div>
    <!-- <div class="col-12 resource-section hidden" id="resource_section"> resource section render here -->
    <!-- </div> -->

@push('script')
   
@endpush

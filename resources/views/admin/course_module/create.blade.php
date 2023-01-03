@section('style')
<style>
   

.box {
  position: relative;
  background: #ffffff;
  width: 100%;
}

.box-header {
  color: #444;
  display: block;
  padding: 10px;
  position: relative;
  border-bottom: 1px solid #f4f4f4;
  margin-bottom: 10px;
}

.box-tools {
  position: absolute;
  right: 10px;
  top: 5px;
}

.dropzone-wrapper {
  border: 2px dashed #91b0b3;
  color: #92b0b3;
  position: relative;
  height: 150px;
}

.dropzone-desc {
  position: absolute;
  margin: 0 auto;
  left: 0;
  right: 0;
  text-align: center;
  width: 40%;
  top: 50px;
  font-size: 16px;
}

.dropzone,
.dropzone:focus {
  position: absolute;
  outline: none !important;
  width: 100%;
  height: 150px;
  cursor: pointer;
  opacity: 0;
}

.dropzone-wrapper:hover,
.dropzone-wrapper.dragover {
  background: #ecf0f5;
}

.preview-zone {
  text-align: center;
}

.preview-zone .box {
  box-shadow: none;
  border-radius: 0;
  margin-bottom: 0;
}
.hidden{
    display: none;
}

.close-icon {
  cursor: pointer;
}

</style>
@endsection
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Course Module</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <section class="error-section">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        <div class="card">

            {!! Form::open(['route' => 'admin.course_module.store']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.course_module.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                {{-- <a href="{{ route('admin.list',['type'=> request()->query('type')] ) }}" class="btn btn-default">Cancel</a> --}}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('script')

<script>
   function addContentSection() {
    html = "<div class=\"form-group mb-3 col-md-6\">"+
    "<label>{{__('Content Title')}}</label>"+
    "<input class=\"form-control\" type=\"text\" name=\"content_title[]\" value=\"\" placeholder=\"Write a title of content\">"+
    "</div>"+
    "<div class=\"form-group mb-3 col-md-12\">"+
    "<label for=\"content\">Content (mp4/ppt/pptx)</label>"+
    "<div class=\"input-group\">"+
       "<div class=\"custom-file\">"+
        "<input class=\"form-control\" name=\"content[]\" type=\"file\">"+
        "</div>"+
    "</div>"+
"</div>"+

"<div class=\"form-group mb-3  col-md-6\">"+
    "<label>{{__('Youtube Url')}}</label>"+
    "<input class=\"form-control\" type=\"text\" name=\"youtube_content_path\" value=\"\" placeholder=\"Write a title of module\">"+
"</div>"+

"<div class=\"form-group mb-3 col-md-6\">"+
    "<label for=\"resource\">Resource</label>"+
    "<div class=\"input-group\">"+
        "<div class=\"custom-file\">"+
            "<input class=\"form-control\" name=\"resource[]\" type=\"file\">"+
        "</div>"+
    "</div>"+
"</div>";

     
        $("#content_appending").append(html);
      
     
    }
    </script>

    <script>
       function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      var htmlPreview =
        '<img width="200" src="' + e.target.result + '" />' +
        '<p>' + input.files[0].name + '</p>';
      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
      boxZone.empty();
      boxZone.append(htmlPreview);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}

$(".dropzone").change(function() {
  readFile(this);
});

$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});

$('#resource_section').on('click','.close-icon', function() {
    console.log('heree');
  $(this).closest('.card').fadeOut();
})

    </script>


<script type="text/javascript">
 $('#resource_file').change(function(e){
  resource_file_tag = `
    <div class="card card-outline-danger text-center">
            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
            <div class="card-block">
                <blockquote class="card-blockquote">
                    <div class="form-group mb-3">
                        <label>{{ __('Files(docs/pdf)') }}
                        <div class="input-group">
                            <div class="custom-file">
                               <input class="form-control" id="resource_file_ex" type="file" name="resource_file_ex" value="">
                            </div>
                        </div>
                    </div>
                </blockquote>
            </div>
     </div>
    
    `
  console.log('here');
    var input = this;
    console.log(input.files[0]);
    $("#resource_section").empty();
    $("#resource_section").append(resource_file_tag);
    $("#resource_file_ex").val(input);
    $("#resource_section").removeClass("hidden");
    // var url = $(this).val();
    // var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    // if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
    //  {
    //     var reader = new FileReader();

    //     reader.onload = function (e) {
    //        $('#img').attr('src', e.target.result);
    //     }
    //    reader.readAsDataURL(input.files[0]);
    // }
    // else
    // {
    //   $('#img').attr('src', '/assets/no_preview.png');
    // }
  });

    function renderResourceSection(){

    resource_file_tag = `
    <div class="card card-outline-danger text-center">
            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
            <div class="card-block">
                <blockquote class="card-blockquote">
                    <div class="form-group mb-3">
                        <label>{{ __('Files(docs/pdf)') }}
                        <div class="input-group">
                            <div class="custom-file">
                               <input class="form-control" id="resource_file_ex" type="file" name="resource_file_ex" value="">
                            </div>
                        </div>
                    </div>
                </blockquote>
            </div>
     </div>
    
    `
    
        url_tag = `
        <div class="card card-outline-danger text-center">
            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
            <div class="card-block">
                <blockquote class="card-blockquote">
                    <div class="form-group mb-3">
                        <input class="form-control" id="video_title" type="text" name="video_title" value="" placeholder="Write a title of module">
                    </div>
                </blockquote>
            </div>
        </div>
        `
   
     const resourceUrl = $("input[name=resource_url]").val();
     const resourceFile = $("input[name=resource_file]").val();

     $("input[name=resource_url]").val('');
     $("input[name=resource_file]").val('');

     if(resourceUrl && resourceFile){
        alert('Never Submit two files at a time!');
     }
     else if(resourceUrl){
        $("#resource_section").empty();
        $("#resource_section").append(url_tag);
        $("#video_title").val(resourceUrl);
        $("#resource_section").removeClass("hidden");
     }
     else if(resourceFile){
        $("#resource_section").empty();
        $("#resource_section").append(resource_file_tag);
        $("#resource_file_ex").val(resourceFile);
        $("#resource_section").removeClass("hidden");
  
        
     }
    }
 </script>

    
@endpush

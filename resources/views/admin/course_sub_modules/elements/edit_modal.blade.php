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

<div class="modal fade" id="courseSubModuleEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        {{-- action="{{ route('admin.course_sub_module.store') }}" method="post" --}}
        {{-- action="{{ route('admin.course_sub_module.update',['sub_module_id'=>$course_sub_module->id]) }}" method="post"  --}}
      
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
               
                <div class="modal-data"></div>
      
                {{-- <form id="course_subModuleEdit_forma" class="course_edit_modal_form" action="{{ route('admin.course_sub_module.update') }}" method="post" enctype="multipart/form-data">@csrf
                <div class="modal-body">
                  <div class="modal-data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                </div>
              </form> --}}
            
            </div>
        
    </div>
</div>

@push('script')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

$(document).on('click','.remove-preview', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});

$(document).on('click','.close-icon', function() {
    console.log('heree');
  $(this).closest('.card').fadeOut();
})

    </script>


<script type="text/javascript">

    $(document).on('change', '[name=resourceOptionEdit]', function() {
            var option = $(this).val();
            var subModule =  $(this).attr('data-id');

            resource_file_tag = `
            <div class="card card-outline-danger text-center">
                    <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
                    <div class="card-block">
                        <blockquote class="card-blockquote">
                            <div class="form-group mb-3">
                                <label>{{ __('Files(docs/pdf)') }}
                                <div class="my-2 content">{{ $course_sub_module->content_resource ?? '' }}</div>
                                <div class="input-group">
                                    <div class="custom-file">
                                    <input class="form-control"  type="file" name="content_resource{{ $course_sub_module->id ?? '' }}" value="">
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
                          <input class="form-control" type="text" name="youtube_path{{ $course_sub_module->id ?? '' }}" value="{{ $course_sub_module->youtube_path ?? '' }}">
                    </div>
                </blockquote>
            </div>
        </div>
        `
        if(option == 1 || option == '1') {//URL

          $("#resource_section_edit"+subModule+">.block-content").empty();
          $("#resource_section_edit"+subModule+">.hidden-resource-content>input").val('');
          $("#resource_section_edit"+subModule+">.hidden-resource-content").css("display", "none");
          $("#resource_section_edit"+subModule+">.hidden-youtube-content").css("display", "block");
        //   $("#resource_section_edit"+subModule).append(url_tag);
          $("#resource_section_edit"+subModule).removeClass("hidden");

        }else if(option == 2 || option == '2') {//File

            $("#resource_section_edit"+subModule+">.block-content").empty();
            $("#resource_section_edit"+subModule+">.hidden-youtube-content>input").val('');
            $("#resource_section_edit"+subModule+">.hidden-youtube-content").css("display", "none");
            $("#resource_section_edit"+subModule+">.hidden-resource-content").css("display", "block");
        //   $("#resource_section_edit"+subModule).append(resource_file_tag);
            $("#resource_section_edit"+subModule).removeClass("hidden");
        }else{
        //   $("#resource_section_edit"+subModule).empty();
          $("#resource_section_edit"+subModule+">.block-content").empty();
          $("#resource_section_edit"+subModule+">.hidden-resource-content>input").val('');
          $("#resource_section_edit"+subModule+">.hidden-youtube-content>input").val('');
          $("#resource_section_edit"+subModule+">.hidden-resource-content").css("display", "none");
          $("#resource_section_edit"+subModule+">.hidden-youtube-content").css("display", "none");
          $("#resource_section_edit"+subModule).addClass("hidden");
        }

    });
 </script>



<script>
    // $('#courseSubModuleEditModalSubmit').on('submit', function(e) {
      $(document).on('submit', '#course_subModuleEdit_form', function(e){
        e.preventDefault();
        var url = "{{route('admin.course_sub_module.update')}}"
        var formData = new FormData(this);
        console.log(url);
        console.log(formData);
        // return;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function(){
              $('.ajax-loader').css("visibility", "visible");
            },
            success: function(data) {
                console.log(data);
                if (data.status === 'success'){
                    successMessage(data.message)
                    $('#course_subModuleEdit_form')[0].reset();
                    $('#courseSubModuleEditModal').modal('hide');
                    $('.subModuleDataTable').load(location.href + ' .subModuleDataTable');
                } else {
                    $.each(data.errors, function(key, value){
                    errorMessage(value);
                   })
                }
            },
            error: function(data) {
              console.log(data);
                  errorMessage('Something Went wrong!');
                  $('#course_subModuleEdit_form')[0].reset();
                  $('#courseSubModuleEditModal').modal('hide');
                  $('.subModuleDataTable').load(location.href + ' .subModuleDataTable');
            }
        });
    });


    function successMessage(message) {
        Command: toastr["success"](message)

        toastr.info('Page Loaded!');
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "100",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function errorMessage(message) {
        Command: toastr["error"](message)

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
</script>


@endpush

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

.ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +100 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:50%;
  left:50%;
}

</style>
@endsection

<div class="modal fade" id="courseSubModuleContentCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="ajax-loader">
    <img src="{{ url('https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif?20170503175831') }}" class="img-responsive" />
  </div>
    <div class="modal-dialog modal-lg" role="document">
        {{-- action="{{ route('admin.course_sub_module.store') }}" method="post" --}}
        <div class="modal-content">
          <div class="modal-header bg-img">
            </div>
            <div class="modal-body">
                  <form id="course_subModuleStore_form" class="course_store_modal_form"  enctype="multipart/form-data">
                    @csrf
                    @include('admin.course_sub_modules.fields')
                  </form>
                  <form action="{{route('upload_sub_modioul_file')}}" class="dropzone" id="my-awesome-dropzone">
                    @csrf
                  </form>


                  <div class="form-group row text-left">
                      <div class="col-md-4">
                        <label>Select Resource Type</label>
                        <select name="resourceOptions" onchange="changeResorceType(this)" id="ResourceOptions" class="form-control resourceOptionsFilter"> 
                            <option value="" selected>{{ __('Select One') }}</option>
                            <option value="1">{{ __('Add URL') }}</option>
                            <option value="2">{{ __('Add File') }}</option>
                        </select>
                      </div>
                    </div>


                    <div class="form-group row text-left">
                      <div class="col-md-12">
                        <div class="resource-section hidden" id="resource_section"> <!--resource section render here -->
                        </div>
                      </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" onclick="submitForm()" class="btn btn-primary from-prevent-multiple-submits">{{__('Save')}}</button>
                </div>
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
     
    $(document).on('change', '[name=resourceOptions]', function() {
            var option = $(this).val();

            resource_file_tag = `
    <div class="card card-outline-danger text-center">
            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="fa fa-times"></i></span>
            <div class="card-block">
                <blockquote class="card-blockquote">
                    <div class="form-group mb-3">
                        <label>{{ __('Files(docs/pdf)') }}
                        <div class="input-group">
                            <div class="custom-file">
                               <input class="form-control" onchange="changecontentFile(this)" id="content_resource" type="file" name="content_resource" value="">
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
                        <input class="form-control" onchange="changecontentUrl(this)" id="content_url" type="text" name="content_url" value="" placeholder="Write an URL">
                    </div>
                </blockquote>
            </div>
        </div>
        `
        if(option == 1 || option == '1') {//URL

          $("#resource_section").empty();
          $("#resource_section").append(url_tag);
          $("#resource_section").removeClass("hidden");

        }else if(option == 2 || option == '2') {//File

          $("#resource_section").empty();
          $("#resource_section").append(resource_file_tag);
          $("#resource_section").removeClass("hidden");
        }else{
          $("#resource_section").empty();
          $("#resource_section").addClass("hidden");
        }
            
    });
 </script>



<script>
    $('#course_subModuleStore_form').on('submit', function(e) {
        // $('.from-prevent-multiple-submits').attr('disabled','true');
        e.preventDefault();

        var url = "{{route('admin.course_sub_module.store')}}"
        var formData = new FormData(this);
        console.log(url);
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
                    $('#course_subModuleStore_form')[0].reset();
                    $('#courseSubModuleContentCreateModal').modal('hide');
                    $('.subModuleDataTable').load(location.href + ' .subModuleDataTable');               
                } else {
                    $.each(data.errors, function(key, value){
                    errorMessage(value);
                   })
                   $('.ajax-loader').css("visibility", "hidden");
                  //  $('.from-prevent-multiple-submits').attr('disabled','false');
                }
            },
            error: function(data) {
                  errorMessage('Something Went wrong!');
                  $('#course_subModuleStore_form')[0].reset();
                  $('#courseSubModuleContentCreateModal').modal('hide');
                  $('.subModuleDataTable').load(location.href + ' .subModuleDataTable');     
                  // $('.from-prevent-multiple-submits').attr('disabled','false');              
            }
        });
    });


    function successMessage(message) {
        Command: toastr["success"](message)
       
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

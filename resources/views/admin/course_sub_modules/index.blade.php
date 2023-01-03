@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style>
    .ajax-loader{
        display: none;
    }
</style>
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col col-sm-6">
                <h4>{{__('sub module list')}}</h4>
            </div>
            <div class="col col-sm-6 mt-2">
                <button type="button" class="btn btn-info btn-sm ml-1 float-right" data-toggle="modal" data-target="#courseSubModuleContentCreateModal">
                    {{__('Add Content')}}
                </button>
            </div>
        </div>
    </div>
    @include('admin.course_sub_modules.elements.create_modal')
</section>
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
    <div class="form-contents-table">

        {{-- @include('components.search_bar_box', ['action' => 'CenterTypeController@index', 'button' => 'Search']) --}}

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.course_sub_modules.table')
                @include('components.paginate', ['records' => $course_sub_modules])
            </div>

        </div>
    </div>

@endsection

@push('script')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>


<script>
    let lastFile = null;
    let lastFileEdit = null;

    let videoFileExtension = ['mp4', 'mov'];
    let presentationFileExtension = ['ppt','pptx'];
    let myDropzone = new Dropzone("#my-awesome-dropzone");
    let myDropzoneEdit = null;
    let defoultFile = null;


    myDropzone.on("addedfile", file => {
        // console.log(file);
        let filename = file.name;
        let fileExtension = filename.substring(filename.lastIndexOf('.')+1, filename.length);
        let exceptedFileType = $("#videoPresentation").val();
        let exceptedFileExtension = [];
        if(exceptedFileType == "video"){
            exceptedFileExtension = videoFileExtension;
        }
        if(exceptedFileType == "presentation"){
            exceptedFileExtension = presentationFileExtension;
        }

        // console.log(fileExtension);

        if(exceptedFileExtension.indexOf(fileExtension) === -1){
            Dropzone.forElement('#my-awesome-dropzone').removeAllFiles(true);
            lastFile = null;
            return;
        }

        let videoPpt = document.getElementById('videoPpt');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        videoPpt.files = dataTransfer.files;
        // console.log(myDropzone.getAcceptedFiles());

        if(lastFile!=null)myDropzone.removeFile(lastFile);
        lastFile = file;

        //Dropzone.forElement('#my-awesome-dropzone').removeAllFiles(true)
        // var count= myDropzone.getAcceptedFiles().length;
        // for(i=0; i<myDropzone.getAcceptedFiles().length; i++){
        //     console.log(myDropzone.getAcceptedFiles()[i]);
        // }
    });
</script>


<script>
    function changeResorceType(ele){
        $("#realResourceOptions").val(ele.value);
    }

    function changecontentFile(ele){
        ele2 = document.getElementById('realFile')
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(ele.files[0]);
        ele2.files = dataTransfer.files;
        
    }
    function changecontentUrl(ele){
        $("#realUrl").val(ele.value);
    }
    function changeVideoPresentation(ele){
        Dropzone.forElement('#my-awesome-dropzone').removeAllFiles(true);
        let videoPpt = document.getElementById('videoPpt');
        videoPpt.value = null;
        lastFile = null;
    }

    function changeResorceType(ele){
        ele2 = document.getElementById('realFile')
        ele2.value = null;
        $("#realUrl").val("");
    }

    function submitForm(){
        $("#course_subModuleStore_form").submit();
    }


    function changeResorceTypeEdit(ele){
        $("#realResourceOptionsEdit").val(ele.value);
    }

    function changecontentFileEdit(ele){
        ele2 = document.getElementById('realFileEdit')
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(ele.files[0]);
        ele2.files = dataTransfer.files;
        $(".docsPdf").html(ele.files[0].name)
    }
    function changecontentUrlEdit(ele){
        $("#realUrlEdit").val(ele.value);
    }
    function changeVideoPresentationEdit(ele){
        Dropzone.forElement('#my-awesome-dropzone-edit').removeAllFiles(true);
        myDropzoneEdit.removeFile(defoultFile);
        // myDropzoneEdit.emit("addedfile", null);

        let videoPptEdit = document.getElementById('videoPptEdit');
        videoPptEdit.value = null;
        
        lastFileEdit = null;
    }

    function changeResorceTypeEdit(ele){
        ele2 = document.getElementById('realFileEdit')
        ele2.value = null;
        $("#realUrlEdit").val("");
    }

    function submitFormEdit(){
        $("#course_subModuleEdit_form").submit();
    }
</script>


<script>
    $(document).ready(function (){
        $(document).on('click','.subModuleEdit',function(){
             var subModuleId = $(this).val();
             console.log(subModuleId);
            //  $('#courseSubModuleEditModal').modal('show');
             $.ajax({
                type:"GET",
                url:"/admin/course/sub_module/edit/"+subModuleId,
                success: function (response){
                $('.modal-data').html(response);
                $('#courseSubModuleEditModal').modal({
                    backdrop: 'static',
                    keyboard: false,
                },'show');

                    myDropzoneEdit = new Dropzone("#my-awesome-dropzone-edit");
                    console.log(myDropzoneEdit);
                    defoultFile = new File(["Logic of Shawon"], "Uploaded File", {type: "text/plain", lastModified: '22-04-1998'});
                    lastFileEdit = defoultFile;
                    myDropzoneEdit.emit("addedfile", defoultFile);
                    myDropzoneEdit.on("addedfile", file => {
                        // console.log(file);
                        let filename = file.name;
                        let fileExtension = filename.substring(filename.lastIndexOf('.')+1, filename.length);
                        let exceptedFileType = $("#videoPresentationEdit").val();
                        let exceptedFileExtension = [];
                        if(exceptedFileType == "video"){
                            exceptedFileExtension = videoFileExtension;
                        }
                        if(exceptedFileType == "presentation"){
                            exceptedFileExtension = presentationFileExtension;
                        }

                        // console.log(fileExtension);

                        if(exceptedFileExtension.indexOf(fileExtension) === -1){
                            Dropzone.forElement('#my-awesome-dropzone-edit').removeAllFiles(true);
                            myDropzoneEdit.emit("addedfile", null);
                            lastFileEdit = null;
                            file = null;
                            return;
                        }

                        let videoPptEdit = document.getElementById('videoPptEdit');
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        videoPptEdit.files = dataTransfer.files;
                        if(lastFileEdit!=null)myDropzoneEdit.removeFile(lastFileEdit);
                        lastFileEdit = file;
                    });

                }

             });
        });
    });
</script>
    
@endpush


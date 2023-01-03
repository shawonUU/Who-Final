<div class="modal fade" id="courseModuleCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
                
        <form id="course_edit_modal_form" class="course_edit_modal_form" action="{{route('admin.course_module.store')}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <input type="hidden" name="course_id" value={{ $course_id }}>   <!-- Hidden -->

                    <div class="form-group mb-3">
                        <label>{{__('Module Title')}}</label>
                        <input class="form-control" type="text" name="module_title[]" value="" placeholder="Write a title of module">
                    </div>
                    <div id="addModuleTitle"></div>                    
                    <button type="button" onclick="addModuleTitleFieldFunc()" class="btn btn-sm btn-dark btn-group"> Add another title</button>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- modal end -->
<script>
    
    function addModuleTitleFieldFunc() {     
        var field =  document.createElement('div');
        field.innerHTML = `
                     <div class="form-group mb-3">
                        <label>{{__('Module Title')}}</label>
                        <input class="form-control" type="text" name="module_title[]" value="" placeholder="Write a title of module">
                    </div>
                    `
        document.getElementById("addModuleTitle").appendChild(field);
    }
</script>

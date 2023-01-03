@extends('layouts.app')

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
                }

             });
        });
    });
</script>
    
@endpush


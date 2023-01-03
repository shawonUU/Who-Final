<div class="modal fade" id="adminEditModal{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{route('admin.update')}}" method="post" enctype="multipart/form-data">@csrf
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <input class="form-control" type="text" name="name" value="{{$admin->name}}" placeholder="{{__('Name')}}">
                        <input value="{{$admin->id}}" type="hidden" name="id">
                    </div>

                    <div class="form-group mb-3">
                        <input class="form-control" type="email" name="email" value="{{$admin->email}}" placeholder="{{__('Email')}}">
                    </div>

                    {{-- <div class="form-group mb-3">
                        <input class="form-control" type="number" name="phone" value="{{$admin->phone}}" placeholder="{{__('Phone')}}">
                    </div> --}}

                    <div class="form-group mb-3">
                        <select name="type" class="form-control">
                            <option selected disabled>{{__('Change Type')}}</option>
                            <option value="admin" {{$admin->type == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="viewer" {{$admin->type == 'viewer' ? 'selected' : ''}}>Viewer</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <select name="status" class="form-control">
                            <option selected disabled>{{__('Change Status')}}</option>
                            <option value="active" {{$admin->status == 'active' ? 'selected' : ''}}>Active</option>
                            <option value="inactive" {{$admin->status == 'inactive' ? 'selected' : ''}}>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <fieldset class="form-group bg-soft-info">
                            <div class="form-group m-2 mb-3">
                                <input class="form-control" type="password" name="password" placeholder="{{__('New Password')}}">
                            </div>
                            <div class="form-group ml-2 mr-2 mb-3">
                                <input class="form-control" type="password" name="confirm_password" placeholder="{{__('Confirm Password')}}">
                            </div>
                        </fieldset>
                    </div>

                    {{-- <div class="form-group mb-3">
                        <input class="form-control" type="file" name="avatar">
                    </div> --}}

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save changes')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

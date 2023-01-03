<div class="modal fade" id="resourceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-img">
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>{{__('URL')}}</label>
                        <input class="form-control" type="text" name="resource_url" value="" placeholder="Write a title of module">
                    </div>

                    <div class="form-group mb-3">
                        <label>{{ __('Files(docs/pdf)') }}
                        <div class="input-group">
                            <div class="custom-file">
                               <input class="form-control" type="file" name="resource_file" id="resource_file" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" onclick="renderResourceSection()" data-dismiss="modal" >{{__('Save')}}</button>
                </div>
            </div>
    </div>
</div>
@push('script')


@endpush

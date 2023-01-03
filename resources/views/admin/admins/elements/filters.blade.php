<form name="filter_form" method="get" class="col-12 mb-2" action="{{route('admin.list')}}">

    <div class="row py-1 px-1">
        <input type="hidden" value="{{ request()->query('type') }}" name="type">
        {{-- <div class="form-group col-sm-4">
           
        </div> --}}
        <div class="col">
            <label for="Search">Search</label>
            <input type="text" name="keyword" class="form-control" placeholder="Search" value="{{ request('keyword') ? request('keyword') : '' }}">
        </div>
        <div class="col-auto">
            <label for="">Action</label><br>
            <button type="submit" class="btn btn-warning">Filter</button>
        </div>

    </div>

</form>
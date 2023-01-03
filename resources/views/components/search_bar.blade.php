<form action="{{ $action ? action($action):route($route) }}">
    <div class="row">
    	<div class="col">
    		<label for="Search">{{__('Search')}}</label>
	        <input type="text" name="keyword" class="form-control" placeholder="{{__('Search')}}" value="{{ request('keyword') ? request('keyword') : '' }}">
    	</div>
    	<div class="col-auto">
    		<label for="">{{__('Action')}}</label><br>
	        <button type="submit" class="btn btn-warning">{{ $button }}</button>
    	</div>
    </div>
</form>

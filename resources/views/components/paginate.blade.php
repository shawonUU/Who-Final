<div class="card-footer clearfix">
    	<div class="row">
			{{ $records->appends(request()->query())->links() }}
		</div>
</div>



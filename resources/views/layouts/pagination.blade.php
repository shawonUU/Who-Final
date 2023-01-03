<div class="row mb-4">
    <div class="col-sm-6">
        {!! $records->links() !!}
    </div>
    @php
    $key = request()->input('page') ? request()->input('page') : 1;
    if (session('APP_LOCALE') === 'en') {
        $count = \App\Helpers\BengaliHelper::en_number($key * $records->count());
        $total = \App\Helpers\BengaliHelper::en_number($records->total());
    } else {
         $count = \App\Helpers\BengaliHelper::bn_number($key * $records->count());
         $total = \App\Helpers\BengaliHelper::bn_number($records->total());
    }
    @endphp
    <div class="col-sm-6 text-right pt-1">
        {{ __('Showing :count of :total items', ['count' => $count, 'total' => $total]) }}
    </div>
</div>

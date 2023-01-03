<?php

namespace App\Http\Components\Traits;

trait Pagination{
    /**
     * get Pagination Page Data
     * @return Paginate Array
     */
    protected function getPaginationPages($pagination_data){
        return [
            "first"         => $pagination_data->url(1),
            "last"          => $pagination_data->url($pagination_data->lastPage()),
            "prev"          => $pagination_data->previousPageUrl(),
            "next"          => $pagination_data->nextPageUrl(),
            "current_page"  => $pagination_data->currentPage(),
            "per_page"      => $pagination_data->perPage(),
            "total" 	    => $pagination_data->total(),
        ];
    }
}
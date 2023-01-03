<?php

namespace App\Providers;

use App\Models\CourseResource;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer( '*', function ( $view ) { // for accessing session

            // View::composer( ['layouts.users.header_nav'], function ( $view ) {
            //     $resources                 = CourseResource::select( 'id','resource_path', 'resource_name' )->get();
            //     $course_resource           = new CourseResource();
            //     $course_resource_base_path = $course_resource->get_public_base_path_for_course_resource();
            //     $view->with( compact(
            //         'resources',
            //         'course_resource_base_path',
            //     ));
            // } );


        } );
    }
}

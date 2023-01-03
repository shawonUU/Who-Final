<?php

/**
 * Dev: @OSHIT SUTRA DAR
 */

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


trait UploadFileTrait {

    public $upload_path = 'all_files';

    /*-----FILE/IMAGE UPLOAD-----*/
    protected function uploadFileOnStorage( $file, $path, $old = null ) {
        $code = date( 'ymdhis' ) . '-' . rand( 1111, 9999 );

        /*-------DELETE OLD IMAGE/FILE-------*/
        if ( !empty( $old ) ) {
            $oldFile = $this->oldFile( $old );
            if ( Storage::disk( 'public' )->exists( $oldFile ) ):
                Storage::delete( $oldFile );
            endif;
        }

        /*-------FILE/IMAGE UPLOAD-------*/
        if ( !empty( $file ) ) {
            $fileName = $code . $file->getClientOriginalName();
            return Storage::putFileAs( 'upload/' . $path, $file, $fileName );
        }
    }

    /*-----OLD IMAGE/FILE-----*/
    public function oldFile( $file, $isDelete = false ) {
        $ex      = explode( 'storage/', $file );
        $oldFile = $ex[1] ?? "";

        if ( $isDelete && $oldFile ) {
            if ( Storage::disk( 'public' )->exists( $oldFile ) ) {
                Storage::delete( $oldFile );
            }
        }
        return $oldFile;
    }

    /* ======================================    Another Way to start file Upload        ================================  */
    /*=======================================  ///Upload file in default public folder/// ================================  */

    public function uploadFile( $field, $save_title = '', $path = null ) {
        $path = $path ? $path : $this->upload_path;
        
        if ( request()->hasfile( $field ) ) {
            $field_instance = request()->file( $field );
            if ( $field_instance ) {

               $extension = $field_instance->getClientOriginalExtension();
                $filename  = $this->remove_space_dots_replace_underscore( $this->clean_and_limit( $save_title, 12 ) ) . '_' . time() . mt_rand( 1000, 9999 ) . '.' . $extension;

                if(!File::isDirectory( public_path( $path ))){
                    File::makeDirectory( public_path( $path ), 0777, true, true);
                }

                $path =  public_path( $path );
                $field_instance->move($path, $filename);

                return $filename;
            }
        }
        return null;
    }

    public function delete_existing_and_upload_file( $field, $exist_file = null, $save_title = '', $path = null ) {

        $path = $path ? $path : $this->upload_path;
        if ( request()->hasfile( $field ) ) {

            if ( $exist_file != null ) {
                unlink( public_path() . '/' . $path . '/' . $exist_file ); // Unlink previous image if exist
            }

            $field_instance = request()->file( $field );
            if ( $field_instance ) {

                $extension = $field_instance->getClientOriginalExtension();
                $filename  = $this->remove_space_dots_replace_underscore( $this->clean_and_limit( $save_title, 12 ) ) . '_' . time() . mt_rand( 1000, 9999 ) . '.' . $extension;

                if(!File::isDirectory( public_path( $path ))){
                    File::makeDirectory( public_path( $path ), 0777, true, true);
                }

                $path =  public_path( $path );
                $field_instance->move($path, $filename);

                return $filename;
            }
        }
        return null;
    }

    
    function remove_space_dots_replace_underscore($string){
        $lower_case = strtolower($string);
        $remove_dots = $this->remove_dots($lower_case);
        $remove_space = $this->replace_underscore_with_spaces($remove_dots);
        return $remove_space;
    }

    function clean_and_limit($string, $limit=100){
        $string = $this->clean($string);
        $limit = \Illuminate\Support\Str::limit($string, $limit, $end='');
        return $limit;
    }
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
     }

     function remove_dots($string){
        return str_replace(".", "", $string);
    }
    function replace_hyphen_with_spaces($string){
        return str_replace(' ', '-', $string);
    }
    function replace_underscore_with_spaces($string){
        return str_replace(' ', '_', $string);
    }

}

<?php

namespace App\Http\Components\Traits;

/**
 *
 * @author Sm Shahjalal Shaju
 */

use App\Http\Components\Classes\SightEngine;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\Lang;

trait Upload{
    /*
     * Define Directories
     */
    protected  $post_image_dir = "images/post/";
    protected  $post_video_dir = "post/video/";
    protected  $upload_image_dir = "images/upload/";
    protected  $message_image_dir = "images/message/";
    protected  $other_image_dir = "images/others_images/";
    protected $base_dir = "storage/uploads/";

    
    /*
     * ---------------------------------------------
     * Check the file If exists then Delete the file
     * ---------------------------------------------
     */
    protected function RemoveFile($filePath) {
        if( Storage::disk("s3")->exists($filePath)){
            Storage::delete($filePath);
        }
    }
    
    /*
     * ---------------------------------------------
     * Upload an Image
     * Change Image height and width
     * Send the null value in height or width to keep 
     * the Image Orginal Ratio.
     * ---------------------------------------------
     */
    protected function uploadImage($request, $fileName, $dir){
        return $this->uploadFile($request, $fileName, $dir);
    }

    
    /*
     * ---------------------------------------------
     * Upload any Kind of file
     * ---------------------------------------------
     */
    protected function uploadFile($request, $fileName, $dir){
        ini_set('memory_limit', '-1');
        $file = $request->file($fileName);
        $path =  $this->resizeAndUploadFile($file, $dir);
        $this->checkImaveValidaty($path);
        return $path;
    }
    
    /**
     * ------------------------------------------------------------
     * Upload Multiple Image
     * ------------------------------------------------------------
     */
    protected function uploadMultipleFiles($request, $fileName, $dir) {
        ini_set('memory_limit', '-1');
        if($request->hasfile($fileName))
        {
            $allImage= [];
            $index = 0;
            foreach($request->file($fileName) as $file)
            {
                $path = $this->resizeAndUploadFile($file, $dir);
                $allImage[$index] = $path;
                $index++;
            }
            return $allImage;
        }
    }

    /**
     * Check Image Validaty
     */
    protected function checkImaveValidaty($image_path){
        $status = (new SightEngine())->getImageValidateResponse($image_path);
        if( !$status ){
            $this->RemoveFile($image_path);            
            throw new Exception(Lang::get("message.image_violate_policy"), 400);
        }
    }

    /**
     * Resize & Upload Image
     * @return File_Path
     */
    protected function resizeAndUploadFile($file, $dir){
        $file_name = time().$file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if(strtolower($extension) == "mp4" || strtolower($extension) == "mpeg4" || strtolower($extension) == "avi" || strtolower($extension) == "mkv"){
            $video_dir = trim($this->post_video_dir, "/");
            $file_url = Storage::disk('s3')->put($video_dir, $file);
            if(is_string($file_url)){
                return Storage::disk('s3')->url($file_url);
            }else{
                $custom_url = $video_dir.$file_name;
                return Storage::disk('s3')->url($custom_url);
            }
        }                 
        elseif(strtolower($extension) == "jpg" || strtolower($extension) == "png" || strtolower($extension) == "jpeg"){
            $image = Image::make($file)->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $path = Storage::disk('s3')->put($dir.$file_name, $image->stream()->__toString());
            if( is_string($path)){
                $path = Storage::disk('s3')->url($path);
            }else{
                $path = Storage::disk('s3')->url($dir.$file_name);
            }
            $this->checkImaveValidaty($path);
            return $path;
        }else{
            $file_dir = trim($this->post_image_dir, "/");
            $file_url = Storage::disk('s3')->put($file_dir, $file);
            if(is_string($file_url)){
                return Storage::disk('s3')->url($file_url);
            }else{
                $custom_url = $file_dir.$file_name;
                return Storage::disk('s3')->url($custom_url);
            }
        } 
    }

    /**
     * Check The Dir is Exists or Not
     */
    protected function checkDir($dir){
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        
        if(!file_exists($dir.'index.php')){
            $file = fopen($dir.'index.php','w');
            fwrite($file," <?php \n /* \n Unauthorize Access \n @Developer: Sm Shahjalal Shaju \n Email: shajushahjalal@gmail.com \n */ ");
            fclose($file);
        }
    }
}
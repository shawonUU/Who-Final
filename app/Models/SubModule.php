<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubModule extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    public $upload_path = 'uploads/files';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'module_id',
        'content_type',
        'content_title',
        'content_path',
        'content_resource',
        'youtube_path',
        'timer',       
    ];
    

    public function status_buttons( $field = 'status' ) {
        $status = $this->getOriginal( $field );

        if ( $status == 'active' ) {
            return '<span class="badge bg-primary">Active</span>';
        }
        return '<span class="badge bg-warning">Inactive</span>';
    }


    public function getContentPath($field,$upload_path=null)
    {
        if($this->$field == null)
        return null;

        $path = $upload_path ? $upload_path : $this->upload_path;
        $content_url = asset($path .'/'. $this->$field);
        return $content_url;
    }

    public function uploadContent($field, $exist_file=null, $save_title = '', $path = null){
        // return request()->$field;
        $path = $path ? $path : $this->upload_path;
        if ( request()->hasfile( $field ) ) {

            $field_instance = request()->file( $field );
            if ($exist_file != null) {
                unlink(public_path() . '/' . $path . '/' . $exist_file); // Unlink previous image if exist
            }
            $field_instance = request()->file($field);
    
            if (!File::isDirectory(public_path($path))) {
                File::makeDirectory(public_path($path), 0777, true, true);
            }
            if ( $field_instance ) {
                $fileName = Str::random(25).'-'.time().'.'.request()->file($field)->extension();
                // Storage::putFileAs($path, request()->$field, $fileName);
                $field_instance->move(public_path($path), $fileName);
                return $fileName;
            }
           
        }
        return null;        
    }

    public function sub_module_finish_status(){
        return UserFinishedSubModules::where('user_id',Auth::id())->where('sub_module_id',$this->id)->count() > 0 ? 1 : 0;
    }
    public function sub_module_unlock_status(){
        return UnlockSubModule::where('user_id',Auth::id())->where('sub_module_id',$this->id)->count() > 0 ? 1 : 0;
    }

    //Relations
   
      public function module() {
        return $this->belongsTo( CourseModule::class, 'module_id', 'id' );
    }  
}

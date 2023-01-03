<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CourseModule extends Model
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
        'course_id',
        'module_title',
        'module_description',
        'module_duartion',
        'module_content_path'
    ];

    public function status_buttons( $field = 'status' ) {
        $status = $this->getOriginal( $field );

        if ( $status == 'active' ) {
            return '<span class="badge bg-primary">Active</span>';
        }
        return '<span class="badge bg-warning">Inactive</span>';
    }

    public function upload($field, $exist_file = null, $save_title = '', $path = null)
    {
        $path = 'uploads/files';
        if ($exist_file != null) {
            unlink(public_path() . '/' . $path . '/' . $exist_file); // Unlink previous image if exist
        }
        $field_instance = request()->file($field);

        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true, true);
        }
        if ($field_instance) {

            $file_name = time().'.'.$field_instance->extension();     
             $field_instance->move(public_path($path), $file_name);
             return $file_name;
        }
       
    }

    public function getContentPath($field,$upload_path=null)
    {
        if($this->$field == null)
        return null;

        $path = $upload_path ? $upload_path : $this->upload_path;
        $content_url = asset($path .'/'. $this->$field);
        return $content_url;
    }

    public function module_unlock_status(){
        return UnlockModule::where('user_id',Auth::id())->where('module_id',$this->id)->count() > 0 ? 1 : 0;
    }
    public function quiz_finished_status($course_id){
        return ResultDetails::where('user_id',Auth::id())->where('course_id',$course_id)->where('module_id',$this->id)->count() > 0 ? 1 : 0;
    }


    //Relations

    //Relations
   
    public function sub_modules() {
        return $this->hasMany( SubModule::class, 'module_id', 'id' );
    }

    // public function quizes() {
    //     return $this->hasMany( SubModule::class, 'module_id', 'id' );
    // }

    public function course() {
        return $this->belongsTo( Course::class, 'course_id', 'id' );
    }  
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class Course extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    public $upload_path = 'uploads/course/cover_photo';
    public static $active_status = "published";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_title',
        'course_duration',
        'course_outcome',
        'cover_photo',
        'course_description',
    ];


    public function status_buttons( $field = 'status' ) {
        $status = $this->getOriginal( $field );

        if ( $status == 'active' ) {
            return '<span class="badge bg-primary">Active</span>';
        }
        return '<span class="badge bg-warning">Inactive</span>';
    }

    public function getImagePath($id){

        $course = Course::find($id);
        if($course->cover_photo == null)
          return asset( 'assets/images/default_course_image.jpg'  );
        else
        return asset( $this->upload_path  ) . '/' . $course->cover_photo;
    }

    public function getCoverPhoto($upload_path=null)
    {
        if($this->cover_photo == null)
        return null;

        $path = $upload_path ? $upload_path : $this->upload_path;
        $photo_url = asset($path .'/'. $this->photo);
        return $photo_url;
    }

    public function getCourseCategory()
    {
        return Setting::get_data_by_index('course_category', $this->course_category_id);
    }

    public function getCompleteRate(){
        $auth_id = Auth::id();

        $module = CourseModule::where('course_id',$this->id);
        $module_ids = $module->pluck('id');
        $total_module = $module->count();

        $sub_module = SubModule::whereIn('module_id',$module_ids);
        $sub_module_ids = $sub_module->pluck('id');
        $total_sub_module = $sub_module->count();

        $have_to_complete = ( $total_module + $total_sub_module );

        $submodule_complete = UserFinishedSubModules::where('user_id',$auth_id)->whereIn('sub_module_id',$sub_module_ids)->count();
        $quiz_complete = ResultDetails::where('user_id',$auth_id)->where('course_id',$this->id)->whereIn('module_id',$module_ids)->count();
        $total_complate = ( $submodule_complete +  $quiz_complete );
        // return $quiz_complete;

        return $have_to_complete == 0 ? 0.00 : (float) round( ( ($total_complate*100)/$have_to_complete ),2);


    }

    public function countModules(){
        return CourseModule::where('course_id',$this->id)->count() ?? 0;
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::$active_status);
    }


    //Relations

    public function course_modules() {
        return $this->hasMany( CourseModule::class, 'course_id', 'id' );
    }

    public function course_faqs() {
        return $this->hasMany( CourseFaq::class, 'course_id', 'id' );
    }

    public function uploadFile( $field, $save_title = '', $path = null ) {
        $path = $path ? $path : $this->upload_path;
        if ( request()->hasfile( $field ) ) {
            $field_instance = request()->file( $field );
            if ( $field_instance ) {

                $img = Image::make($field_instance)->resize(350, 350)->encode('webp', 100);
                $filename  = $this->remove_space_dots_replace_underscore( $this->clean_and_limit( $save_title, 12 ) ) . '_' . time() . mt_rand( 1000, 9999 ) . '.' . 'webp';

                if(!File::isDirectory( public_path( $path ))){
                    File::makeDirectory( public_path( $path ), 0777, true, true);
                }

                $path =  public_path( $path ).'/'. $filename;
                $img->save($path);

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

                $img = Image::make($field_instance)->resize(100, 100)->encode('webp', 100);
                $filename  = $this->remove_space_dots_replace_underscore( $this->clean_and_limit( $save_title, 12 ) ) . '_' . time() . mt_rand( 1000, 9999 ) . '.'. 'webp';

                if(!File::isDirectory( public_path( $path ))){
                    File::makeDirectory( public_path( $path ), 0777, true, true);
                }

                $path =  public_path( $path ).'/'. $filename;
                $img->save($path);
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

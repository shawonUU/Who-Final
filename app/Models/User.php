<?php

namespace App\Models;

use App\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $upload_path = 'uploads/users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $search_fields = [
        'name',
        'phone'
    ];

    public function scopeWithSearch( $query ) {
        $keyword       = request()->keyword;
        $search_fields = $this->search_fields;

        if ( request( 'keyword' ) ) {

            if ( count( $search_fields ) ) {
                foreach ( $search_fields as $field ) {
                    $query = $query->orWhere( $field, 'like', '%' . $keyword . '%' );
                }
            }
        }
        return $query;
    }

    //Image Upload

   
    public function delete_existing_and_upload_file($field, $exist_file = null, $save_title = '', $path = null)
    {

        $path = $path ? $path : $this->upload_path;
        if (request()->hasfile($field)) {

            if ($exist_file != null) {
                unlink(public_path() . '/' . $path . '/' . $exist_file); // Unlink previous image if exist
            }

            $field_instance = request()->file($field);
            if ($field_instance) {

                $img = Image::make($field_instance)->resize(100, 100)->encode('webp', 100);

                $filename  = remove_space_dots_replace_underscore(clean_and_limit($save_title, 12)) . '_' . time() . mt_rand(1000, 9999) . '.' . 'webp';

                if (!File::isDirectory(public_path($path))) {
                    File::makeDirectory(public_path($path), 0777, true, true);
                }

                $path =  public_path($path) . '/' . $filename;
                $img->save($path);
                return $filename;
            }
        }
        return null;
    }

    public function getProfileImage($upload_path=null)
    {
        if($this->photo == null)
        return asset('assets/images/users/default.webp');

        $path = $upload_path ? $upload_path : $this->upload_path;
        $photo_url = asset($path .'/'. $this->photo);
        return $photo_url;
    }

    public function getGender()
    {
        return Setting::get_data_by_index('genders_array', $this->gender);
    }

    public function getDesignation()
    {
        return Setting::get_data_by_index('designation_array', $this->designation);
    }

    public function getDivision()
    {
        return Division::where('id',$this->division_id)->first()->name;
    }

    public function getDistrict()
    {
        return District::where('id',$this->district_id)->first()->name;
    }

    public function getUpazila()
    {
        return Upazila::where('id',$this->upazila_id)->first()->name;
    }





    //Relation

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
    }

    public function certificates() {
        return $this->hasMany( Certificate::class, 'user_id', 'id' );
    }

    public function course_enrollments() {
        return $this->hasMany( CourseEnrollment::class, 'user_id', 'id' );
    }



    public function hasNotEnroll($course_id){
        $auth_id = Auth::id();
        $has_any = CourseEnrollment::where('user_type','user')
                                     ->where('user_id',$auth_id)
                                     ->where('course_id',$course_id)->first();

       if(!empty($has_any))
         return true;
       else
         return false;

    }
}

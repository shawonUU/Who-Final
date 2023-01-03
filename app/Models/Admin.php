<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $active_status = 'active';
    // protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $search_fields = [
        'name',
        'email'
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

    public function scopeActive($query)
    {
        return $query->where('status', self::$active_status);
    }



    public function hasNotEnroll($course_id){
        $auth_id = Auth::guard('admin')->id();
        $has_any = CourseEnrollment::where('user_type','admin')
                                     ->where('user_id',$auth_id)
                                     ->where('course_id',$course_id)->first();

       if(!empty($has_any))
         return true;
       else
         return false;
    }
}

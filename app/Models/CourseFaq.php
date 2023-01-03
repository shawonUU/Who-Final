<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFaq extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'course_faq_title',
        'course_faq_description',
       
    ];


    public function status_buttons( $field = 'status' ) {
        $status = $this->getOriginal( $field );

        if ( $status == 'active' ) {
            return '<span class="badge bg-primary">Active</span>';
        }
        return '<span class="badge bg-warning">Inactive</span>';
    }

}

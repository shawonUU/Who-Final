<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    use HasFactory;
    public $upload_path = 'uploads/resources';
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'resource_name',
        'resource_path',
    ];

    public function status_buttons( $field = 'status' ) {
        $status = $this->getOriginal( $field );

        if ( $status == 'active' ) {
            return '<span class="badge bg-primary">Active</span>';
        }
        return '<span class="badge bg-warning">Inactive</span>';
    }
    public function get_public_base_path_for_course_resource(){
        return $this->upload_path;
    }
}

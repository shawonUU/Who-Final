<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultDetails extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    public $upload_path = 'uploads/course/cover_photo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'user_id',
        'course_id',
        'result_id',
        'module_id',
        'total_question',
        'total_correct',
        'result',
    ];
}

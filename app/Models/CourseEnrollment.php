<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CourseEnrollment extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'user_id',
    'user_type',
    'course_id',
    'last_visit'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
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
        'module_id',
        'question_title',
        'type',
        'gap_question_text_with_blank',
        'gap_answers',
        'status',
    ];

    protected $casts =[
        'gap_answers' => 'array',
    ];



    //Relation
    public function options(){
        return $this->hasMany(QuizOption::class,'quiz_question_id','id');
    }
}

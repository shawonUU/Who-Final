<?php

namespace App\Http\Resources;

use App\Models\CourseModule;
use App\Models\QuizQuestion;
use App\Models\ResultDetails;
use App\Models\UnlockModule;
use App\Models\UnlockQuiz;
use App\Models\UnlockSubModule;
use App\Models\UserFinishedModule;
use App\Models\UserFinishedSubModules;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CourseWithModuleAndQuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $course_modules = [];
        foreach ($this->course_modules as $key => $course_module) {
        
        $course_modules[$key]['id'] = $course_module->id ?? null;
        $course_modules[$key]['course_id'] = $course_module->course_id ?? null;
        $course_modules[$key]['module_title'] = $course_module->module_title ?? null;
        $course_modules[$key]['status'] = $course_module->status ?? null;
        $course_modules[$key]['module_finish_status'] = UserFinishedModule::where('user_id',Auth::id())->where('module_id',$course_module->id)->count() > 0 ? 1 : 0;
        $course_modules[$key]['module_unlock_status'] = UnlockModule::where('user_id',Auth::id())->where('module_id',$course_module->id)->count() > 0 ? 1 : 0;
        $sub_modules = [];
        $quizes = [];
        foreach($course_module->sub_modules as $idx=>$sub_module){
            $sub_modules[$idx]['id']            = $sub_module->id ?? null;
            $sub_modules[$idx]['module_id']     = $sub_module->module_id ?? null;
            $sub_modules[$idx]['content_title']  = $sub_module->content_title ?? null;
            $sub_modules[$idx]['content_type']  = $sub_module->content_type ?? null;
            $sub_modules[$idx]['content_path']  = $sub_module->getContentPath('content_path') ?? null;
            $sub_modules[$idx]['content_resource']  = $sub_module->getContentPath('content_resource') ?? null;
            $sub_modules[$idx]['youtube_path']  = $sub_module->youtube_path ?? null;
            $sub_modules[$idx]['timer']  = $sub_module->timer ?? null;
            $sub_modules[$idx]['finish_status']  = UserFinishedSubModules::where('user_id',Auth::id())->where('sub_module_id',$sub_module->id)->count() > 0 ? 1 : 0;
            $sub_modules[$idx]['unlock_status']  = UnlockSubModule::where('user_id',Auth::id())->where('sub_module_id',$sub_module->id)->count() > 0 ? 1 : 0;

        }
        $course_modules[$key]['sub_modules']  = $sub_modules ?? null;
        $quizes  = QuizQuestion::with('options')->where('course_id',$this->id)->where('module_id',$course_module->id)->get()->shuffle();
        $has_already_quiz_submission = ResultDetails::where('user_id',Auth::id())->where('course_id',$course_module->course_id)->where('module_id', $course_module->id)->first();
        $unlock_quiz = UnlockQuiz::where('user_id',Auth::id())->where('course_id',$course_module->course_id)->where('module_id', $course_module->id)->first();
        
        $course_modules[$key]['quizes']['title']  = 'Take Quiz';
        $course_modules[$key]['quizes']['content_type']  = 'quiz';
        $course_modules[$key]['quizes']['quiz_given_status']  = !empty($has_already_quiz_submission) ? 1 : 0;
        $course_modules[$key]['quizes']['quiz_unlock_status']  = !empty($unlock_quiz) ? 1 : 0;
        $course_modules[$key]['quizes']['quiz_data']  = $quizes ?? null;

       
        }

        return [
            'id'                      => $this->id,
            'course_title'            => $this->course_title ?? null,
            'complete_rate'           => 0,
            'status'                  => $this->status ?? null,
            'course_modules'          => $course_modules ?? null,
        ];
    
    }

    
}

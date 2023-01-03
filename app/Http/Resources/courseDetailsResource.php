<?php

namespace App\Http\Resources;

use App\Models\UserFinishedModule;
use App\Models\UserFinishedSubModules;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class courseDetailsResource extends JsonResource
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
        $sub_modules = [];
        foreach($course_module->sub_modules as $idx=>$sub_module){
            $sub_modules[$idx]['id']            = $sub_module->id ?? null;
            $sub_modules[$idx]['module_id']     = $sub_module->module_id ?? null;
            $sub_modules[$idx]['content_title']  = $sub_module->content_title ?? null;
            $sub_modules[$idx]['content_type']  = $sub_module->content_type ?? null;
            $sub_modules[$idx]['content_path']  = $sub_module->getContentPath('content_path') ?? null;
            $sub_modules[$idx]['content_resource']  = $sub_module->getContentPath('content_resource') ?? null;
            $sub_modules[$idx]['youtube_path']  = $sub_module->youtube_path ?? null;
            $sub_modules[$idx]['finish_status']  = UserFinishedSubModules::where('user_id',Auth::id())->where('sub_module_id',$sub_module->id)->count() > 0 ? 1 : 0;

        }
        $course_modules[$key]['sub_modules']  = $sub_modules ?? null;
       
        }

        return [
            'id'                      => $this->id,
            'course_title'            => $this->course_title ?? null,
            'course_description'      => $this->course_description ?? null,
            'course_outcome'          => $this->course_outcome ?? null,
            'course_duration'         => $this->course_duration ?? null,
            'complete_rate'           => 0,
            'cover_photo'             => $this->getCoverPhoto() ?? null,
            'status'                  => $this->status ?? null,
            'course_modules'          => $course_modules ?? null,
        ];
    }
}

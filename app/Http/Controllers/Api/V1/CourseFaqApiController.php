<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Components\Traits\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseFaq;
use Exception;

class CourseFaqApiController extends Controller
{
    use Message;
    public function CourseFAQ()
    {
        try {
            $course_faqs = CourseFaq::orderBy('id', 'asc')->get();

            $this->apiSuccess();
            $this->data = $course_faqs;

            return $this->apiOutput(200, 'Course FAQ!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }
}

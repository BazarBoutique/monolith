<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $course = $this;

        return [
            'id' => $course->course_id,
            'title' => $course->course_title,
            'photo' => $course->course_photo,
            'detail' => $course->detail->cdetail_description,
            'enabled' => boolval($course->is_enabled)
        ];
    }
}

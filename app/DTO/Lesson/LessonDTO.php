<?php

namespace App\DTO\Lesson;

use App\DTO\CoreDTO;

class LessonDTO extends CoreDTO {

    static function make(array $attributes) : array
    {
        return [
            'ld_title' => $attributes['title'],
            'ld_url' => $attributes['url'],
            'ld_description' => $attributes['description'],
            'course_id' => LessonDetailDTO::make($attributes)
        ];
    }

}

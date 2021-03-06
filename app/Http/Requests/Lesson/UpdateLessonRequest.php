<?php

namespace App\Http\Requests\Lesson;

use App\Http\Requests\Core\AuthorizationAdminRequest;
use App\Models\Courses;
use App\Models\LessonDetail;
use Illuminate\Validation\Rule;

class UpdateLessonRequest extends AuthorizationAdminRequest
{
    public function all($keys = null)
    {
        $data = parent::all($keys);

        $data['lessonId'] = $this->route('lessonId');

        return $data;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lessonId' => ['required','numeric', Rule::exists(LessonDetail::class, 'ld_id')],
            'title' =>
                [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique(LessonDetail::class, 'ld_title')->ignore($this->route('lessonId'),'ld_id')
                     ],
            'ld_url' => ['sometimes','required','string'],
            'description' => ['sometimes','required','array'],
            'description.context' => ['sometimes','required','string'],
            'description.length' => ['sometimes','required','string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'This lesson name is required',
            'ld_url.required' => 'This lesson is required',
            'description.required' => 'How lesson description is the video?',
            'description.context.required' => 'This lesson description is required',
            'description.length.required' => 'This lesson length is required',
        ];
    }
}

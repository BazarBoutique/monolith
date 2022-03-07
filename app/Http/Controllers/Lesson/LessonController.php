<?php

namespace App\Http\Controllers\Lesson;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\DisableLeassonRequest;
use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Http\Response\APIResponse;
use App\Repositories\Lesson\LessonRepository;
use App\Services\Lesson\LessonService;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function Lesson(){
        try {
            $resource = new LessonRepository;

            $lesson = $resource->Lesson();

            return APIResponse::make(true,$lesson);
        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }

    public function showLesson($les){
        try {
            $resource = new LessonRepository;

            $lesson = $resource->showLesson($les);
            
            return APIResponse::make(true, $lesson);
        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }

    public function createLesson(StoreLessonRequest $request){
        try {
            $attributes = $request->validated();

            $service = new LessonService;

            $service->create($attributes);

            return APIResponse::success([],'Succesfullly created Lesson!');
        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }

    public function updateLesson(UpdateLessonRequest $request, $lesson){
        try {
            $attributes = $request->validated();

            $service = new LessonService;

            $service->update($attributes, $lesson);

            return APIResponse::success([],'Succesfully updated Lesson!');
        } catch (Exception $e) {            
            return APIResponse::fail($e->getMessage(),500);
        }
    }

    public function deleteLesson(DisableLeassonRequest $request){
        try {
            $attributes = $request->validated();

            $service = new LessonService;

            $service->remove($attributes);

            return APIResponse::success([],'Successfully removed Lesson!');
        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }
}

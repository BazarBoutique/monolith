<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\ChangeTeacherRequest;
use App\Http\Requests\Course\DisableCourseRequest;
use App\Http\Requests\Course\FilterCourseByIdRequest;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\Course\CourseResource;
use App\Http\Response\APIResponse;
use App\Services\Course\CourseService;
use Exception;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function showCourse(Request $request){
        try {

            $request->validate([
                'withDisabled' => 'required|boolean'
            ]);

            $withDisabled = $request->get('withDisabled');

            $service = new CourseService;

            $courses = $service->searchCourses($withDisabled);

            $resource = CourseResource::collection($courses);

            return APIResponse::success( $resource, 'Retrieve successfully courses');

        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }

    public function showCourseById(FilterCourseByIdRequest $request)
    {
        try {
            $validatedRequest = $request->validated();

            $service = new CourseService;

            $course = $service->showCourseById($validatedRequest);

            $resource = CourseResource::collection($course);
            
            return APIResponse::success($resource,'Retrieve successfully course');
        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage(),500);
        }
    }
    public function createCourse(StoreCourseRequest $request)
    {
        try {
            $validatedRequest = $request->validated();

            $service = new CourseService;

            $course = $service->createCourse($validatedRequest);

            return APIResponse::success($course->toArray(), "Course created successfully");

        } catch (Exception $e) {
            return APIResponse::fail($e->getMessage());
        }
    }

    public function updateCourse(UpdateCourseRequest $request)
    {
        try {
            $validatedRequest = $request->validated();

            $service = new CourseService;

            $course = $service->updateCourse($validatedRequest);

            return APIResponse::success($course->toArray(), 'Course updated successfully');

        } catch (Exception $e) {

            return APIResponse::fail($e->getMessage());
        }
    }

    public function changeCourseTeacher(ChangeTeacherRequest $request)
    {
        try {

            $validatedRequest = $request->validated();

            $service = new CourseService;

            $course = $service->changeCourseTeacher($validatedRequest);

            return APIResponse::success($course->toArray(), 'Teacher changed successfully');

        } catch (Exception $e) {

            return APIResponse::fail($e->getMessage());
        }
    }

    public  function disableCourse(DisableCourseRequest $request){
        try {
            $validatedRequest = $request->validated();

            $service = new CourseService;

            $course = $service->disableCourse($validatedRequest);

            $resource = new CourseResource($course);

            return APIResponse::success($resource,'Successfully removed Course!');
        } catch (Exception $e) {

            return APIResponse::fail($e->getMessage(),500);
        }
    }
}

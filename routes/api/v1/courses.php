<?php

use App\Http\Controllers\Courses\CoursesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'can:isAdmin'])->group(function () {
    Route::post('create-course', [CoursesController::class, 'createCourse']);
});


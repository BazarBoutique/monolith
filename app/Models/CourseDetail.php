<?php

namespace App\Models;

use App\Notifications\Course\CourseAssignedToTeacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CourseDetail extends Model
{
    use HasFactory, Notifiable;

    protected $table = "courses_details";
    protected $primaryKey = "course_id";

    protected $fillable = [
        'cdetail_author',
        'cdetail_description'
    ];

    protected $casts = [
        'cdetail_description' => 'array'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'cdetail_author', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

}

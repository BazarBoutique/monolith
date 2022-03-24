<?php

namespace App\Models;

use App\Models\Scopes\IsEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = "course_id";

    protected $fillable = [
        'course_title',
        'course_photo',
        'is_enabled'
    ];

    public function detail()
    {
        return $this->hasOne(CourseDetail::class,'course_id');
    }

    public function author()
    {
        return $this->belongsToMany(
            User::class,
            CourseDetail::class,
            'course_id',
            'cdetail_author'
        );
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            CourseUser::class,
            'course_id',
            'user_id'
        );
    }

    protected static function booted()
    {
        static::addGlobalScope(new IsEnabledScope);
    }

    public function scopeWithDisabledCourses($query)
    {
        return $query->withoutGlobalScope(IsEnabledScope::class);
    }

}

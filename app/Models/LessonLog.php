<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonLog extends Model
{
    use HasFactory, HasUuid;
    
    const CREATED_AT = 'registered_at';
    const UPDATED_AT = null;
    
    protected $primaryKey = "llog_uuid";
    protected $keyType = "string";
    
    protected $table = "lesson_log";

    protected $fillable =[
        'llog_context',
        'llog_author'
    ];
    protected $dates = ['registered_at'];
}

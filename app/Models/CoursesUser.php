<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesUser extends Model
{
    use HasFactory;

    protected $table = "courses_users";
    
    protected $primaryKey = "cu_id";
}

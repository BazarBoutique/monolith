<?php

namespace App\Models;

use App\Enums\PermissionRoleEnum;
use App\Models\Scopes\IsAuthorizedScope;
use App\Traits\HasImage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasImage;

    protected $table='users';
    protected $primaryKey='user_id';

    const SLIDE_PER_PAGE = 5;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new IsAuthorizedScope);
    }

    public function scopeWithDisabledUsers($query)
    {
        return $query->withoutGlobalScope(IsAuthorizedScope::class);
    }

    public function scopeSearchByName($query, string $name)
    {
        return $query->whereHas('detail', function ($q) use ($name) {
            $q->where('udetail_fullname', 'like', '%' . $name . '%');
        });
    }

    public function isAdmin()
    {
        return $this->roles()->where('permission_level', PermissionRoleEnum::ADMIN)->select('puser_id')->exists();
    }

    public function isTeacher()
    {
        return $this->roles()->where('permission_level', PermissionRoleEnum::TEACHER)->exists();
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class,'user_id');
    }

    public function roles()
    {
        return $this->hasMany(PermissionUser::class, 'user_id', 'user_id');
    }

    public function rolesHierarchy()
    {

        return $this->belongsToMany(
            PermissionHierarchy::class,
            'permission_users',
            'user_id',
            'permission_level'
        )->withPivot('permission_level');
    }

    public function purcharsedCourses()
    {
        return $this->hasMany(CourseUser::class,'user_id', 'user_id');
    }

    public function teachableCourses()
    {
        return $this->belongsTo(CourseDetail::class, 'cdetail_author', 'user_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function permissions_user($rol){
        $this->roles()->create([
            "permission_level"=>$rol,
            "user_id"=>$this->user_id
        ]);
        $this->detail()->create();
    }
}

<?php

namespace App\Models;

use App\Models\Scopes\IsEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    use HasFactory;

    protected $table = "permission_users";

    protected $primaryKey = "puser_id";

    protected $fillable = [
        'permission_level',
        'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new IsEnabledScope);
    }

    public function rol()
    {
        return $this->hasOne(PermissionHierarchy::class, 'permission_level', 'permission_level');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function scopeWithDisabledRoles($query)
    {
        return $query->withoutGlobalScope(IsEnabledScope::class);
    }
}

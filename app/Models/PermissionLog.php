<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PermissionLog extends Model
{
    use HasFactory, HasUuid;

    protected $primaryKey = "plog_uuid";
    protected $keyType = 'string';

    protected $table = "permission_logs";

    protected $fillable = [
        'plog_context',
        'plog_author'
    ];


}

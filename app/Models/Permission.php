<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $table = 'permissions';
    protected $fillable = [
        'key',
        'description',
        'created_by',
        'created_at'
    ];
}

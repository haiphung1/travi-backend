<?php

namespace App\Models;
use App\User;
use App\Models\Role_permission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Model;

class Role extends SpatieRole
{
    protected $table = 'roles';
    protected $fillable = [
        'title',
        'created_by',
        'created_at'
    ];
}

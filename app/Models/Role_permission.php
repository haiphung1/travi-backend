<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Role_permission extends Model
{
    protected $table = 'role_permission';
    protected $fillable = [
        'role_id',
        'permission_id',
        'created_by',
        'created_at'
    ];
}

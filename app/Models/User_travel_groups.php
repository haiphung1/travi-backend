<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class User_travel_groups extends Model
{
    protected $table = 'user_travel_groups';
    protected $fillable = [
        'user_id',
        'group_id',
        'role',
        'joined_time',
        'create_at',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function group()
    {
        return$this->belongsTo(Travel_group::class, 'group_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'type',
        'creator_id',
        'user_id',
        'data',
        'read'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';
    protected $fillable = [
        'group_id',
        'title',
        'description',
        'expected_time',
        'address',
        'lat',
        'long',
        'created_by'
    ];
}

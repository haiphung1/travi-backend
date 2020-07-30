<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'discussions';
    protected $fillable = [
        'group_id',
        'title',
        'content',
        'created_by'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscussionComment extends Model
{
    protected $table = 'discussion_comments';
    protected $fillable = [
        'content',
        'discussion_id',
        'created_by'
    ];
}

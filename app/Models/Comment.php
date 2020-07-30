<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'post_id',
        'created_by',
        'content'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id','id');
    }
}

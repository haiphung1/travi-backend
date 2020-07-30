<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'image',
        'content',
        'created_by',
        'deleted_at',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function like()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'created_by');
    }
}

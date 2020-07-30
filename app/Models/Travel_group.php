<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Travel_group extends Model
{
    protected $table = 'travel_groups';
    public $fillable = [
        'owner_id',
        'planning_from',
        'planning_to',
        'travel_time_from',
        'travel_time_to',
        'max_member',
        'title',
        'description',
        'rating',
        'deleted_at',
        'created_by',
        'start_place',
        'start_place_lat',
        'start_place_lng',
    ];

    public function userGroup()
    {
        return $this->belongsToMany(User::class, 'user_travel_groups', 'group_id', 'user_id')->withPivot('status')->withTimestamps();
    }

    public function pivot()
    {
        return $this->hasMany(User_travel_groups::class, 'group_id', 'id');
    }

    public function getUserGroup()
    {
        return $this->hasMany(User_travel_groups::class, 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function memberGroup()
    {
        return $this->getUserGroup()->where('user_travel_groups.status', '2');
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'group_id', 'id');
    }

    public function userStatus()
    {
        return $this->userGroup()->withPivot('role')->wherePivot('user_id', Auth::user()->id);
    }
}

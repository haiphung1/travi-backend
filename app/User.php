<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'birthdate',
        'avatar',
        'role_id',
        'phone_number',
        'blocked_at',
        'blocked_by',
        'provider',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    public function roles()
    {
        return $this->hasMany('App\Models\Role', 'id', 'role_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status', 'id')->wherePivot('status', 'APPROVED');
    }

    public function friendsOfMinePending()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->withPivot('status', 'id')->wherePivot('status', 'PENDING')
            ->wherePivot('friend_id', Auth::user()->id);
    }

    public function friendsOfMineApproved()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->withPivot('status', 'id')->wherePivot('status', 'APPROVED');
    }

    public function friendsApproved()
    {
        return $this->friendsOfMineApproved->merge($this->friendOf);
    }

    public function friendsPending()
    {
        return $this->friendsOfMinePending;
    }
}

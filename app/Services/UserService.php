<?php

namespace App\Services;
use App\Interfaces\UserServiceInterface;
use App\Models\Comment;
use App\Models\Post;
use App\User;
use App\Models\Role;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserService implements UserServiceInterface
{
    public function getUser()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $role_id = $user->role_id;
        $permissions = $user->getAllPermissions()->pluck('name');

        return
            $result = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'phone_number' => $user->phone_number,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'gender' => $user->gender,
                'roles' => $user->getRoleNames(),
                'permissions' => $permissions
            ];
    }

    public function updateUser($data){
        $id = Auth::user()->id;
        $result = User::where('id', $id)->update($data->toArray());
        $result = User::find($id);
        return $result;
    }

    public function getUserStats()
    {
        $userCreate = User::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "value"')
            ));
        return $userCreate;
    }

    public function perpage($numberPage)
    {
        return $perpage = $numberPage*3;
    }

    public function getAllPostById($id, $numberPage)
    {
        $perpage = $this->perpage($numberPage);

        $data = Post::where('created_by', $id)->withCount(['like', 'comment'])->orderBy('created_at', 'desc')
            ->offset(0)->limit($perpage)
            ->get();
        $data->load(['user', 'like.user', 'comment' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(3)->with('user');
        }]);

        return $data;
    }

    public function getImageByUser($id)
    {
        $data = Post::where('created_by', $id)->orderBy('created_at', 'desc')
            ->select('id', 'image')
            ->limit(9)
            ->get();

        return $data;
    }

    public function getUserByID($id)
    {
        return User::find($id)->makeHidden(['email', 'phone_number']);
    }

    public function deleteComment($idPost, $idComment)
    {
        $post = Post::where('id', $idPost)->where('created_by', Auth::user()->id)->first();
        $post->load('comment');

        foreach ($post->comment as $item) {
            if ($idComment == $item->id) {
                $comment = Comment::find($item->id);
                $comment->delete();
            }
        }

        return $comment;
    }
}

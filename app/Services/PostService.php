<?php

namespace App\Services;

use App\Interfaces\PostInterface;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostService implements PostInterface
{

    public function __construct(UploadService $uploadService, NotificationService $notificationService)
    {
        $this->uploadService = $uploadService;
        $this->notificationService = $notificationService;
    }

    public function perpage($numberPage)
    {
        return $perpage = $numberPage*3;
    }

    public function getAllPost($numberPage)
    {
        $perpage = $this->perpage($numberPage);

        $data = Post::withCount(['like', 'comment'])->orderBy('created_at', 'desc')->offset(0)->limit($perpage)->get();
        $data->load(['user', 'like.user', 'comment' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(3)->with('user');
        }]);

        return $data;
    }

    public function createPost($data)
    {
        $post = new Post();
        $post->fill($data->all());

        if ($post->image) {
            $path = $this->uploadService->upload($data);
            $post->image = app('url')->asset($path);
        }
        $post->save();
        $data = Post::find($post->id)->load(['user', 'like.user', 'comment.user']);

        return $refult = $data;
    }

    public function getPostById($id)
    {
        $data = Post::where('id', $id)->withCount(['like', 'comment'])->orderBy('created_at', 'desc')->first();
        $data->load(['user', 'like.user', 'comment' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(3)->with('user');
        }]);

        return $data;
    }

    public function updatePost($id, $data)
    {
        $check = Post::where('id', $id)->where('created_by', Auth::user()->id)
            ->count();

        if ($check > 0) {
            $post = Post::find($id);

            $post->fill($data->all());
            if ($data->image > 0) {
                $path = $this->uploadService->upload($data);
                $post->image = app('url')->asset($path);
            }
            else if ($data->image == null) {
                $post->image = '';
            }
            $post->update();

            return Post::find($post->id)->load(['user', 'like.user', 'comment.user']);
        } else {
            return response()->json(404);
        }
    }

    public function deletePost($id)
    {
        $check = Post::where('id', $id)->where('created_by', Auth::user()->id)
            ->count();

        if ($check > 0) {
            $data = Post::where('id', $id)->where('created_by', Auth::user()->id)->first();
            $data->load('user');
            Like::where('post_id', $id)->delete();
            Comment::where('post_id', $id)->delete();
            $data->delete();

            return $data;
        } else {
            return response()->json(404);
        }
    }

    public function like($id)
    {
        $fill = Like::where([
            ['created_by', Auth::user()->id],
            ['post_id', $id]
        ])->count();

        if ($fill > 0) {
            return response()->json(404);
        }

        Post::find($id)->likes()->attach(Auth::user()->id);

        $data = Like::where('post_id', $id)->where('created_by', Auth::user()->id)->get()->first();
        $data->load('post');

        return $this->notificationService->notificationLike($data);
    }

    public function deleteLike($idLike)
    {
        $data = Like::where('id', $idLike)->first()->load('user');
        $data->delete();
        return $data;
    }

    public function createComment(Request $request, $id)
    {
        $comment = new Comment();
        $data = [
            'post_id' => (int)$id,
            'created_by' => Auth::user()->id,
            'content' => $request->comment
        ];
        $comment->fill($data);
        $comment->save();

        $data = $comment->load('user')->load('post');

        return $this->notificationService->notificationComment($data);
    }

    public function paginationComment($idPost, $numberPage)
    {
        $perpage =  $numberPage*3;

        return Comment::where('post_id', $idPost)->offset(0)->limit($perpage)->get()->load('user');
    }

    public function updateComment($idComment, $data)
    {
        Comment::where('id', $idComment)->where('comments.created_by', Auth::user()->id)
            ->update($data);

        return Comment::find($idComment);
    }

    public function getAllLikeByPosts($id)
    {
        return DB::table('posts')->where('posts.id', $id)
            ->join('likes', 'posts.id', '=', 'likes.post_id')
            ->leftJoin('users', 'users.id', '=', 'likes.created_by')
            ->select('posts.id', 'likes.created_by','users.username', 'users.first_name',
                'users.last_name', 'users.avatar')
            ->get();
    }

    public function getPostStats()
    {
        $postCreate = Post::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "value"')
            ));
        return $postCreate;
    }

    public function deleteComment($idComment)
    {
        $data = Comment::where('id', $idComment)->where('created_by', Auth::user()->id)
            ->first();
        $data->delete();
        return $data;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\TravelGroupService;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function __construct(PostService $postService, UserService $userService, TravelGroupService $travelGroupService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->travelGroupService = $travelGroupService;
    }

    public function index($numberpage)
    {
        $data = $this->postService->getAllPost($numberpage);

        return response()->json($data);
    }

    public function store(PostRequest $request)
    {
        $data = $this->postService->createPost($request);

        return response()->json([
            'data' => $data,
            'messages' => 'success'
        ]);
    }

    public function show($id)
    {
        $data = $this->postService->getPostById($id);

        return response()->json($data);
    }

    public function update(PostRequest $request, $id)
    {
        $data = $this->postService->updatePost($id, $request);

        return response()->json([
            'data' => $data,
            'messages' => 'success'
        ]);
    }

    public function delete($id)
    {
        $data = $this->postService->deletePost($id);

        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function like($id)
    {
        $data = $this->postService->like($id);

        return response()->json(['data' => $data,
            'messages' => 'success'
        ]);
    }

    public function deleteLike($idLike)
    {
        $data = $this->postService->deleteLike($idLike);

        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function comment(CommentRequest $request, $id)
    {
        $data = $this->postService->createComment($request, $id);

        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function updateComment(Request $request, $idComment)
    {
        $comment = [
            'content' => $request->comment
        ];
        $data = $this->postService->updateComment($idComment, $comment);

        return response()->json(['data' => $data, 'messages' => 'success']);
    }

    public function deleteComment($idComment)
    {
        $data = $this->postService->deleteComment($idComment);

        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }

    public function getAllLike($id)
    {
        //lấy tất cả thông tin user người like với 1 bài viết
        $data = $this->postService->getAllLikeByPosts($id);

        return response()->json($data);
    }
    public function getPostStats()
    {
        $postStats = $this->postService->getPostStats();
        $userStats = $this->userService->getUserStats();
//        $likeStats = $this->postService->getLikeStats();
        $travelGroupStats = $this->travelGroupService->getTravelGroupStats();
        return response()->json([
            'posts' => $postStats,
            'users' => $userStats,
            'travel_groups' => $travelGroupStats
        ]);
    }

    public function paginationComment($idPost, $numberPage)
    {
        $data = $this->postService->paginationComment($idPost, $numberPage);

        return $data;
    }
}

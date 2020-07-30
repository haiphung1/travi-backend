<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Interfaces\UserServiceInterface;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $user = $this->userService->getUser();
        return response()->json($user);
    }
    public function update(UserRequest $request)
    {
        $data = $request;
        $user = $this->userService->updateUser($data);
        return response()->json([
            'data' => $user,
            'message' => 'SUCCESS'
        ], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function getAllPostById($id, $perpage)
    {
        $posts = $this->userService->getAllPostById($id, $perpage);
        $images = $this->userService->getImageByUser($id);
        $user = $this->userService->getUserByID($id);
        return response()->json([
            'data' => [
                'posts' => $posts,
                'images' => $images,
                'user' => $user
            ]
        ]);
    }

    public function getImageByUser($id)
    {
        $data = $this->userService->getImageByUser($id);

        return response()->json($data);
    }

    public function deleteComment($idPost, $idComment)
    {
        $data = $this->userService->deleteComment($idPost, $idComment);

        return response()->json(['data' => $data, 'message' => 'success']);
    }
}

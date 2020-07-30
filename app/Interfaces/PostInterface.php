<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PostInterface
{
    public function getAllPost($numberPage);
    public function createPost($data);
    public function getPostById($id);
    public function updatePost($id, $data);
    public function deletePost($id);
    public function like($id);
    public function deleteLike($idLike);
    public function createComment(Request $request, $id);
    public function updateComment($idComment, $data);
    public function deleteComment($idComment);
    public function paginationComment($idPost, $numberPage);
    public function getAllLikeByPosts($id);
}

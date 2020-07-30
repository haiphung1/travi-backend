<?php
namespace App\Interfaces;
use Illuminate\Http\Request;
interface UserServiceInterface
{
    public function getUser();
    public function updateUser($data);
    public function getAllPostById($id, $perpage);
    public function getImageByUser($id);
    public function getUserByID($id);
    public function deleteComment($idPost, $idComment);
}

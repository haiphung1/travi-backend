<?php

namespace App\Interfaces;

interface TravelGroupInterface
{
    public function createTravelGroup($data);
    public function getTravelGroupById($id);
    public function editTravelGroup($id, $data);
    public function deleteTravelGroup($id);
    public function getAllUserApply($id);
    public function getAllUser($id);
    public function approvedUser($idApply, $idGroup);
    public function deleteUserGroup($idApply);
    public function createDestination($idGroup, $data);
    public function listDestination($idGroup);
    public function createDiscussion($idGroup, $data);
    public function discussionComment($idDiscussion, $data);
    public function deleteComment($idDiscussion);
}

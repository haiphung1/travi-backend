<?php

namespace App\Interfaces;

interface FriendInterface {
    public function addFriend($idUser, $data);
    public function listFriendApproved();
    public function listFriendPending();
    public function approved($idFriend);
    public function cancel($idFriend);
}

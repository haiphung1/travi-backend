<?php

namespace App\Interfaces;

interface UserGroupInterface
{
    public function getAllUserByGroup();
    public function addUserGroup($id);
    public function exitGroup($id);
}

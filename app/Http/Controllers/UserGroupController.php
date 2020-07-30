<?php

namespace App\Http\Controllers;

use App\Interfaces\UserGroupInterface;

class UserGroupController extends Controller
{
    public function __construct(UserGroupInterface $userGroup)
    {
        $this->userGroup = $userGroup;
    }

    public function index()
    {
        //Lấy danh sách các group mà user đã tham gia
        $data = $this->userGroup->getAllUserByGroup();

        return response()->json($data);
    }

    public function store($id)
    {
        //Thêm user vào nhóm
        $data = $this->userGroup->addUserGroup($id);
        if ($data == 'ALREADY_EXISTS') {
            return response()->json(['code' => 409, 'error' => 'USER_ALREADY_EXIST']);
        } else {
            return response()->json(['code' => 200, 'data' => $data]);
        }
    }

    public function delete($id)
    {
        //user rời khỏi nhóm
        $this->userGroup->exitGroup($id);

        return response()->json(['success' => 'success']);
    }
}

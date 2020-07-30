<?php

namespace App\Services;

use App\Interfaces\UserGroupInterface;
use App\Models\Travel_group;
use App\Models\User_travel_groups;
use Illuminate\Support\Facades\Auth;

class UserGroupService implements UserGroupInterface
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getAllUserByGroup()
    {
        //lấy danh sách tất cả các nhóm mà user đã giam gia
        $data = User_travel_groups::where('user_id', Auth::user()->id)->with(['user', 'group'])->get();

        return $data;
    }

    public function addUserGroup($id)
    {
        //1 user chỉ được tham gia 1 nhóm, status = 1 là đợi admin nhóm đó duyệt
        $check = User_travel_groups::where([
            ['user_id', Auth::user()->id],
            ['group_id', $id]
        ])->exists();

        if ($check) {
            return 'ALREADY_EXISTS';
        } else {
            Travel_group::find($id)->userGroup()->attach(Auth::user()->id);
            $data = Travel_group::find($id);

            return $this->notificationService->notificationApplyGroup($data);
        }
    }

    public function exitGroup($id)
    {
        //User rời khỏi group
        $data = Travel_group::find($id);

        return $data->userGroup()->detach(Auth::user()->id);
    }
}

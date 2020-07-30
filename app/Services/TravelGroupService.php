<?php

namespace App\Services;

use App\Interfaces\TravelGroupInterface;
use App\Models\Destination;
use App\Models\Discussion;
use App\Models\DiscussionComment;
use App\Models\Travel_group;
use App\Models\User_travel_groups;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TravelGroupService implements TravelGroupInterface
{

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function createTravelGroup($data)
    {
        $group = new Travel_group();
        $data = [
            'owner_id' => Auth::user()->id,
            'planning_from' => $data->planning_from,
            'planning_to' => $data->planning_to,
            'travel_time_from' => $data->travel_time_from,
            'travel_time_to' => $data->travel_time_to,
            'max_member' => $data->max_member,
            'title' => $data->title,
            'description' => $data->description,
            'created_by' => Auth::user()->id,
            'start_place' => $data->start_place,
            'start_place_lat' => $data->start_place_lat,
            'start_place_lng' => $data->start_place_lng,
        ];
        $group->fill($data);
        $group->save();

        $owner = new User_travel_groups();

        $dataOwner = [
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
            'role' => 2,
            'joined_time' => Carbon::now(),
            'status' => 2
        ];
        $owner->fill($dataOwner);
        $owner->save();

        return Travel_group::where('id', $group->id)->with('user')->with(['pivot' => function($query) {
            $query->where('user_id', Auth::user()->id);
        }])->first();
    }

    public function getTravelGroupById($id)
    {
        return Travel_group::find($id)->load('user')->load('userStatus');
    }

    public function getTravelGroups()
    {
        $data = Travel_group::withCount('memberGroup')->with('user')->with(['pivot' => function($query) {
            $query->where('user_id', Auth::user()->id);
        }])->get();
        return $data;
    }

    public function editTravelGroup($id, $data)
    {
        return Travel_group::where('id', $id)->where('created_by', Auth::user()->id)->update($data);
    }

    public function deleteTravelGroup($id)
    {
        $data = Travel_group::where('id', $id)
            ->where('created_by', Auth::user()->id)
            ->first();

        return $data->delete();
    }

    public function getAllUserApply($id)
    {
        //lấy danh sách user có trong 1 group có status = 1, đang chờ admin group duyệt
        return DB::table('travel_groups')->where('travel_groups.id', $id)
            ->join('user_travel_groups', 'travel_groups.id', '=', 'user_travel_groups.group_id')
            ->where('user_travel_groups.status', 1)
            ->leftJoin('users', 'users.id','=', 'user_travel_groups.user_id')
            ->select('user_travel_groups.id', 'user_travel_groups.user_id', 'users.username', 'users.first_name',
                'users.last_name', 'users.avatar', 'user_travel_groups.status'
            )
            ->get();
    }

    public function getTravelGroupStats()
    {
        $groupCreate = Travel_group::where('created_at', '>=', Carbon::now()->subMonth())
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as "value"')
            ));
        return $groupCreate;
    }

    public function getAllUser($id)
    {
        //lấy danh sách user có trong 1 group có status = 2, đã tham gia
        return DB::table('travel_groups')->where('travel_groups.id', $id)
            ->join('user_travel_groups', 'travel_groups.id', '=', 'user_travel_groups.group_id')
            ->where('user_travel_groups.status', 2)
            ->leftJoin('users', 'users.id','=', 'user_travel_groups.user_id')
            ->select('user_travel_groups.id', 'user_travel_groups.user_id', 'users.username', 'users.first_name',
                'users.last_name', 'users.avatar', 'user_travel_groups.status', 'user_travel_groups.joined_time'
            )
            ->get();
    }

    public function approvedUser($idApply, $idGroup)
    {
        // duyệt thành viên tham gia nhóm du lịch
        $fill = Travel_group::where([
            ['created_by', Auth::user()->id],
            ['id', $idGroup]
        ])->count();

        if ($fill > 0) {
            $data = User_travel_groups::where('id', $idApply)->update(
                ['status' => 2, 'joined_time' => Carbon::now() ]
            );
            $data =  User_travel_groups::find($idApply)->load('user');
            return $this->notificationService->notificationApprovedGroup($data);
        } else {
            return 'NOT_OWNER';
        }

    }

    public function deleteUserGroup($idApply)
    {
        $data = User_travel_groups::find($idApply);
        $data->delete();
        return $data;
    }

    public function createDestination($idGroup, $data)
    {
        $check = Travel_group::where('id', $idGroup)->where('created_by', Auth::user()->id)->count();

        if ($check > 0) {
            $post = new Destination();
            $data = [
                'group_id' => $idGroup,
                'title' => $data->title,
                'description' => $data->description,
                'expected_time' => $data->expected_time,
                'address' => $data->address,
                'lat' => $data->lat,
                'long' => $data->long,
                'created_by' => Auth::user()->id
            ];

            $post->fill($data);
            $post->save();

            return Destination::find($post->id);
        } else if ($check == 0) {
            return response()->json(404);
        }
    }

    public function listDestination($idGroup)
    {
        return Destination::where('group_id', $idGroup)->orderBy('expected_time')->get();
    }

    public function createDiscussion($idGroup, $data)
    {
        $check = Travel_group::where([
            ['created_by', Auth::user()->id],
            ['id', $idGroup]
        ])->count();

        if ($check > 0) {
            $discussion = new Discussion();
            $data = [
                'group_id' => $idGroup,
                'title' => $data->title,
                'content' => $data->content,
                'created_by' => Auth::user()->id
            ];

            $discussion->fill($data);
            $discussion->save();

            return Discussion::find($discussion->id);
        } else {
            return response()->json(404);
        }
    }

    public function discussionComment($idDiscussion, $data)
    {
        $comment = new DiscussionComment();
        $data = [
            'content' => $data->content,
            'discussion_id' => $idDiscussion,
            'created_by' => Auth::user()->id
        ];

        $comment->fill($data);
        $comment->save();

        return DiscussionComment::find($comment->id);
    }

    public function deleteComment($idDiscussion)
    {
        $data = DiscussionComment::where('id', $idDiscussion)->where('created_by', Auth::user()->id)
            ->get()->first();
        $data->delete();

        return $data;
    }
}

<?php

namespace App\Services;

use App\Interfaces\FriendInterface;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendService implements FriendInterface
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function addFriend($idUser, $data)
    {
        $check = Friend::where([
            ['user_id', Auth::user()->id],
            ['friend_id', $idUser]
        ])->exists();

        if ($check) {
            return 'ALREADY_EXISTS';

        } else {
            $friend = new Friend();
            $data = [
                'user_id' => Auth::user()->id,
                'friend_id' => $idUser,
                'status' => 'PENDING'
            ];
            $friend->fill($data);
            $friend->save();

            $data = Friend::find($friend->id);
            return $this->notificationService->notificationAddFriend($data);
        }
    }

    public function listFriendApproved()
    {
        return Auth::user()->friendsApproved();
    }

    public function listFriendPending()
    {
        return Auth::user()->friendsPending();
    }

    public function approved($idFriend)
    {
        $check = Friend::where('id', $idFriend)->where('friend_id', Auth::user()->id)
            ->exists();

        if ($check) {
            Friend::where('id', $idFriend)->update([
                'status' => 'APPROVED'
            ]);

            $data = Friend::find($idFriend);
            return $this->notificationService->notificationApprovedFriend($data);

        } else {
            return 'DENIED';
        }
    }

    public function cancel($idFriend)
    {
        $check = Friend::where('friend_id', Auth::user()->id)
            ->orWhere('user_id', Auth::user()->id)
            ->exists();

        if ($check) {
            $data = Friend::where('id', $idFriend)->first();
            $data->delete();

            return $data;
        } else {
            return 'DENIED';
        }
    }
}

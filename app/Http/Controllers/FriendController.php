<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FriendService;

class FriendController extends Controller
{
    public function __construct(FriendService $friendService)
    {
        $this->friendService = $friendService;
    }

    public function addFriend(Request $request, $idUser)
    {
        $data = $this->friendService->addFriend($idUser, $request);
        if ($data == 'ALREADY_EXISTS') {
            return response()->json(['error' => $data, 'status' => 409]);
        }
        return response()->json(['data' => $data, 'status' => 200]);
    }

    public function listFriendApproved()
    {
        $data = $this->friendService->listFriendApproved();

        return response()->json(['data' => $data, 'status' => 200]);
    }

    public function listFriendPending()
    {
        $data = $this->friendService->listFriendPending();

        return response()->json(['data' => $data, 'status' => 200]);
    }

    public function approved($idFriend)
    {
        $data = $this->friendService->approved($idFriend);

        if ($data == 'DENIED') {
            return response()->json(['error' => $data, 'status' => 403]);
        }
        return response()->json(['data' => $data, 'status' => 200]);
    }

    public function cancel($idFriend)
    {
        $data = $this->friendService->cancel($idFriend);
        if ($data == 'DENIED') {
            return response()->json(['error' => $data, 'status' => 403]);
        }
        return response()->json(['data' => $data, 'status' => 200]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestinationRequest;
use App\Http\Requests\DiscussionCommentRequest;
use App\Http\Requests\DiscussionRequest;
use App\Models\User_travel_groups;
use App\Services\TravelGroupService;
use Illuminate\Http\Request;
use App\Http\Requests\TravelGroupRequest;
use Illuminate\Support\Facades\Auth;

class TravelGroupController extends Controller
{
    public function __construct(TravelGroupService $travelGroupService)
    {
        $this->travelGroupService = $travelGroupService;
    }
    public function list()
    {
        $data = $this->travelGroupService->getTravelGroups();

        return response()->json(['data' => $data, 'message' => 'success']);
    }

    public function store(TravelGroupRequest $request)
    {
        $data = $this->travelGroupService->createTravelGroup($request);

        return response()->json(['data' => $data, 'code' => 200]);
    }

    public function show($id)
    {
        $data = $this->travelGroupService->getTravelGroupById($id);

        return response()->json($data);
    }

    public function update(TravelGroupRequest $request, $id)
    {
        $data = $request->except('__token');
        $this->travelGroupService->editTravelGroup($id, $data);

        return response()->json(['message' => 'success']);
    }

    public function delete($id)
    {
        $this->travelGroupService->deleteTravelGroup($id);

        return response()->json(['messages' => 'success']);
    }

    public function getAllUserApply($id)
    {
        $data = $this->travelGroupService->getAllUserApply($id);

        return response()->json($data);
    }

    public function getAllUser($id)
    {
        $data = $this->travelGroupService->getAllUser($id);

        return response()->json($data);
    }

    public function approvedUser($idApply, $idGroup)
    {
       $data = $this->travelGroupService->approvedUser($idApply, $idGroup);

       if ($data == 'NOT_OWNER') {
           return response()->json(['error' => $data, 'code' => 403]);
       }

       return response()->json(['data' => $data, 'code' => 200]);
    }

    public function deleteUserGroup($idApply)
    {
        $data = $this->travelGroupService->deleteUserGroup($idApply);

        return response()->json($data);
    }

    public function createDestination(DestinationRequest $request, $idGroup)
    {
        $data = $this->travelGroupService->createDestination($idGroup, $request);

        return response()->json(['data' => $data, 'code' => 200]);
    }

    public function listDestination($idGroup)
    {
        $data = $this->travelGroupService->listDestination($idGroup);

        return response()->json(['data' => $data, 'messages' => 'success']);
    }

    public function createDiscussion(DiscussionRequest $request, $idGroup)
    {
        $data = $this->travelGroupService->createDiscussion($idGroup , $request);

        return response()->json(['data' => $data, 'code' => '200']);
    }

    public function discussionComment(DiscussionCommentRequest $request, $idDiscussion)
    {
        $data = $this->travelGroupService->discussionComment($idDiscussion, $request);

        return response()->json(['data' => $data, 'message' => 'success']);
    }

    public function deleteComment($idDiscussion)
    {
        $data = $this->travelGroupService->deleteComment($idDiscussion);

        return response()->json(['data' => $data, 'message' => 'success']);
    }
}

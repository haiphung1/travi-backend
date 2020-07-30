<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    public function index()
    {
        $data = Notification::where('user_id', Auth::user()->id)->get();

        return response()->json(['data' => $data, 'status' => 200]);
    }

    public function read($id)
    {
         Notification::where('id', $id)->update(
            ['read' => '1']
         );
         $data = Notification::find($id);

         return response()->json(['data' => $data, 'status' => 200]);
    }
}

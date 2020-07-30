<?php

namespace App\Services;

use App\Events\NotificationAddFriendEvent;
use App\Events\NotificationApplyGroupEvent;
use App\Events\NotificationApprovedFriendEvent;
use App\Events\NotificationApprovedGroupEvent;
use App\Models\Notification;
use App\Events\NotificationLikeEvent;
use App\Events\NotificationCommentEvent;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function notificationLike($data)
    {
        if (Auth::user()->id === $data->post['created_by']) {
            return $data;
        } else {
            $notification = new Notification();
            $dataNotification = [
                'type' => 'like_post',
                'creator_id' => $data->user['id'],
                'user_id' => $data->post['created_by'],
                'data' => [
                    "creator_id" => $data->user['id'],
                    "avatar" => $data->user['avatar'],
                    "last_name" => $data->user['last_name'],
                    "first_name" => $data->user['first_name'],
                    "post_id" => $data->post['id'],
                ]
            ];

            $notification->fill($dataNotification);
            $notification->save();

            try {
                $result = Notification::find($notification->id);
                event(new NotificationLikeEvent($result));

            } catch (Exception $e) {
                report($e);

                return false;
            }

            return $data;
        }
    }

    public function notificationComment($data)
    {
        if (Auth::user()->id === $data->post['created_by']) {
            return $data;
        } else {
            $notification = new Notification();
            $dataNotification = [
                'type' => 'comment_post',
                'creator_id' => $data->user['id'],
                'user_id' => $data->post['created_by'],
                'data' => [
                    "creator_id" => $data->user['id'],
                    "avatar" => $data->user['avatar'],
                    "last_name" => $data->user['last_name'],
                    "first_name" => $data->user['first_name'],
                    "post_id" => $data->post['id'],
                    "content" => $data->content,
                    "image" => $data->post['image']
                ]
            ];

            $notification->fill($dataNotification);
            $notification->save();

            try {
                $result = Notification::find($notification->id);
                event(new NotificationCommentEvent($result));

            } catch (Exception $e) {
                report($e);

                return false;
            }

            return $data;
        }
    }

    public function notificationApplyGroup($data)
    {
        if (Auth::user()->id === $data->owner_id) {
            return $data;
        } else {
            $notification = new Notification();
            $dataNotification = [
                'type' => 'apply_group',
                'creator_id' => Auth::user()->id,
                'user_id' => $data->owner_id,
                'data' => [
                    "creator_id" => Auth::user()->id,
                    "avatar" => Auth::user()->avatar,
                    "last_name" => Auth::user()->last_name,
                    "first_name" => Auth::user()->first_name,
                    "id" => $data->id,
                    "title" => $data->title,
                ]
            ];

            $notification->fill($dataNotification);
            $notification->save();

            try {
                $result = Notification::find($notification->id);
                event(new NotificationApplyGroupEvent($result));

            } catch (Exception $e) {
                report($e);

                return false;
            }

            return $data;
        }
    }

    public function notificationApprovedGroup($data)
    {

        $notification = new Notification();
        $dataNotification = [
            'type' => 'approved_group',
            'creator_id' => Auth::user()->id,
            'user_id' => $data->user_id,
            'data' => [
                "creator_id" => Auth::user()->id,
                "avatar" => Auth::user()->avatar,
                "last_name" => Auth::user()->last_name,
                "first_name" => Auth::user()->first_name,
                "id" => $data->id,
                "group_id" => $data->group_id,
            ]
        ];

        $notification->fill($dataNotification);
        $notification->save();

        try {
            $result = Notification::find($notification->id);
            event(new NotificationApprovedGroupEvent($result));

        } catch (Exception $e) {
            report($e);

            return false;
        }

        return $data;
    }

    public function notificationAddFriend($data)
    {
        $notification = new Notification();
        $dataNotification = [
            'type' => 'add_friend',
            'creator_id' => Auth::user()->id,
            'user_id' => $data->friend_id,
            'data' => [
                "creator_id" => Auth::user()->id,
                "avatar" => Auth::user()->avatar,
                "last_name" => Auth::user()->last_name,
                "first_name" => Auth::user()->first_name,
                "id" => $data->id,
                "friend_id" => $data->friend_id,
            ]
        ];

        $notification->fill($dataNotification);
        $notification->save();

        try {
            $result = Notification::find($notification->id);
            event(new NotificationAddFriendEvent($result));

        } catch (Exception $e) {
            report($e);

            return false;
        }

        return $data;
    }

    public function notificationApprovedFriend($data)
    {
        if (Auth::user()->id == $data->friend_id) {
            $notification = new Notification();
            $dataNotification = [
                'type' => 'approved_friend',
                'creator_id' => Auth::user()->id,
                'user_id' => $data->user_id,
                'data' => [
                    "creator_id" => Auth::user()->id,
                    "avatar" => Auth::user()->avatar,
                    "last_name" => Auth::user()->last_name,
                    "first_name" => Auth::user()->first_name,
                    "id" => $data->id,
                    "user_id" => $data->user_id,
                ]
            ];

            $notification->fill($dataNotification);
            $notification->save();

            try {
                $result = Notification::find($notification->id);
                event(new NotificationApprovedFriendEvent($result));

            } catch (Exception $e) {
                report($e);

                return false;
            }

            return $data;
        } else {
            return $data;
        }
    }
}

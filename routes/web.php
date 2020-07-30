<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api'], function() use ($router){
    $router->get('/getUser', 'UserController@index');
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('login/email', 'AuthController@loginGoogle');
});

$router->group(['prefix' => 'api/user', 'middleware' => 'auth'], function () use ($router) {
    $router->put('/updateUser', 'UserController@update');
    $router->get('/logout', 'UserController@logout');
    $router->get('/{id}/timeline/{page}', 'UserController@getAllPostById');
    $router->get('/{id}/getImage', 'UserController@getImageByUser');
    $router->delete('{idPost}/deleteComment/{idComment}', 'UserController@deleteComment');
});

$router->group(['prefix' => 'api/groups', 'middleware' => 'auth'], function () use ($router) {
   $router->get('user', 'UserGroupController@index');
   $router->post('{id}/store', 'UserGroupController@store');
   $router->delete('{id}/exitGroup', 'UserGroupController@delete');
});

$router->group(['prefix' => 'api/posts', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/page/{page}', 'PostController@index');
    $router->post('/store', 'PostController@store');
    $router->get('{id}/show', 'PostController@show');
    $router->post('{id}/update', 'PostController@update');
    $router->delete('{id}/delete', 'PostController@delete');
    $router->post('{id}/like', 'PostController@like');
    $router->delete('{idLike}/delete/like', 'PostController@deleteLike');
    $router->post('{id}/comment', 'PostController@comment');
    $router->put('{idComment}/update/comment', 'PostController@updateComment');
    $router->delete('{idComment}/delete/comment', 'PostController@deleteComment');
    $router->get('/{id}/likePost', 'PostController@getAllLike');
    $router->get('/postStats', 'PostController@getPostStats');
    $router->get('/{idPost}/comment/{page}', 'PostController@paginationComment');
});

$router->group(['prefix' => 'api/travel/groups', 'middleware' => 'auth'], function () use ($router) {
    $router->post('/store', 'TravelGroupController@store');
    $router->get('/{id}/show', 'TravelGroupController@show');
    $router->put('/{id}/update', 'TravelGroupController@update');
    $router->delete('/{id}/delete', 'TravelGroupController@delete');
    $router->get('/', 'TravelGroupController@list');
    $router->get('/{id}/users/apply', 'TravelGroupController@getAllUserApply'); // lấy danh sách yêu cầu tham gia
    $router->get('/{id}/users', 'TravelGroupController@getAllUser'); // lấy danh sách thành viên
    $router->put('/{idApply}/approved/{idGroup}', 'TravelGroupController@approvedUser'); // duyệt yêu cầu tham gia
    $router->delete('/{idApply}/delete/user', 'TravelGroupController@deleteUserGroup'); // xoá thành viên ra khỏi nhóm
    $router->post('/{idGroup}/createDestination', 'TravelGroupController@createDestination'); // Tạo điểm đến
    $router->get('/{idGroup}/destinations', 'TravelGroupController@listDestination'); // List điểm đến
    $router->post('/{idGroup}/createDiscussion', 'TravelGroupController@createDiscussion'); //tạo thảo luận trong nhóm
    $router->post('/{idDiscussion}/discussionComment', 'TravelGroupController@discussionComment');
    $router->delete('/{idDiscussion}/deleteComment', 'TravelGroupController@deleteComment');
});

$router->group(['prefix' => 'api/notification', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'NotificationController@index');
    $router->put('{id}/read', 'NotificationController@read');
});

$router->group(['prefix' => 'api/friends', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', 'FriendController@listFriendApproved'); //lấy danh sách bạn bè
    $router->get('/pending', 'FriendController@listFriendPending'); // lấy danh sách chờ duyệt
    $router->post('{idUser}/add', 'FriendController@addFriend'); // gửi lời mời kết bạn
    $router->put('{idFriend}/approved', 'FriendController@approved'); // đồng ý kết bạn
    $router->delete('{idFriend}/cancel', 'FriendController@cancel'); // huy ban be
});

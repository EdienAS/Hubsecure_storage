<?php

/**
 * @SWG\Post(
 *     path="/usersettings/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"User"},
 *     operationId="updateUser",
 *     summary="Update user",
 *     description="Update user",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="User id",
 *     ),
 *     @SWG\Parameter(
 *         name="user",
 *         in="body",
 *         required=true,
 *         description="Update user",
 *         @SWG\Schema(ref="#/definitions/UpdateUser"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/User")
 *         ),
 *     ),
 * )
 */
$router->patch('usersettings/{uuid}', [
    'uses'       => 'UpdateUserSettings@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/usersettings/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Get user by id",
 *     tags={"User"},
 *     description="Get user id",
 *     operationId="userById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="User id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/User")
 *         ),
 *     ),
 * )
 */
$router->get('usersettings/{uuid}', [
    'uses' => 'ShowUserSettings@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="/avatar/{name}",
 *     security={{"Bearer":{}}},
 *     summary="Get user avatar by name",
 *     tags={"Avatar"},
 *     description="Get user avatar",
 *     operationId="userById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="name",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="avatar name",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *     ),
 * )
 */
$router->get('avatar/{name}', [
    'uses' => 'GetUserAvatar@get',
    'middleware' => [
        'auth:api'
    ],
])->name('getavatar');

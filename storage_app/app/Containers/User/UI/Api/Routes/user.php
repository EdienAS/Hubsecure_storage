<?php

/**
 * @SWG\Post(
 *     path="/users/register",
 *     tags={"User"},
 *     operationId="userRegister",
 *     summary="Register new user",
 *     description="Register a new User by credentials. This will also Login the new created user.",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="RegisterUser",
 *         in="body",
 *         required=true,
 *         description="Register user",
 *         @SWG\Schema(ref="#/definitions/RegisterUser"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User registered",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/User")
 *         ),
 *     ),
 * )
 */
$router->post('user/register', [
    'uses' => 'RegisterUser@create',
]);

/**
 * @SWG\Store(
 *     path="/users",
 *     security={{"Bearer":{}}},
 *     tags={"User"},
 *     operationId="storeUser",
 *     summary="Store user",
 *     description="Store user",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="User id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User ({uuid}) Stored Successfully."
 *     ),
 * )
 */
$router->post('user', [
    'uses'       => 'CreateUser@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/users/{uuid}",
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
$router->get('user/{uuid}', [
    'uses' => 'ShowUser@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Post(
 *     path="/users/{uuid}",
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
$router->patch('user/{uuid}', [
    'uses'       => 'UpdateUser@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/users/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"User"},
 *     operationId="deleteUser",
 *     summary="Delete user",
 *     description="Delete user",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="User id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User ({uuid}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('user/{uuid}', [
    'uses'       => 'DestroyUser@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\List(
 *     path="/users",
 *     security={{"Bearer":{}}},
 *     tags={"User"},
 *     operationId="listUser",
 *     summary="List users",
 *     description="List users",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation."
 *     ),
 * )
 */
$router->get('users', [
    'uses'       => 'ListUser@index',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Store(
 *     path="/users/blacklist/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"Blacklist User"},
 *     operationId="blacklistUser",
 *     summary="Blacklist user",
 *     description="Store user",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="uuid",
 *         in="path",
 *         type="uuid",
 *         required=true,
 *         description="User uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User ({uuid}) blacklist created Successfully."
 *     ),
 * )
 */
$router->post('user/blacklist/{uuid}', [
    'uses'       => 'Blacklist\CreateBlacklist@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Destroy(
 *     path="/users/blacklist/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"Blacklist User"},
 *     operationId="blacklistUser",
 *     summary="Blacklist user",
 *     description="Store user",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="uuid",
 *         in="path",
 *         type="uuid",
 *         required=true,
 *         description="User uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="User ({uuid}) blacklist deleted Successfully."
 *     ),
 * )
 */
$router->delete('user/blacklist/{uuid}', [
    'uses'       => 'Blacklist\DestroyBlacklist@destroy',
    'middleware' => [
        'auth:api',
    ],
]);
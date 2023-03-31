<?php

/**
 * @var $router Dingo\Api\Routing\Router
 */

/**
 * @SWG\Post(
 *     path="/login",
 *     tags={"User"},
 *     operationId="login",
 *     summary="User login",
 *     description="User login",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="user auth",
 *         in="body",
 *         required=true,
 *         description="User auth object",
 *         @SWG\Schema(ref="#/definitions/UserAuth"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Logged in",
 *         @SWG\Items(ref="#/definitions/User")
 *     ),
 * )
 */
$router->post('login', [
    'uses' => 'AuthLogin@login',
]);

/**
 * @SWG\Post(
 *     path="/logout",
 *     security={{"Bearer":{}}},
 *     tags={"User"},
 *     operationId="logout",
 *     summary="User logout",
 *     description="User logout",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="User Logged Out Successfully"
 *     ),
 * )
 */
$router->post('logout', [
    'uses'       => 'AuthLogout@logout',
    'middleware' => [
        'auth:api',
    ],
]);


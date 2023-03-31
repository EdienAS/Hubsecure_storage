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
$router->get('zip', [
    'uses' => 'Zip@zip',
    'middleware' => [
        'auth:api',
    ],
]);

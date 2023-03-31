<?php

/**
 * @SWG\Get(
 *     path="/traffic/{uuid}",
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
$router->get('traffic/{uuid}', [
    'uses' => 'ShowTraffic@show',
    'middleware' => [
        'auth:api'
    ],
]);

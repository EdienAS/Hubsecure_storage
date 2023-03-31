<?php

/**
 * @SWG\Get(
 *     path="notifications",
 *     security={{"Bearer":{}}},
 *     operationId="notifications",
 *     summary="Get notifications",
 *     description="Get notifications",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="Notifications fetched Successfully."
 *     ),
 * )
 */
$router->get('notifications', [
    'uses'       => 'ListNotificationController@index',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Post(
 *     path="notifications/read",
 *     security={{"Bearer":{}}},
 *     operationId="readNotifications",
 *     summary="Read notifications",
 *     description="Read notifications",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=204,
 *         description="Notifications read Successfully."
 *     ),
 * )
 */
$router->post('notifications/read', [
    'uses'       => 'ReadNotificationController@read',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="notifications",
 *     security={{"Bearer":{}}},
 *     operationId="destroyNotifications",
 *     summary="Destroy notifications",
 *     description="Destroy notifications",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=204 No content,
 *         description="Notifications Destroyed Successfully."
 *     ),
 * )
 */
$router->delete('notifications', [
    'uses'       => 'DestroyNotificationController@destroy',
    'middleware' => [
        'auth:api',
    ],
]);
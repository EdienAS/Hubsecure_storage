<?php

/**
 * @SWG\Store(
 *     path="/permission",
 *     security={{"Bearer":{}}},
 *     tags={"Permission"},
 *     operationId="storePermission",
 *     summary="Store permission",
 *     description="Store permission",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Permission id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Permission ({uuid}) Stored Successfully."
 *     ),
 * )
 */
$router->post('permission', [
    'uses'       => 'Permission\CreatePermission@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/permission/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Get permission by id",
 *     tags={"Permission"},
 *     description="Get permission id",
 *     operationId="permissionById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Permission id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Permission")
 *         ),
 *     ),
 * )
 */
$router->get('permission/{uuid}', [
    'uses' => 'Permission\ShowPermission@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Post(
 *     path="/permission/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"permission"},
 *     operationId="updatePermission",
 *     summary="Update permission",
 *     description="Update permission",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Permission id",
 *     ),
 *     @SWG\Parameter(
 *         name="permission",
 *         in="body",
 *         required=true,
 *         description="Update permission",
 *         @SWG\Schema(ref="#/definitions/UpdatePermission"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Permission updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Permission")
 *         ),
 *     ),
 * )
 */
$router->patch('permission/{uuid}', [
    'uses'       => 'Permission\UpdatePermission@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/permission/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"Permission"},
 *     operationId="deletePermission",
 *     summary="Delete permission",
 *     description="Delete permission",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Permission id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Permission ({uuid}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('permission/{uuid}', [
    'uses'       => 'Permission\DestroyPermission@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/permissions",
 *     security={{"Bearer":{}}},
 *     summary="List permission",
 *     tags={"Permission"},
 *     description="List permission",
 *     operationId="permissionList",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Permission")
 *         ),
 *     ),
 * )
 */
$router->get('permissions', [
    'uses' => 'Permission\ListPermission@index',
    'middleware' => [
        'auth:api'
    ],
]);
<?php

/**
 * @SWG\Store(
 *     path="/role",
 *     security={{"Bearer":{}}},
 *     tags={"Role"},
 *     operationId="storeRole",
 *     summary="Store role",
 *     description="Store role",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="role id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Role ({id}) Stored Successfully."
 *     ),
 * )
 */
$router->post('role', [
    'uses'       => 'Role\CreateRole@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/role/{id}",
 *     security={{"Bearer":{}}},
 *     summary="Get role by id",
 *     tags={"Role"},
 *     description="Get role id",
 *     operationId="roleById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Role id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Role")
 *         ),
 *     ),
 * )
 */
$router->get('role/{uuid}', [
    'uses' => 'Role\ShowRole@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Post(
 *     path="/role/{id}",
 *     security={{"Bearer":{}}},
 *     tags={"role"},
 *     operationId="updateRole",
 *     summary="Update role",
 *     description="Update role",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Role id",
 *     ),
 *     @SWG\Parameter(
 *         name="role",
 *         in="body",
 *         required=true,
 *         description="Update role",
 *         @SWG\Schema(ref="#/definitions/Updaterole"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Role updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Role")
 *         ),
 *     ),
 * )
 */
$router->patch('role/{uuid}', [
    'uses'       => 'Role\UpdateRole@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/role/{id}",
 *     security={{"Bearer":{}}},
 *     tags={"Role"},
 *     operationId="deleteRole",
 *     summary="Delete role",
 *     description="Delete role",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Role id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Role ({id}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('role/{uuid}', [
    'uses'       => 'Role\DestroyRole@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/roles",
 *     security={{"Bearer":{}}},
 *     summary="List role",
 *     tags={"Role"},
 *     description="List role",
 *     operationId="roleList",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Role")
 *         ),
 *     ),
 * )
 */
$router->get('roles', [
    'uses' => 'Role\ListRole@index',
    'middleware' => [
        'auth:api'
    ],
]);

<?php

/**
 * @SWG\Store(
 *     path="/folder",
 *     security={{"Bearer":{}}},
 *     tags={"Folder"},
 *     operationId="storeFolder",
 *     summary="Store folder",
 *     description="Store folder",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="folder id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Folder ({uuid}) Stored Successfully."
 *     ),
 * )
 */
$router->post('folder', [
    'uses'       => 'CreateFolder@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/folder/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Get folder by id",
 *     tags={"Folder"},
 *     description="Get folder id",
 *     operationId="folderById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Folder id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Folder")
 *         ),
 *     ),
 * )
 */
$router->get('folder/{uuid}', [
    'uses' => 'ShowFolder@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Post(
 *     path="/folder/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"folder"},
 *     operationId="updateFolder",
 *     summary="Update folder",
 *     description="Update folder",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Folder id",
 *     ),
 *     @SWG\Parameter(
 *         name="folder",
 *         in="body",
 *         required=true,
 *         description="Update folder",
 *         @SWG\Schema(ref="#/definitions/Updatefolder"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Folder updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Folder")
 *         ),
 *     ),
 * )
 */
$router->patch('folder/{uuid}', [
    'uses'       => 'UpdateFolder@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/folder/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"Folder"},
 *     operationId="deleteFolder",
 *     summary="Delete folder",
 *     description="Delete folder",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Folder id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Folder ({uuid}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('folder/{uuid}', [
    'uses'       => 'DestroyFolder@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/folders",
 *     security={{"Bearer":{}}},
 *     summary="List folder",
 *     tags={"Folder"},
 *     description="List folder",
 *     operationId="folderList",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Folder")
 *         ),
 *     ),
 * )
 */
$router->get('folders', [
    'uses' => 'ListFolder@index',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="/movefolder/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Move folder",
 *     tags={"MoveFolder"},
 *     description="Move folder",
 *     operationId="movefolder",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/Folder")
 *         ),
 *     ),
 * )
 */
$router->patch('movefolder/{uuid}', [
    'uses' => 'MoveFolder@move',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="/getfolder/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Get folder by uuid",
 *     tags={"file"},
 *     description="Get folder by uuid",
 *     operationId="fileById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="folder uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/file")
 *         ),
 *     ),
 * )
 */
$router->get('getfolder/{uuid}', [
    'uses' => 'GetFolder@getFolder',
    'middleware' => [
        'auth:api'
    ],
])->name('getfolder');


/**
 * @SWG\Delete(
 *     path="/folder/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"Folder"},
 *     operationId="trashFolder",
 *     summary="Trash folder",
 *     description="Trash folder",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="Folder id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Folder ({uuid}) Trashed Successfully."
 *     ),
 * )
 */
$router->delete('trashfolder/{uuid}', [
    'uses'       => 'TrashFolder@trash',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/trashedfolders",
 *     security={{"Bearer":{}}},
 *     summary="List Trashed folders",
 *     tags={"TrashedFile"},
 *     description="List Trashed folders",
 *     operationId="trashedfoldersList",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/File")
 *         ),
 *     ),
 * )
 */
$router->get('trashedfolders', [
    'uses' => 'ListTrashedFolder@index',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Delete(
 *     path="/restorefolder/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"RestoreFolder"},
 *     operationId="restoreFolder",
 *     summary="Restore folder",
 *     description="Restore folder",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="Folder ({uuid}) restored Successfully."
 *     ),
 * )
 */
$router->patch('restorefolders', [
    'uses'       => 'RestoreFolder@restore',
    'middleware' => [
        'auth:api',
    ],
]);
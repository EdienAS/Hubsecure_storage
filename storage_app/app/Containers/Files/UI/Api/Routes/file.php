<?php

/**
 * @SWG\Store(
 *     path="upload/file",
 *     security={{"Bearer":{}}},
 *     tags={"File"},
 *     operationId="uploadFile",
 *     summary="Upload file",
 *     description="Upload file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="file",
 *         in="path",
 *         type="file",
 *         required=true,
 *         description="file",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File ({uuid}) Stored Successfully."
 *     ),
 * )
 */
$router->post('upload/file', [
    'uses'       => 'UploadFile@upload',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/file/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Get file by id",
 *     tags={"file"},
 *     description="Get file id",
 *     operationId="fileById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="file id",
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
$router->get('file/{uuid}', [
    'uses' => 'ShowFile@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Post(
 *     path="/file/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"file"},
 *     operationId="updateFile",
 *     summary="Update file",
 *     description="Update file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="File id",
 *     ),
 *     @SWG\Parameter(
 *         name="file",
 *         in="body",
 *         required=true,
 *         description="Update file",
 *         @SWG\Schema(ref="#/definitions/Updatefile"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/File")
 *         ),
 *     ),
 * )
 */
$router->patch('file/{uuid}', [
    'uses'       => 'UpdateFile@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/file/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"File"},
 *     operationId="deleteFile",
 *     summary="Delete file",
 *     description="Delete file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="File id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File ({uuid}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('file/{uuid}', [
    'uses'       => 'DestroyFile@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/files",
 *     security={{"Bearer":{}}},
 *     summary="List files",
 *     tags={"File"},
 *     description="List file",
 *     operationId="fileList",
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
$router->get('files', [
    'uses' => 'ListFile@index',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="/movefile/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Move file",
 *     tags={"MoveFile"},
 *     description="Move file",
 *     operationId="movefile",
 *     produces={"application/json"},
 *     
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/file")
 *         ),
 *     ),
 * )
 */
$router->patch('movefile/{uuid}', [
    'uses' => 'MoveFile@move',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="/file/{name}",
 *     security={{"Bearer":{}}},
 *     summary="Get file by name",
 *     tags={"file"},
 *     description="Get file name",
 *     operationId="fileById",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="file name",
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
$router->get('getfile/{basename}', [
    'uses' => 'GetFile@getFile',
    'middleware' => [
        'auth:api'
    ],
])->name('getfile');

/**
 * @SWG\Delete(
 *     path="/file/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"File"},
 *     operationId="trashFile",
 *     summary="Trash file",
 *     description="Trash file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="id",
 *         in="path",
 *         type="integer",
 *         required=true,
 *         description="File id",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File ({uuid}) Trashed Successfully."
 *     ),
 * )
 */
$router->delete('trashfile/{uuid}', [
    'uses'       => 'TrashFile@trash',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/trashedfiles",
 *     security={{"Bearer":{}}},
 *     summary="List Trashed files",
 *     tags={"TrashedFile"},
 *     description="List Trashed file",
 *     operationId="trashedfileList",
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
$router->get('trashedfiles', [
    'uses' => 'ListTrashedFile@index',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Delete(
 *     path="/restorefile/{uuid}",
 *     security={{"Bearer":{}}},
 *     tags={"RestoreFile"},
 *     operationId="restoreFile",
 *     summary="Restore file",
 *     description="Restore file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response=200,
 *         description="File ({uuid}) restored Successfully."
 *     ),
 * )
 */
$router->patch('restorefiles', [
    'uses'       => 'RestoreFile@restore',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Store(
 *     path="upload/file",
 *     security={{"Bearer":{}}},
 *     tags={"File"},
 *     operationId="uploadFile",
 *     summary="Upload file",
 *     description="Upload file",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="file",
 *         in="path",
 *         type="file",
 *         required=true,
 *         description="file",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File ({uuid}) Stored Successfully."
 *     ),
 * )
 */
$router->post('upload/chunks', [
    'uses'       => 'UploadFileChunks@uploadChunks',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/getthumbnail/{filename}",
 *     security={{"Bearer":{}}},
 *     summary="Get thumbnail by name",
 *     tags={"file"},
 *     description="Get thumbnail name",
 *     operationId="thumbnailByName",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="filename",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="thumbnail name",
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
$router->get('getthumbnail/{name}', [
    'uses' => 'GetThumbnail@getThumbnail',
    'middleware' => [
        'auth:api',
    ],
])->name('getthumbnail');

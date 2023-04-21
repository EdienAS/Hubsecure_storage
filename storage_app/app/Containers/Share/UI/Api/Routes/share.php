<?php

/**
 * @SWG\Post(
 *     path="/share",
 *     security={{"Bearer":{}}},
 *     operationId="share",
 *     summary="Share Item",
 *     description="Create a new share item",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="item_uuid",in="body",required=true,
 *          description="File or Folder uuid to be shared"),
 *     @SWG\Parameter(name="uuid",in="body",required=true,
 *          description="Static value uuid"),
 *     @SWG\Parameter(name="isPassword",in="body",required=sometimes,
 *          description="Boolean value"),
 *     @SWG\Parameter(name="password",in="body",required=if isPassword is true,
 *          description="secret password"),
 *     @SWG\Parameter(name="type",in="body",required=true,
 *          description="Value must be file,folder"),
 *     @SWG\Parameter(name="expiration",in="body",required=sometimes,
 *          description="Hours in integer"),
 *     @SWG\Parameter(name="permission",in="body",required=if type is folder,
 *          description="Value must be visitor,editor"),
 *     @SWG\Parameter(name="emails",in="body",required=sometimes,
 *          description="Array of emails"),
 *     @SWG\Response(
 *         response=200,
 *         description="Share item created",
 *     ),
 * )
 */
$router->post('share', [
    'uses' => 'ShareItem@create',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/share/{token}",
 *     security={{"Bearer":{}}},
 *     summary="Get share by token",
 *     tags={"file"},
 *     description="Get share by token",
 *     operationId="shareByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="token",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="share token",
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
$router->get('share/{token}', [
    'uses' => 'ShowShareItem@show',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Patch(
 *     path="/share/{token}",
 *     security={{"Bearer":{}}},
 *     tags={"file"},
 *     operationId="updateShare",
 *     summary="Update Share",
 *     description="Update share",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="token",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="Share token",
 *     ),
 *     @SWG\Parameter(
 *         name="file",
 *         in="body",
 *         required=true,
 *         description="Share token",
 *         @SWG\Schema(ref="#/definitions/Updateshare"),
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Share updated",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/File")
 *         ),
 *     ),
 * )
 */
$router->patch('share/{token}', [
    'uses'       => 'UpdateShareItem@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="/share/{token}",
 *     security={{"Bearer":{}}},
 *     tags={"Share"},
 *     operationId="deleteShare",
 *     summary="Delete share",
 *     description="Delete share",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(
 *         name="token",
 *         in="path",
 *         type="string",
 *         required=true,
 *         description="Share token",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Share ({id}) Deleted Successfully."
 *     ),
 * )
 */
$router->delete('share/', [
    'uses'       => 'DestroyShareItem@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="/sharing/{token}",
 *     summary="Share item details publicly",
 *     description="Get share item details by token publicly",
 *     operationId="sharingByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="token",in="path",type="string",required=true,
 *          description="Existing share item token",),
 *     @SWG\Response(
 *         response=200,
 *         description="Shared item details"
 *     ),
 * )
 */
$router->get('sharing/{token}', [
    'uses' => 'ShowShareItem@public',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/authenticate/{shared}",
 *     summary="Authenticate shared item",
 *     description="Authenticate password protected shared item",
 *     operationId="sharingAuthenticateByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),
 *     @SWG\Parameter(name="password",in="body",type="string",required=true,
 *         description="Secret password"),
 *     @SWG\Response(
 *         response=204 No Content,
 *         description="successful operation"
 *     ),
 * )
 */
$router->post('sharing/authenticate/{shared}', [
    'uses' => 'AuthenticateShareItem@authenticate',
    'middleware' => [],
]);

/**
 * @SWG\Get(
 *     path="/sharing/item/{token}",
 *     summary="Get shared item by token",
 *     description="Get details or download shared item by token",
 *     operationId="sharingItemByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="token",in="path",type="string",required=true,
 *         description="Existing shared item token"),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *         @SWG\Schema(
 *            @SWG\Items(ref="#/definitions/file")
 *         ),
 *     ),
 * )
 */
$router->get('sharing/item/{token}', [
    'uses' => 'PublicGetSharedItem@get',
    'middleware' => [],
]);

/**
 * @SWG\Get(
 *     path="/sharing/create-folder/{shared}",
 *     summary="Create Folder in shared item",
 *     description="Editor can create folder in existing shared item",
 *     operationId="sharingCreateFolderByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),
 *     @SWG\Response(
 *         response=201 Created,
 *         description="successful operation with content",
 *     ),
 * )
 */
$router->post('sharing/create-folder/{shared}', [
    'uses' => 'PublicCreateFolder@create',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/move/{shared}",
 *     summary="Move items in shared item",
 *     description="Editor can move items in existing shared item",
 *     operationId="sharingMoveByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),
 *     @SWG\Parameter(name="parent_folder_id",in="body",type="integer",required=true,
 *         description="Existing folder id"),
 *     @SWG\Parameter(name="items.*.type",in="body",type="string",required=true,
 *         description="Value must be file,folder"),
 *     @SWG\Parameter(name="items.*.id",in="body",type="integer",required=true,
 *         description="Moving Item id"),
 *     @SWG\Response(
 *         response=204 No Content,
 *         description="successful operation",
 *     ),
 * )
 */
$router->patch('sharing/move/{shared}', [
    'uses' => 'PublicMoveSharedItem@update',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/update/{id}/{shared}",
 *     summary="Update item in shared item",
 *     description="Editor can update item in existing shared item",
 *     operationId="sharingUpdateByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="id",in="path",type="integer",required=true,
 *         description="Id of item to be updated"), 
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),   
 *     @SWG\Parameter(name="items.*.type",in="body",type="string",required=true,
 *         description="Value must be file,folder"),
 *     @SWG\Parameter(name="name",in="body",type="string",required=optional,
 *         description="New name to be updated"),
 *     @SWG\Response(
 *         response=204 No Content,
 *         description="successful operation",
 *     ),
 * )
 */
$router->patch('sharing/update/{id}/{shared}', [
    'uses' => 'PublicUpdateSharedItem@update',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/trash/{shared}",
 *     summary="Trash items in shared item",
 *     description="Editor can trash items in existing shared item",
 *     operationId="sharingTrashByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),   
 *     @SWG\Parameter(name="items.*.type",in="body",type="string",required=true,
 *         description="Value must be file,folder"),
 *     @SWG\Parameter(name="items.*.id",in="body",type="integer",required=true,
 *         description="Trashing Item id"),
 *     @SWG\Response(
 *         response=204 No Content,
 *         description="successful operation",
 *     ),
 * )
 */
$router->delete('sharing/trash/{shared}', [
    'uses' => 'PublicTrashSharedItem@trash',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/upload/{shared}",
 *     summary="Upload files in shared item",
 *     description="Editor can upload files in existing shared item",
 *     operationId="sharingUploadByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),   
 *     @SWG\Parameter(name="uuid",in="body",type="uuid",required=true,
 *         description="Value must be 'uuid'"),
 *     @SWG\Parameter(name="files.*",in="body",type="file",required=true|array,
 *         description="File"),
 *     @SWG\Parameter(name="parent_folder_id",in="body",type="integer",required=optional,
 *         description="Valid Folder id"),
 *     @SWG\Response(
 *         response=201 Created,
 *         description="successful operation with no content",
 *     ),
 * )
 */
$router->post('sharing/upload/{shared}', [
    'uses' => 'PublicUploadSharedItem@upload',
    'middleware' => [],
]);

/**
 * @SWG\Post(
 *     path="/sharing/upload/chunks/{shared}",
 *     summary="Upload chunks in shared item",
 *     description="Editor can upload chunks in existing shared item",
 *     operationId="sharingUplaodChunksByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),   
 *     @SWG\Parameter(name="uuid",in="body",type="uuid",required=true,
 *         description="Value must be 'uuid'"),
 *     @SWG\Parameter(name="files.*",in="body",type="file",required=true|array|max:1,
 *         description="File"),
 *     @SWG\Parameter(name="parent_folder_id",in="body",type="integer",required=optional,
 *         description="Valid Folder id"),
 *     @SWG\Parameter(name="path",in="body",type="string",required=optional,
 *         description="Path with folder name"),
 *     @SWG\Parameter(name="is_last_chunk",in="body",type="boolean",required=true,
 *         description="Valid Folder id"),
 *     @SWG\Parameter(name="extension",in="body",type="string",required=true,
 *         description="Valid Folder id"),
 *     @SWG\Response(
 *         response=201 Created,
 *         description="successful operation with no content",
 *     ),
 * )
 */
$router->post('sharing/upload/chunks/{shared}', [
    'uses' => 'PublicUploadChunksSharedItem@uploadChunks',
    'middleware' => [],
]);

/**
 * @SWG\Get(
 *     path="/sharing/zip/{shared}",
 *     summary="Zip shared item",
 *     description="Editor can zip existing shared item",
 *     operationId="sharingZipByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),   
 *     @SWG\Parameter(name="items",in="path",type="string",required=true,
 *         description="Pattern: <item_uuid>|<item_type>"),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *     ),
 * )
 */
$router->get('sharing/zip/{shared}', [
    'uses' => 'PublicZipSharedItem@zip',
    'middleware' => [],
]);

/**
 * @SWG\Get(
 *     path="thumbnail/{name}/sharing/{shared}",
 *     summary="Get thumbnail of shared items",
 *     description="Editor can get thumbnail of shared item",
 *     operationId="sharingThumbnailByToken",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="name",in="path",type="string",required=true,
 *         description="thumbnail name"),   
 *     @SWG\Parameter(name="shared",in="path",type="string",required=true,
 *         description="Existing shared item token"),
 *     @SWG\Response(
 *         response=200,
 *         description="successful operation",
 *     ),
 * )
 */
$router->get('getthumbnail/{name}/sharing/{shared}', [
    'uses' => 'PublicGetThumbnailSharedItem@getSharedThumbnail',
    'middleware' => [],
])->name('getsharedThumbnail');
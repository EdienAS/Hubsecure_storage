<?php

/**
 * @SWG\Get(
 *     path="browse/folders/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Browse folder by uuid",
 *     tags={"Folder"},
 *     description="Browse folder uuid",
 *     operationId="BrowseFolderById",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=optional,
 *         description="Folder uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Folders fetched Successfully",
 *     ),
 * )
 */
$router->get('search', [
    'uses' => 'SearchFileFolder@get',
    'middleware' => [
        'auth:api'
    ],
]);

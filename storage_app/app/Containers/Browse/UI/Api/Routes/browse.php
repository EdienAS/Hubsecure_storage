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
$router->get('browse/folders/{uuid?}', [
    'uses' => 'BrowseFolder@get',
    'middleware' => [
        'auth:api'
    ],
]);

/**
 * @SWG\Get(
 *     path="browse/teams/folders/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="browseTeamsFolders",
 *     summary="Browse Team Folders",
 *     description="Browse Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=optional,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team Folder fetched Successfully."
 *     ),
 * )
 */
$router->get('browse/teams/folders/{uuid?}', [
    'uses'       => 'BrowseTeamFolder@get',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="browse/teams/shared-with-me/{id}",
 *     security={{"Bearer":{}}},
 *     operationId="browseSharedWithMe",
 *     summary="Browse Shared with me",
 *     description="Browse Shared with me",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="id",in="path",type="integer",required=true,
 *          description="team invitation uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team invitation updated Successfully."
 *     ),
 * )
 */
$router->get('browse/teams/shared-with-me/{uuid?}', [
    'uses'       => 'BrowseSharedWithMe@get',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="browse/trash/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Browse trash folder by uuid",
 *     tags={"Folder"},
 *     description="Browse trash folder uuid",
 *     operationId="browseTrashFolderById",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=optional,
 *         description="Folder uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Trashed Folders fetched Successfully",
 *     ),
 * )
 */
$router->get('browse/trash', [
    'uses' => 'BrowseTrash@get',
    'middleware' => [
        'auth:api'
    ],
]);
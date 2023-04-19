<?php

/**
 * @SWG\Get(
 *     path="search",
 *     security={{"Bearer":{}}},
 *     summary="Search files and folders",
 *     tags={"Search"},
 *     description="Search files and folders",
 *     operationId="SearchFilesAndFolders",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="query",in="path",type="string",required=optional,
 *         description="Search files and folders name",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Operation Successful",
 *     ),
 * )
 */
$router->get('search', [
    'uses' => 'SearchFileFolder@get',
    'middleware' => [
        'auth:api'
    ],
]);

<?php

/**
 * @SWG\Post(
 *     path="xrpl/upload/{uuid}",
 *     security={{"Bearer":{}}},
 *     summary="Upload file to xrpl by uuid",
 *     tags={"XrplUpload"},
 *     description="Upload file to xrpl by uuid",
 *     operationId="UploadXrpl",
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=optional,
 *         description="Folder uuid",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="File uploaded Successfully",
 *     ),
 * )
 */
$router->post('xrpl/upload/{uuid}', [
    'uses' => 'XrplUpload@upload',
    'middleware' => [
        'auth:api'
    ],
]);

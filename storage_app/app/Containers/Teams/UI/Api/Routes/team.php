<?php

/**
 * @SWG\Post(
 *     path="teams/folders",
 *     security={{"Bearer":{}}},
 *     operationId="teamsFolders",
 *     summary="Create Team Folders",
 *     description="Create Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="body",type="string",required=true,
 *          description="uuid"),
 *     @SWG\Parameter(name="name",in="body",type="string",required=true,
 *          description="Folder name"),
 *     @SWG\Parameter(name="invitations",in="body",type="array",required=true,
 *          description="Array of email, permission, type")
 *     @SWG\Response(
 *         response=201,
 *         description="Team Folder created Successfully."
 *     ),
 * )
 */
$router->post('teams/folders', [
    'uses'       => 'CreateTeamFolder@store',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="teams/folders/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="showTeamsFolders",
 *     summary="Show Team Folders",
 *     description="Show Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team Folder fetched Successfully."
 *     ),
 * )
 */
$router->get('teams/folders/{uuid}', [
    'uses'       => 'ShowTeamFolder@show',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="teams/folders",
 *     security={{"Bearer":{}}},
 *     operationId="showTeamsFolders",
 *     summary="List Team Folders",
 *     description="Show Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="orderBy",in="path",type="string",required=optional,
 *          description="Order by ASC/DESC"),
 *     @SWG\Parameter(name="limit",in="path",type="integer",required=optional,
 *          description="Limit records")
 *     @SWG\Response(
 *         response=200,
 *         description="Team Folders fetched Successfully."
 *     ),
 * )
 */
$router->get('teams/folders', [
    'uses'       => 'ListTeamFolder@index',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Patch(
 *     path="teams/folders/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="updateTeamsFolders",
 *     summary="Update Team Folders",
 *     description="Update Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team Folder updated Successfully."
 *     ),
 * )
 */
$router->patch('teams/folders/{uuid}', [
    'uses'       => 'UpdateTeamFolder@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="teams/folders/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="destroyTeamsFolders",
 *     summary="Destroy Team Folders",
 *     description="Destroy Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=204,
 *         description="Team Folder dissolved Successfully."
 *     ),
 * )
 */
$router->delete('teams/folders/{uuid}', [
    'uses'       => 'DestroyTeamFolder@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Post(
 *     path="teams/folders/{uuid}/convert",
 *     security={{"Bearer":{}}},
 *     operationId="convertToTeamsFolders",
 *     summary="Convert to Team Folders",
 *     description="Convert to Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=204,
 *         description="Folder converted to Team Folder Successfully."
 *     ),
 * )
 */
$router->post('teams/folders/{uuid}/convert', [
    'uses'       => 'ConvertTeamFolder@convert',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="teams/folders/{uuid}/leave",
 *     security={{"Bearer":{}}},
 *     operationId="leaveTeamsFolders",
 *     summary="Leave Team Folders",
 *     description="Leave Team Folders",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team folder uuid"),
 *     @SWG\Response(
 *         response=204,
 *         description="Member left Team Folder Successfully."
 *     ),
 * )
 */
$router->delete('teams/folders/{uuid}/leave', [
    'uses'       => 'LeaveTeamFolder@leave',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="teams/invitations/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="showTeamInvitation",
 *     summary="Show Team Invitations",
 *     description="Show Team Invitations",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team invitation uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team invitation fetched Successfully."
 *     ),
 * )
 */
$router->get('teams/invitations/{uuid}', [
    'uses'       => 'ShowTeamInvitation@show',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Get(
 *     path="teams/invitations",
 *     security={{"Bearer":{}}},
 *     operationId="listTeamInvitation",
 *     summary="List Team Invitations",
 *     description="List Team Invitations",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="type",in="path",type="string",required=optional,
 *          description="type: received/sent"),
 *     @SWG\Parameter(name="orderBy",in="path",type="string",required=optional,
 *          description="Order by ASC/DESC"),
 *     @SWG\Parameter(name="limit",in="path",type="integer",required=optional,
 *          description="Limit records")
 *     @SWG\Response(
 *         response=200,
 *         description="Team invitations fetched Successfully."
 *     ),
 * )
 */
$router->get('teams/invitations', [
    'uses'       => 'ListTeamInvitation@index',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Patch(
 *     path="teams/invitations/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="updateTeamInvitation",
 *     summary="Update Team Invitations",
 *     description="Update Team Invitations",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team invitation uuid"),
 *     @SWG\Response(
 *         response=200,
 *         description="Team invitation updated Successfully."
 *     ),
 * )
 */
$router->patch('teams/invitations/{uuid}', [
    'uses'       => 'UpdateTeamInvitation@update',
    'middleware' => [
        'auth:api',
    ],
]);

/**
 * @SWG\Delete(
 *     path="teams/invitations/{uuid}",
 *     security={{"Bearer":{}}},
 *     operationId="updateTeamInvitation",
 *     summary="Update Team Invitations",
 *     description="Update Team Invitations",
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Parameter(name="uuid",in="path",type="uuid",required=true,
 *          description="team invitation uuid"),
 *     @SWG\Response(
 *         response=204 No Content,
 *         description="Team invitation deleted Successfully."
 *     ),
 * )
 */
$router->delete('teams/invitations/{uuid}', [
    'uses'       => 'DestroyTeamInvitation@destroy',
    'middleware' => [
        'auth:api',
    ],
]);

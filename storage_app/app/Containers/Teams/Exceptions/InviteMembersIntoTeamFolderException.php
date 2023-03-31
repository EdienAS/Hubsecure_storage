<?php

namespace App\Containers\Teams\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InviteMembersIntoTeamFolderException.
 *
 */
class InviteMembersIntoTeamFolderException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed inviting Members to Team Folder.';
}

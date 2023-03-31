<?php

namespace App\Containers\Teams\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateTeamInvitationException.
 *
 */
class UpdateTeamInvitationException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed updating Team Folder Invitation.';
}

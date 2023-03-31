<?php

namespace App\Containers\Teams\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeamFolderMemberException.
 *
 */
class TeamFolderMemberException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed creating Team Folder Member.';
}

<?php

namespace App\Containers\XRPLBlock\Exceptions;

use App\Abstracts\ExceptionHttp;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XRPLDownloadDocumentException.
 *
 */
class XRPLDownloadDocumentException extends ExceptionHttp
{

    public $httpStatusCode = Response::HTTP_CONFLICT;

    public $message = 'Failed downloading document form XRPL Block.';
}

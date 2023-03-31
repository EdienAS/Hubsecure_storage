<?php

namespace App\Abstracts;

use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Exception as BaseException;
use Log;

/**
 * Class ExceptionHttp
 * @package App\Abstracts
 */
class ExceptionHttp extends HttpException
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * MessageBag errors.
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;
    
    /**
     * Default text-message
     *
     * @var string
     */
    protected $message;
    
    /**
     * Default code in tranlation files
     *
     * @var string
     */
    protected $messageTransCode;
    
    /**
     * Default status code.
     *
     * @var int
     */
    protected $httpStatusCode;
    
    /**
     * Default status code.
     *
     * @var int
     */
    private $defaultHttpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
    
    /**
     * @var string
     */
    protected $environment;

    /**
     * ExceptionWeb constructor.
     *
     * @param null            $message
     * @param null            $statusCode
     * @param null            $errors
     * @param \Exception|null $previous
     * @param array           $headers
     * @param int             $code
     */
    public function __construct(
        $message = null,
        $statusCode = null,
        $errors = null,
        \Exception $previous = null,
        $headers = [],
        $code = 0
    ) {
        // detect and set the running environment
        $this->environment = config('app.env');
        
        if (is_null($message)) {
            if(!empty($this->messageTransCode)) {
                $message = trans($this->messageTransCode);
            }
            elseif (!empty($this->message)) {
                $message = $this->message;
            }
        }
        
        if (is_null($errors)) {
            $this->errors = new MessageBag();
        }
        else {
            $this->errors = is_array($errors) ? new MessageBag($errors) : $errors;
        }
        
        if (is_null($statusCode)) {
            if ($this->httpStatusCode) {
                $statusCode = $this->httpStatusCode;
            }
            elseif (!empty($this->defaultHttpStatusCode)) {
                $statusCode = $this->defaultHttpStatusCode;
            }
        }
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * Help developers debug the error without showing these details to the end user.
     * Usage: `throw (new MyCustomException())->debug($e)`.
     *
     * @param $error
     * @param $force
     *
     * @return $this
     */
    public function debug($error, $force = false)
    {
        if ($error instanceof BaseException) {
            $error = $error->getMessage();
        }

        if ($this->environment != 'testing' || $force === true) {
            Log::error('[DEBUG] ' . $error);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        if(is_null($this->request)) {
            $this->request = app('request');
        }
        return $this->request;
    }
    
    /**
     * Get the errors message bag.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * Determine if message bag has any errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !$this->errors->isEmpty();
    }
    
    
    /**
     * Set default handler
     */
    public function render()
    {
        if($this->getRequest()->isJson() || $this->request->expectsJson()) {
            return $this->returnJsonResponse($this->getMessage(), $this->getStatusCode());
        }
        abort($this->getStatusCode(), $this->getMessage());
    }

    /**
     * @param $message
     * @param $code
     *
     * @return \Illuminate\Http\Response
     */
    protected function returnJsonResponse($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }
}
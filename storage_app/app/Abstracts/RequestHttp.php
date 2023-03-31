<?php

namespace App\Abstracts;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class RequestHttp
 * @package App\Abstracts
 */
abstract class RequestHttp extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The key to be used for the view error bag.ValidationRequest
     *
     * @var string
     */
    protected $errorBag = 'default';

    /**
     * @var array
     */
    protected $uriVariables = [];

    /**
     * ApiRequest constructor.
     *
     * @param array                                        $query
     * @param array                                        $request
     * @param array                                        $attributes
     * @param array                                        $cookies
     * @param array                                        $files
     * @param array                                        $server
     * @param null                                         $content
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
        Application $app
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->app = $app;

        $this->initializeRequest($app['request']);
        $this->validate();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected function initializeRequest(HttpRequest $request)
    {
        $files = $request->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $this->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $files,
            $request->server->all(),
            $request->getContent()
        );

        if($session = $request->getSession()) {
            $this->setLaravelSession($session);
        }

        $this->setUserResolver($request->getUserResolver());

        $this->setRouteResolver($request->getRouteResolver());
    }

    /**
     * @param null $keys
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);

        if($this->uriVariables) {
            foreach($this->route() as $part) {
                if(!is_array($part)) {
                    continue;
                }
                foreach($part as $key => $value) {
                    if(!in_array($key, $this->uriVariables)) {
                        continue;
                    }
                    $data[$key] = $value;
                }
            }
        }

        return $data;
    }


    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $factory = $this->app->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            return $this->app->call([$this, 'validator'], compact('factory'));
        }

        return $factory->make(
            $this->all(),
            $this->app->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        );
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }

    /**
     * Determine if the request passes the authorization check.
     *
     * @return bool
     */
    protected function passesAuthorization()
    {
        if (method_exists($this, 'authorize')) {
            return $this->app->call([$this, 'authorize']);
        }

        return false;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return mixed
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException($this->forbiddenResponse());
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        return new Response('Forbidden', Response::HTTP_FORBIDDEN);
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Set custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}

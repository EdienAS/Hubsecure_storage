<?php

namespace App\Abstracts;

use Config;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;

/**
 * Class ControllerApi
 * @package App\Abstracts
 */
abstract class ControllerApi extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * ControllerApi constructor.
     *
     * @param \League\Fractal\Manager $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }
    
    /**
     * @param                                     $data
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return array
     */
    public function responseItem($data, TransformerAbstract $transformer):array
    {
        return $this->fractal->createData(new Item($data, $transformer))->toArray();
    }
    
    /**
     * @param \Illuminate\Support\Collection      $data
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return array
     */
    public function responseCollection(\Illuminate\Support\Collection $data, TransformerAbstract $transformer):array
    {
        return $this->fractal->createData(new Collection($data, $transformer))->toArray();
    }
    
    /**
     * @param                                     $data
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return array
     */
    public function responseArrayData($data, TransformerAbstract $transformer):array
    {
        return $this->fractal->createData(new Collection($data, $transformer))->toArray();
    }
    
    /**
     * @param \Illuminate\Contracts\Pagination\Paginator $data
     * @param \League\Fractal\TransformerAbstract        $transformer
     *
     * @return array
     */
    public function responsePaginateCollection(Paginator $data, TransformerAbstract $transformer):array
    {
        $item = new Collection($data->getCollection(), $transformer);
        $item->setPaginator(new IlluminatePaginatorAdapter($data));
        
        return $this->fractal->createData($item)->toArray();
    }
    
    /**
     * @param null  $content
     * @param array $headers
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function responseOk($content=null, array $headers=[]): Response
    {
        $headers['status'] = Config::get('status.success');
        return (new Response($content))->setStatusCode(200)->withHeaders($headers);
    }
    
    /**
     * @param null  $content
     * @param null  $location
     * @param array $headers
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function responseCreated($content=null, array $headers=[]): Response
    {
        $headers['status'] = Config::get('status.success');
        return (new Response($content))->setStatusCode(201)->withHeaders($headers);
    }
    
    /**
     * @param null  $content
     * @param null  $location
     * @param array $headers
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function responseAccepted($content=null, $location = null, array $headers=[]): Response
    {
        $response = new Response($content);
        $response->setStatusCode(202);
        
        if(!is_null($location)) {
            $response->header('Location', $location);
        }
        
        return $response->withHeaders($headers);
    }
    
    
    /**
     * @param null  $content
     * @param null  $location
     * @param array $headers
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function responseNoContent(array $headers=[]): Response
    {
        $headers['status'] = Config::get('status.success');
        return (new Response())->setStatusCode(204)->withHeaders($headers);
    }
    
    /**
     * @param null  $content
     * @param array $headers
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function responseUnauthorized(array $headers=[]): Response
    {
        $headers['status'] = Config::get('status.unauthenticated');
        return (new Response())->setStatusCode(401)->withHeaders($headers);
    }
}

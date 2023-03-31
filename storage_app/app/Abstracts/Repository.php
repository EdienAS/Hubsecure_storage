<?php

namespace App\Abstracts;

use Illuminate\Container\Container as Application;
use Illuminate\Database\ConnectionInterface;
use Prettus\Repository\Contracts\CacheableInterface as PrettusCacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria as PrettusRequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository as PrettusRepository;
use Prettus\Repository\Traits\CacheableRepository as PrettusCacheableRepository;

/**
 * Class Repository
 * @package App\Abstracts
 */
abstract class Repository extends PrettusRepository implements PrettusCacheableInterface
{

    use PrettusCacheableRepository;
    
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    private $connect;
    
    /**
     * Repository constructor.
     *
     * @param \Illuminate\Container\Container $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    
        $this->connect = $app['db']->connection();
    }
    
    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnect(): ConnectionInterface
    {
        return $this->connect;
    }
    
    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(PrettusRequestCriteria::class));
    }
}

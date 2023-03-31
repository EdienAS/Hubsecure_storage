<?php

namespace App\Abstracts;

use Illuminate\Container\Container as Application;
use Illuminate\Database\ConnectionInterface;

/**
 * Class Repository
 * @package App\Abstracts
 */
abstract class CustomRepository
{
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
        $this->connect = $app['db']->connection();
    }
    
    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnect(): ConnectionInterface
    {
        return $this->connect;
    }
}

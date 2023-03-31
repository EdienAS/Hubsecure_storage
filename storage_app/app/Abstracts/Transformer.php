<?php

namespace App\Abstracts;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

/**
 * Class Task
 * @package App\Abstracts
 */
abstract class Transformer extends TransformerAbstract
{
    /**
     * @param string $timestamp
     *
     * @return int
     */
    protected function getUnixTimestamp(string $timestamp): int
    {
        return (new Carbon($timestamp))->timestamp;
    }
}

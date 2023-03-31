<?php

namespace App\Abstracts;

use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class Policy
 * @package App\Abstracts
 */
abstract class Policy
{
    use HandlesAuthorization;
}

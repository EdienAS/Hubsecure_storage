<?php
namespace App\Containers\User\Restrictions;

use Illuminate\Support\Manager;
use App\Containers\User\Restrictions\Engines\DefaultRestrictionsEngine;

class RestrictionsManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return get_restriction_driver();
    }

    public function createDefaultDriver(): DefaultRestrictionsEngine
    {
        return new DefaultRestrictionsEngine();
    }
}

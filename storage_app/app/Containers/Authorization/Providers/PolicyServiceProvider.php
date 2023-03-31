<?php

namespace App\Containers\Authorization\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class PoliciesServiceProvider.
 *
 * This Task Provider is designed to map the policies to their models.
 * Must be manually added to the list of extra service providers in the
 * containers config file in order to get registered in the framework.
 *
 */
class PolicyServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

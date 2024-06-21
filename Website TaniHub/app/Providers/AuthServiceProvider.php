<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\DashboardPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => DashboardPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}

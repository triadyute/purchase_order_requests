<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-all-users', function($user){
            return $user->hasAdminRole() || $user->hasSuperUserRole();
        });

        Gate::define('add-departments', function($user){
            $user->hasSuperUserRole();
        });

        Gate::define('view-all-pos', function ($user) {
            return $user->hasRole('Admin') || $user->hasSuperUserRole();
        });

        Gate::define('view-my-staff-pos', function ($user) {
            return $user->hasRole('Manager');
        });

        Gate::define('view-staff-pos', function ($user) {
            return $user->hasRole('Senior Manager');
        });

        Gate::define('view-my-staff-pos', function ($user) {
            return $user->hasRole('Manager');
        });
    }
}

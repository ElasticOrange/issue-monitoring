<?php

namespace Issue\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Issue\Model' => 'Issue\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        $gate->before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }

            if ($user->isEditor()) {

                if (in_array(
                    $ability,
                    [
                        'list-users',
                        'create-users',
                        'store-users',
                        'edit-users',
                        'update-users',
                        'show-users',
                        'delete-users'
                    ]
                )) {
                    return false;
                }
                return true;
            }

            if ($user->isClient()) {
                return false;
            }

            return false;
        });
    }
}

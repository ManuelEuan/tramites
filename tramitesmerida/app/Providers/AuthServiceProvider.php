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

        /** Mis Gates **/

        //Comprueba si es super admin o admin
        Gate::define('isAdministradorOrEnlace', function ($user) {
            switch ($user->TRAM_CAT_ROL->ROL_CCLAVE) {
                case ("ADM"):
                    return true;
                    break;
                case ("ENLOF"):
                    return true;
                    break;
                case ("ADMCT"):
                    return false;
                    break;
                default:
                    return false;
            }
        });
    }
}

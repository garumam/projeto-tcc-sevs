<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        if (Schema::hasTable('permissions')) {
            foreach ($this->getPermissions() as $permission) {
                Gate::define($permission->nome, function ($user) use ($permission) {
                    return $user->existsRole($permission->roles) || $user->existsAdmin();
                });
            }
        }
    }

    public function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}

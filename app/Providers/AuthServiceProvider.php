<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Post;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-post',function(User $user,Post $post){
            return $user->roles->containsStrict('id',1);
        });

        Gate::define('delete-post',function(User $user,Post $post){
            return $user->roles->containsStrict('id',1);
        });

        // all rights to admin user 1
        Gate::before(function(User $user){
            return $user->roles->containsStrict('id',1);
        });
    }
}

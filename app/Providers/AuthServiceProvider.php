<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use App\Extensions\MyEloquentUserProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        // Auth::provider('custom_user', function ($app, array $config) {
        //     $model = $app['config']['auth.providers.usersCurso.model'];
        //     return new MyEloquentUserProvider($app['hash'], $model);
        // });
        //
    }
}

<?php

namespace App\Providers;

use App\Models\UserModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function (Request $request) {
            if ($request->header('token')) {
                return UserModel::where('token', $request->header('token'))->first();
            }

            return null;
        });
    }
}

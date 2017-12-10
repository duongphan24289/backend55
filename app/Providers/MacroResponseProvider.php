<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class MacroResponseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Response success
         */
        Response::macro('success', function ($data, $status = 0) {
            return Response::json([
                'status' => true,
                'data'   => $data,
                'error'  => [
                    'code'    => $status,
                    'message' => [],
                ],
            ]);
        });

        /*
         * Response errors
         */
        Response::macro('error', function ($message, $status = 400, $data = null) {
            return Response::json([
                'status' => false,
                'data'   => $data,
                'error'  => [
                    'code'    => $status,
                    'message' => $message,
                ],
            ]);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}

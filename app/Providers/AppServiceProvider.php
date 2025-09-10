<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        // DB::listen(function ($query) {
        //         // $query->sql; // The raw SQL query
        //         // $query->bindings; // The query's parameter bindings
        //         // $query->time; // The execution time of the query in milliseconds
        //         // $query->connection; // The name of the database connection

        //         // Example: Log the query
        //         Log::info([
        //             'sql' => $query->sql,
        //             'bindings' => $query->bindings,
        //             'time' => $query->time
        //             // 'connection' => $query->connection,
        //         ]);

        //         // Example: Dump the query to the browser (for debugging)
        //         // dump($query->sql, $query->bindings, $query->time);
        //     });
    }
}

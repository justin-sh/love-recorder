<?php

namespace App\Providers;

use App\Models\Child;
use App\Models\Event;
use App\Models\User;
use App\Policies\ChildPolicy;
use App\Policies\EventPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
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

        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(Child::class, ChildPolicy::class);

        Gate::before(function (User $user, string $ability){
            Log::debug('Gate.before:' . $user);
        });

         DB::listen(function ($query) {
        //         // $query->sql; // The raw SQL query
        //         // $query->bindings; // The query's parameter bindings
        //         // $query->time; // The execution time of the query in milliseconds
        //         // $query->connection; // The name of the database connection

        //         // Example: Log the query
                 Log::channel('sql')->info([
                     'sql' => $query->sql,
                     'bindings' => $query->bindings,
                     'time' => $query->time
                     // 'connection' => $query->connection,
                 ]);

        //         // Example: Dump the query to the browser (for debugging)
        //         // dump($query->sql, $query->bindings, $query->time);
             });
    }
}

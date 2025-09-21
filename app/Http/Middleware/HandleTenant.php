<?php

namespace App\Http\Middleware;

use App\Models\TenantHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class HandleTenant
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $request->route('tenant');
        if (!empty($tenant)) {

            if (!Str::startsWith($tenant, config('app.tenant.prefix'))) {
                abort(404);
            }

            // tenant id format: au-${groupId}
            TenantHelper::setId($tenant);
        }

        return $next($request);
    }
}

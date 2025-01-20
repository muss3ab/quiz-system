<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Http\Service\TenantService;
use App\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        
        if ($host === 'localhost') {
            return $next($request);
        }

        // Initialize default tenant connection configuration
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', '123'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]);
        // Ensure we're using the main connection for domain lookup
        DB::setDefaultConnection('mysql');
        
        $domain = Domain::where('domain', $host)->firstOrFail();
        $tenant = Tenant::findOrFail($domain->tenant_id);
        
        TenantService::switchToTenant($tenant);
        // dd(config('database.connections.tenant'));
        // Verify the connection is properly configured
        if (!Config::get('database.connections.tenant.host')) {
            throw new \Exception('Tenant database host not configured properly');
        }
        
        return $next($request);
    }
}

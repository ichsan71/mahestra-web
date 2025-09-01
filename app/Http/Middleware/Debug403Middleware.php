<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Debug403Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log informasi request untuk debugging
        if ($request->is('login*')) {
            Log::info('Login request details', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'headers' => $request->headers->all(),
                'session_id' => $request->session()->getId(),
            ]);
        }

        $response = $next($request);

        // Log jika response adalah 403
        if ($response->getStatusCode() === 403) {
            Log::warning('403 Forbidden response', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'route' => $request->route()?->getName(),
            ]);
        }

        return $response;
    }
}

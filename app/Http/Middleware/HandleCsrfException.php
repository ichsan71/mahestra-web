<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HandleCsrfException
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            // Log the CSRF token mismatch for debugging
            Log::warning('CSRF Token Mismatch', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId(),
                'token_from_request' => $request->input('_token'),
                'token_from_session' => $request->session()->token(),
                'referer' => $request->header('referer'),
            ]);

            // Redirect back to login with a more user-friendly message
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Session expired. Please refresh and try again.'], 419);
            }

            return redirect()->route('login')
                ->withErrors(['token' => 'Your session has expired. Please try again.']);
        }
    }
}

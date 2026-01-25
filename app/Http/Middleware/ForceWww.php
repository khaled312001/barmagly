<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceWww
{
    /**
     * Handle an incoming request.
     * Enforces HTTPS and www prefix for production environments.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for local development
        $host = $request->getHost();
        if ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, '.local') !== false) {
            return $next($request);
        }
        
        $isHttps = $request->secure() || $request->header('X-Forwarded-Proto') === 'https';
        $hasWww = strpos($host, 'www.') === 0;
        $needsRedirect = false;
        $targetUrl = null;
        
        // Check if we need HTTPS redirect
        if (!$isHttps) {
            $needsRedirect = true;
            $targetUrl = 'https://' . ($hasWww ? $host : 'www.' . $host) . $request->getRequestUri();
        }
        // Check if we need www redirect (only if already HTTPS)
        elseif (!$hasWww) {
            $needsRedirect = true;
            $targetUrl = 'https://www.' . $host . $request->getRequestUri();
        }
        
        if ($needsRedirect && $targetUrl) {
            return redirect($targetUrl, 301);
        }
        
        return $next($request);
    }
}

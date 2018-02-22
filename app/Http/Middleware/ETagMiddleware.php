<?php

namespace App\Http\Middleware;

use Closure;

class ETagMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response->isSuccessful()) {
            if ( ! $response->headers->has('ETag')) {
                $response->setEtag(sha1($response->getContent()));
            }

            $response->isNotModified($request);
        }

        return $response;
    }
}

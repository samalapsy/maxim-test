<?php

namespace App\Http\Middleware;

use App\Services\MovieService;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieExist
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $movieService = app()->make(MovieService::class);
        $movie = $movieService->findMovie($request->movie_id);
        if (!$movie) {
            return $this->notFoundResponse('Movie not existing');
        }

        return $next($request);
    }
}

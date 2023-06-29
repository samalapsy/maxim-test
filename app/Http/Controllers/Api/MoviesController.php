<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\MovieService;

class MoviesController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(MovieService $movieService)
    {
        try {
            return $this->successfulResponseWithCollection('API call successful', $movieService->getMoviesWithCommentCounts());
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception->getMessage(), $exception);
        }
    }
}

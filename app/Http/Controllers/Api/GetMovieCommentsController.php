<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Services\MovieService;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;

class GetMovieCommentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(MovieService $movieService, $movie_id)
    {
        try {
            return $this->successfulResponseWithCollection('Api call successful', CommentResource::collection($movieService->getMovieComments($movie_id)));
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception->getMessage(), $exception);
        }
    }
}

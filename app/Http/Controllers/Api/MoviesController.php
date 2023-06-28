<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Isset_;

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

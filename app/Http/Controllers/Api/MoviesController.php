<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MoviesController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $response = Cache::remember('movies', config('maxim.cache_duration'), function () {
                $response = Http::get(config('maxim.base_ap_url') . '/films/');
                if ($response->failed()) {
                    throw new Exception('Could not fetch movie list, please try again.');
                }

                if ($response->noContent()) {
                    throw new Exception('No Content from');
                }

                return $response->object()?->results ?? [];
            });

            $results = collect($response);
            $data = $results->sortBy('release_date')
                ->map(function ($movie) {
                    return [
                        'title' => $movie->title,
                        'opening_crawl' => $movie->opening_crawl,
                        'comments_count' => 0
                    ];
                });

            // Push collection into Redis


            return $this->successfulResponseWithCollection('API call successful', $data);
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception->getMessage(), $exception);
        }
    }

    private function extractMovieIdFromUrl(string $url): int
    {
        $trimmedUrl = rtrim($url, '/');
        $urlPaths = explode('/', $trimmedUrl);
        return end($urlPaths);
    }
}

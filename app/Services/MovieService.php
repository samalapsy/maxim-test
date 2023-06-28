<?php

namespace App\Services;

use Exception;
use App\Models\Comment;;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MovieService
{
    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function getMoviesWithCommentCounts(): Collection
    {
        $movies =  collect($this->fetchMovies());
        $movie_comments = Comment::select('movie_id')->get()->groupBy('movie_id');
        return $movies->sortBy('release_date')
            ->map(function ($movie) use ($movie_comments) {
                $movie_id = $this->extractMovieIdFromUrl($movie->url);
                return [
                    'title' => $movie->title,
                    'opening_crawl' => $movie->opening_crawl,
                    'comments_count' => $movie_comments->count() > 0 && isset($movie_comments[$movie_id]) ? count($movie_comments[$movie_id]) : 0
                ];
            });
    }


    /**
     * Fetch Movies from the API and cache the response.
     *
     * @return array
     */
    private function fetchMovies(): array
    {
        return Cache::remember('movies', config('maxim.cache_duration'), function () {
            $response = Http::get(config('maxim.base_ap_url') . '/films/');
            if ($response->failed()) {
                throw new Exception('Could not fetch movie list, please try again.');
            }

            if ($response->noContent()) {
                throw new Exception('No Content from');
            }

            return $response->object()?->results ?? [];
        });
    }

    /**
     * Accept a movie url and extract the unique movie id form the url
     *
     * @param string $url
     * @return integer
     */
    private function extractMovieIdFromUrl(string $url): int
    {
        $trimmedUrl = rtrim($url, '/');
        $urlPaths = explode('/', $trimmedUrl);
        return end($urlPaths);
    }
}

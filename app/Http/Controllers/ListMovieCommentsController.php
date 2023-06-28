<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Collection;
use App\Http\Resources\CommentResource;

class ListMovieCommentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($movie_id)
    {
        $comments = Comment::whereMovieId($movie_id)->orderBy('id', 'desc')->get();
        return $this->successfulResponseWithCollection('Api call successful', CommentResource::collection($comments));
    }
}

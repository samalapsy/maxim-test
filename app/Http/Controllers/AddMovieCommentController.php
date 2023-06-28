<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;

class AddMovieCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CommentRequest $request, $movie_id)
    {
        $comment = Comment::firstOrCreate($request->all());
        return $this->createdResponseWithResource('Comment added', new CommentResource($comment));
    }
}

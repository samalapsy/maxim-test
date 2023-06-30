<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;

class AddMovieCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CommentRequest $request, $movie_id)
    {
        try {
            $comment = Comment::firstOrCreate([
                'movie_id' => $movie_id,
                'comment' => $request->comment
            ]);
            return $this->createdResponseWithResource('Comment added', new CommentResource($comment));
        } catch (Exception $exception) {
            return $this->serverErrorResponse($exception->getMessage(), $exception);
        }
    }
}

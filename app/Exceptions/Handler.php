<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if (request()->ajax() || request()->wantsJson()) {
            if ($exception instanceof ValidationException) {
                if (request()->ajax() || request()->wantsJson()) {
                    foreach ($exception->errors() as $key => $value) {
                        $error  = $value[0];
                        break;
                    }

                    return response()->json([
                        'errors'      => $error,
                        'message' => 'Invalid data sent',
                    ], 422);
                }
            }
        }

        return parent::render($request, $exception);
    }
}

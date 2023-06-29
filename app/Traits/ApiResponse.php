<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * This trait provide different response function that can be used for any given scenario
 */
trait ApiResponse
{
    /**
     * Set failed response
     *
     * @param $message
     * @param array $data
     * @return JsonResponse
     */
    public function failedResponse(string $message, array $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, 424);
    }

    /**
     * Set success response
     *
     * @param $message
     * @param array $data
     * @return JsonResponse
     */
    public function successfulResponse(string $message, array $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    /**
     * Set success response
     *
     * @param $message
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function successfulResponseWithResource(string $message, $data): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
    
    /**
     * Set created response
     *
     * @param $message
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function createdResponseWithResource(string $message, $data): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, 201);
    }

    /**
     * Set success response
     *
     * @param $message
     * @param $collection
     *
     * @return JsonResponse
     */
    public function successfulResponseWithCollection(string $message, $collection, bool $paginate = false): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($collection)) {
            $response['data'] = $collection;

            if (request('paginate') || $paginate) {
                $response['pagination'] = $this->paginate($collection);
            }
        }

        return response()->json($response);
    }

    /**
     * Set server error response
     *
     * @param $message
     * @param Exception|null $exception
     * @return JsonResponse
     */
    public function serverErrorResponse(string $message, ?Exception $exception = null): JsonResponse
    {
        if ($exception !== null) {
            Log::error(
                "{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}"
            );
        }
        $response = [
            'message' => $message,
        ];

        if (config('app.debug')) {
            $response['debug'] = $this->appendDebugData($exception);
        }

        return response()->json($response, 500);
    }

      /**
     * Set not found response
     *
     * @param $message
     * @param array $data
     * @return JsonResponse
     */
    public function notFoundResponse(string $message, array $data = []): JsonResponse
    {
        $response = [
            'message' => $message,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, 404);
    }

    /**
     * Append debug data to the response data returned.
     */
    protected function appendDebugData($exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => collect($exception->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ];
    }
}

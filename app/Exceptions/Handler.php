<?php

namespace App\Exceptions;

use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use Illuminate\Http\JsonResponse; 
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Throwable;

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
        // Handle 404 for API requests
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            return $this->handleApiError($request, "Object Not Found", 404);
        });

        // Handle ValidationException for API requests
        $this->renderable(function (ValidationException $e, Request $request) {
            return $this->handleApiError($request, $e->getMessage(), 422);
        });

        // Handle generic exceptions (500) for API requests
        $this->renderable(function (Throwable $e, Request $request) {
            return $this->handleApiError($request, 'An error occurred! Please try again later.', 500);
        });

        // Reportable exceptions
        $this->reportable(function (Throwable $e) {
            // Add logic to report exceptions if needed (e.g., to Sentry, Bugsnag)
        });
    }

    /**
     * Helper method to standardize API error responses.
     *  
     * @param Request $request 
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function handleApiError(Request $request, string $message, int $statusCode) : JsonResponse|Response
    {
        if ($request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        }

        return response()->view('errors.' . $statusCode, [], $statusCode);
    }
}

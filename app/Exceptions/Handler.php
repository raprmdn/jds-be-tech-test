<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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
        $this->renderable(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {

                if ($e instanceof CustomException) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], $e->getCode());
                }

                if ($e instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], 403);
                }

                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], 401);
                }

                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], 404);
                }

                $res = [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];

                if (config('app.debug')) {
                    $res['errors'] = [
                        'message' => $e->getMessage(),
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->map(function ($trace) {
                            return \Arr::except($trace, ['args']);
                        })->all(),
                    ];
                }

                $code = $e->getCode() > 599 ? 500 : ($e->getCode() ?: 500);

                return response()->json($res, $code);
            }

            return parent::render($request, $e);
        });

    }
}

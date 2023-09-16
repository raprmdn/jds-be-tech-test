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

                $res = [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];

                if (config('app.debug')) {
                    $res['error'] = [
                        'message' => $e->getMessage(),
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->map(function ($trace) {
                            return \Arr::except($trace, ['args']);
                        })->all(),
                    ];
                }

                return response()->json($res, $e->getCode() ?: 500);
            }

            return parent::render($request, $e);
        });

    }
}

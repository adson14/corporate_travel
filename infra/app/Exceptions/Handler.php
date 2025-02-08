<?php

namespace App\Exceptions;

use App\Domain\Share\Exceptions\EntityValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
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
        $this->renderable(function (NotFoundHttpException $e, $request) {

            if($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Página não encontrada.',
                    'redirect' => '/',
                    'code' => Response::HTTP_NOT_FOUND

                ], Response::HTTP_NOT_FOUND);
            }
        });

    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof EntityValidationException)
            return $this->showError( $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY );


        return parent::render($request, $exception);
    }


    public function showError(string $message, int $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

}

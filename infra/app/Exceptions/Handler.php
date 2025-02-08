<?php

namespace App\Exceptions;

use Domain\Share\Exceptions\EntityValidationException;
use Domain\Share\Exceptions\RepositoryException;
use Domain\Share\Exceptions\UseCaseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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

        if ($exception instanceof NotFoundHttpException)
            return $this->showError( $exception->getMessage(), Response::HTTP_NOT_FOUND );

        if ($exception instanceof RepositoryException)
            return $this->showError( $exception->getMessage(), Response::HTTP_BAD_REQUEST );

        if ($exception instanceof UseCaseException)
            return $this->showError( $exception->getMessage(), Response::HTTP_BAD_REQUEST );

        if($exception instanceof ValidationException)
            return $this->showError( $exception->getMessage(), Response::HTTP_BAD_REQUEST );

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

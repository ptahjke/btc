<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     * @return void
     */
    public function report(
        Exception $exception
    ) {
        $logger = app(LoggerInterface::class);
        $logger->error($exception->getMessage(), [
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    /**
     * @param Request $request
     * @param Exception $e
     * @return Response|JsonResponse
     */
    public function render($request, Exception $e)
    {
        $rendered = parent::render($request, $e);

        switch (true) {
            case $e instanceof MethodNotAllowedHttpException:
                $message = 'Method not allowed';
                break;
            case $e instanceof NotFoundHttpException:
                $message = 'Url not found';
                break;
            case $e instanceof AccessDeniedHttpException
                || $e instanceof UnprocessableEntityHttpException
                || $e instanceof BadRequestHttpException:
                $message = $e->getMessage();
                break;
            default:
                $message = 'Internal server error';
                break;
        }

        return response()->json([
            'status' => 'error',
            'code' => $rendered->getStatusCode(),
            'message' => $message,
        ], $rendered->getStatusCode());
    }
}

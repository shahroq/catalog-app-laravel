<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RemoveNullsFromResponse;
use App\Http\Middleware\WrapResponse;
use App\Services\Envelope\Facades\Envelope;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->api(
            prepend: [
                ForceJsonResponse::class,
            ],
            append: [
                WrapResponse::class,
                // TODO: not working for fails?
                RemoveNullsFromResponse::class,
            ]);

        $middleware->web(
            append: [
                HandleAppearance::class,
                HandleInertiaRequests::class,
                AddLinkHeadersForPreloadedAssets::class,
            ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (app()->hasDebugModeEnabled()) {
            return;
        }

        /*
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $envelope = Envelope::withError($e);

                return response()->json($envelope, $e->getStatusCode());
            }
        });
        */

        // $exceptions->render(function (Exception $e, Request $request) {
        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $envelope = Envelope::withError($e);

                $statusCode = 500;
                if ($e instanceof HttpExceptionInterface) {
                    $statusCode = $e->getStatusCode();
                } elseif ($e instanceof ValidationException) {
                    $statusCode = $e->status; // usually 422
                }

                return response()->json($envelope, $statusCode);
            }
        });

    })->create();

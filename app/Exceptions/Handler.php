<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
            // Custom reporting logic here
        });

        $this->renderable(function (Throwable $e, $request) {
            return $this->handleException($e, $request);
        });
    }

    /**
     * Handle all exceptions
     */
    private function handleException(Throwable $e, $request)
    {
        // Log the exception
        Log::error('Exception: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
        ]);

        // AJAX/API requests
        if ($request->expectsJson()) {
            return $this->handleApiException($e);
        }

        // Admin panel exceptions
        if ($request->is('admin/*')) {
            return $this->handleAdminException($e);
        }

        // User panel exceptions
        if ($request->is('user/*')) {
            return $this->handleUserException($e);
        }

        // General exceptions
        return $this->handleGeneralException($e);
    }

    /**
     * Handle API exceptions
     */
    private function handleApiException(Throwable $e)
    {
        $statusCode = 500;
        $message = 'Internal Server Error';

        if ($e instanceof ModelNotFoundException) {
            $statusCode = 404;
            $message = 'Record not found';
        } elseif ($e instanceof AuthenticationException) {
            $statusCode = 401;
            $message = 'Unauthenticated';
        } elseif ($e instanceof ValidationException) {
            $statusCode = 422;
            $message = 'Validation failed';
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => $e->errors()
            ], $statusCode);
        } elseif ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Endpoint not found';
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $statusCode = 405;
            $message = 'Method not allowed';
        } elseif ($e instanceof QueryException) {
            $statusCode = 500;
            $message = 'Database error occurred';
        } elseif ($e instanceof ThrottleRequestsException) {
            $statusCode = 429;
            $message = 'Too many requests';
        }

        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null
        ], $statusCode);
    }

    /**
     * Handle Admin panel exceptions
     */
private function handleAdminException(Throwable $e)
{
    if ($e instanceof ModelNotFoundException) {
        return response()->view('admin.errors.404', [], 404);
    } elseif ($e instanceof NotFoundHttpException) {
        return response()->view('admin.errors.404', [], 404);
    } elseif ($e instanceof AuthenticationException) {
        return redirect()->route('admin.login')->with('error', 'Please login to access admin panel.');
    } elseif ($e instanceof AuthorizationException) {
        return response()->view('admin.errors.403', [], 403);
    }

    Log::error('Admin Panel Error: ' . $e->getMessage());
    return response()->view('admin.errors.500', [], 500);
}
    /**
     * Handle User panel exceptions
     */
    private function handleUserException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return redirect()->route('user.dashboard')
                ->with('error', 'The requested resource was not found.');
        } elseif ($e instanceof AuthenticationException) {
            return redirect()->route('user.login')
                ->with('error', 'Please login to continue.');
        } elseif ($e instanceof NotFoundHttpException) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Page not found.');
        }

        // For other exceptions in user panel
        Log::error('User Panel Error: ' . $e->getMessage());
        return redirect()->route('user.dashboard')
            ->with('error', 'Something went wrong. Please try again.');
    }

    /**
     * Handle general exceptions
     */
    private function handleGeneralException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404', [], 404);
        } elseif ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        } elseif ($e instanceof AuthenticationException) {
            return redirect()->route('login')
                ->with('error', 'Please login to access this page.');
        }

        // For other general exceptions
        if (config('app.debug')) {
            return parent::render(request(), $e);
        }

        return response()->view('errors.500', [], 500);
    }

    /**
     * Customize unauthenticated response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        if ($request->is('admin/*')) {
            return redirect()->guest(route('admin.login'));
        }

        if ($request->is('user/*')) {
            return redirect()->guest(route('user.login'));
        }

        return redirect()->guest(route('login'));
    }
}

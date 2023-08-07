<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class CustomExceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        if ($e instanceof TokenMismatchException) {
            $message = 'Session expired. Please log in again.';
            return redirect()->route('login')->withErrors(['message' => $message])->header('Refresh', '5');
        }

        return parent::render($request, $e);
    }
}




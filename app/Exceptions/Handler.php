<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $e)
    {
        // Si la pagina obtiene un error 404 se regresa a inicio (para no poder ingresar links directos)
        if ($e instanceof ModelNotFoundException) {
            return redirect('/');
        }

        // Si la pagina obtiene un error 500 se regresa a inicio (para no poder ingresar links con ids manuales)
        if ($e instanceof \ErrorException) {
            return redirect('/');
        } else {
            return parent::render($request, $e);
        }

        return parent::render($request, $e);
        
    }
}

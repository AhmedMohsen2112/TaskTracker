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
     * @return \Illuminate\Http\Response
     */
//    public function render($request, Exception $exception)
//    {
//        return parent::render($request, $exception);
//    }

    public function render($request, Exception $exception) {
//        dd($exception->getStatusCode());
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->back()->withInput()->with('token', csrf_token());
        }
//        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
//    
//            return \Response::view('main_content.front.errors.404',$arr,404);
//        }
        
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            $segment = request()->segment(1);
            
            switch ($segment) {
                case 'apanel':
                    $Controller = new AdminController();
                    break;
                case 'seller-center':
                    $Controller = new SellerController();
                    break;

                default:
                    $Controller = new FrontController();
                    break;
            }
            switch ($statusCode) {

                case 404: return $Controller->err404();
                case 403: return $Controller->err403();
            }
        }

        return parent::render($request, $exception);
    }
}

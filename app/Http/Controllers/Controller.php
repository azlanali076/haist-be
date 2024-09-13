<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success(?string $message = '', $data = [],?int $httpStatus = ResponseAlias::HTTP_OK){
        return response()->json(['success' => true,'message' => $message,'data' => $data],$httpStatus);
    }

    public function error(?string $message = '', $data = [],?int $httpStatus = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,?string $exceptionMessage = ''){
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
            'exception_message' => $exceptionMessage,
        ],$httpStatus);
    }

    public function successMessage(?string $message = ''){
        session()->flash('success',$message);
    }

    public function errorMessage(?string $message = ''){
        session()->flash('error',$message);
    }

}

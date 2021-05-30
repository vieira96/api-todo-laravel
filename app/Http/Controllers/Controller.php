<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseSuccess($data = [], ?string $msg = null, int $code = 200)
    {
        $trace = debug_backtrace();

//        $trace[1] pega a ultima classe que requisitou essa função

        if (! $msg) {
            switch ($trace[1]['function']) {
                case 'store':
                    $msg = 'success.stored';
                    break;
                case 'destroy':
                    $msg = 'success.removed';
                    break;
                case 'update':
                    $msg = 'success.changed';
                    break;
                case 'index':
                case 'list':
                    $msg = 'success.list';
                    break;
                default:
                    $msg = 'success.default';
                    break;
            }
        }

        return response()->json([
            'message' => trans($msg),
            'error' => false,
            'error_type' => 'success',
            'data' => $data,
        ]);
    }

    public function responseError(?string $msg = null, $data = [], int $code = 200)
    {
        if (! $msg) {
            $msg = 'exceptions.default';
        }
        return response()->json([
            'message' => trans($msg),
            'error' => true,
            'error_type' => 'danger',
            'data' => $data,
        ], $code);
    }
}

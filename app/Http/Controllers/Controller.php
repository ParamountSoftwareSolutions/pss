<?php

namespace App\Http\Controllers;

use App\Models\AdminPermission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   
    public function message($message, $alert) {
        return [
            'message' => $message,
            'alert' => $alert,
        ];
    }

    public function response($data, $route, $success_message, $error_message)
    {
        if ($data){
            return redirect()->route($route, ['RolePrefix' => RolePrefix()])->with(['message' => $success_message, 'alert' => 'success']);
        } else {
            return redirect()->back()->with(['message' => $error_message, 'alert' => 'error']);
        }
    }

    function sendError($error_message, $code = 400){
        return Response::json(['status' => $code, 'message' => $error_message], $code)->setStatusCode($code, $error_message);
    }

    function sendSuccess($message, $data = ''){
        return Response::json(['status' => 200, 'message' => $message, 'successData' => $data], 200, []);
    }
}

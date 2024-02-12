<?php

namespace App\Http\Controllers;

use App\Models\Constant;
use Illuminate\Http\JsonResponse;

/**
 * Class BaseController.
 *
 * @package namespace App\Http\Controllers;
 */
class BaseController extends Controller
{
    protected $auth;
    protected $options;

    public function __construct()
    {
        $option_sharing = [];

        $option_sharing['auth'] = true;

        $this->middleware(function ($request, $next){
            $auth = auth()->user();
            $this->auth = $auth;
            view()->share('auth', $auth);
            return $next($request);
        });

        $this->options = Constant::shareView($option_sharing);
    }

    public function getSuccessJson($message = "", $data = null, $code = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'data'  => $data,
            'msg'   => $message,
            'code'  => $code,
        ]);
    }

    public function getErrorJson($message = "", $data = null, $code = JsonResponse::HTTP_NO_CONTENT)
    {
        return response()->json([
            'data'  => $data,
            'msg'   => $message,
            'code'  => $code,
        ]);
    }
}

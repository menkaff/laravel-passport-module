<?php

namespace Modules\Passport\Http\Controllers\API;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TokenController extends Controller
{
    public function Index(Request $request)
    {
        $data = $request->all();
        $data['user'] = Auth::user();
        $result = app()->make('TokenService')->Index($data);

        if ($result['is_successful']) {
            return responseOk($result['data']);
        } else {
            return responseError($result['message']);
        }
    }

    public function Current(Request $request)
    {
        $data = $request->all();
        $data['user'] = Auth::user();
        $result = app()->make('TokenService')->Current($data);

        if ($result['is_successful']) {
            return responseOk($result['data']);
        } else {
            return responseError($result['message']);
        }
    }

    public function Delete(Request $request)
    {
        $data = $request->all();
        $data['user'] = Auth::user();

        $result = app()->make('TokenService')->Delete($data);

        if ($result['is_successful']) {
            return responseOk($result['data']);
        } else {
            return responseError($result['message']);
        }
    }
}

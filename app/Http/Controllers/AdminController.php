<?php

namespace App\Http\Controllers;

use App\Actions\AdminAction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        (new AdminAction())->store_by_request($request);

        return response()->json([
            'message' => 'Register Was Successful'
        ], 200);
    }

    public function login(Request $request)
    {
        return response()->json([
            'message' => 'Login Was Successful',
            'Token' => (new AdminAction())->login_by_request($request)
        ], 200);
    }

    public function check_admin(Request $request)
    {
        return $request->user();
    }
}

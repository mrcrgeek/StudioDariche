<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\WorkAction;
use App\Models\Work;

class WorkController extends Controller
{
    public function add_art(Request $request)
    {
        (new WorkAction())->store_by_request($request);

        return response()->json([
            'message' => 'Art Added Successfully'
        ], 200);
    }
}

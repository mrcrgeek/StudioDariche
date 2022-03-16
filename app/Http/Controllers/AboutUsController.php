<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->model = new AboutUs();
    }

    public function update(Request $request)
    {
        ($this->model->update_by_request($request));

        return response()->json([
           'message' => 'AboutUs Content Updated Successfully'
        ],200);
    }
    public function get()
    {
        return response()->json(
            $this->model->get()
        );
    }
}

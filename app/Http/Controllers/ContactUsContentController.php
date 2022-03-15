<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUsContent;

class ContactUsContentController extends Controller
{
    public function update(Request $request)
    {
        (new ContactUsContent())->update_by_request($request);

        return response()->json([
            'message' => 'Content Of ContactUs Updated Successfully'
        ], 200);
    }

    public function get()
    {
        return response()->json(
            (new ContactUsContent())->get()
        );
    }
}

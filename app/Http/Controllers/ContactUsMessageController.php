<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUsMessage;
use App\Actions\ContactUsMessageAction;

class ContactUsMessageController extends Controller
{
    public function store_message(Request $request)
    {
        (new ContactUsMessageAction())->store_by_request($request);

        return response()->json([
            'message' => 'Message Added Successfully'
        ], 200);
    }

    public function get_messages(Request $request)
    {
        return response()->json(
            (new ContactUsMessageAction())->get_all_by_request($request),
            200
        );
    }
}

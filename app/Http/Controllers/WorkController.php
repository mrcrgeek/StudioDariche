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

    public function update_art(Request $request,string $id)
    {
        (new WorkAction())->update_entity_by_request_and_id($request, $id);

        return response()->json([
            'message' => 'Art Updated Successfully',
        ], 200);
    }

    public function delete_art(string $id)
    {
        (new WorkAction())->delete_by_id($id);

        return response()->json([
            'message' => 'Art Deleted Successfully'
        ], 200);
    }
}

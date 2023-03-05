<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    //

    public function update(Request $request)
    {
        DB::table('monitor_displays')
        ->where('id', '=', $request->id)
        ->update(['active' => $request->toggle]);

        echo json_encode(['response' => 'ok']);
    }
}

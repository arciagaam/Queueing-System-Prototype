<?php

namespace App\Http\Controllers;

use App\Models\Window;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WindowController extends Controller
{
    public function index($id)
    {
        $office = DB::table('offices')
        ->where('offices.id', '=', $id)
        ->first();

        $windows = DB::table('offices')
        ->where('offices.id', '=', $id)
        ->join('windows', 'windows.office_id', '=', 'offices.id')
        ->select('offices.name as office_name', 'windows.*')
        ->get();

        return view('pages.admin.offices.windows.index', ['office' => $office, 'windows' => $windows]);
    }

    public function create($office_id)
    {
        return view('pages.admin.offices.windows.new_window', ['office_id' => $office_id]);
    }

    public function insert(Request $request, $office_id)
    {
        $formFields = $request->validate([
            'number' => ['required', Rule::unique('windows', 'number')],
            'purpose' => '',
        ]); 

        $formFields['office_id'] = $office_id;

        Window::create($formFields);

        return redirect("/offices/$office_id");
    }

    public function edit($office_id, $window_id)
    {
        $window = DB::table('windows')
        ->where('id', '=', $window_id)
        ->first();

        return view('pages.admin.offices.windows.edit_window', ['window' => $window, 'office_id' => $office_id]);
    }

    public function update(Request $request, $office_id, $window_id)
    {
        $formFields = $request->validate([
            'number' => ['required', Rule::unique('windows', 'number')->ignore($window_id)],
            'purpose' => '',
        ]);

        DB::table('windows')
        ->where('id', '=', $window_id)
        ->update($formFields);

        return redirect("/offices/$office_id");
    }

    public function delete($id)
    {
        Window::destroy($id);
    }
}

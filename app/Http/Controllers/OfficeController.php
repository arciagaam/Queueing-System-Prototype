<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = DB::table('offices')->latest()->get();

        foreach($offices as $office){
            $office->window_count = DB::table('windows')->where('office_id', '=', $office->id)->count();
        }

        return view('pages.admin.offices.index', ['offices' => $offices]);
    }

    public function create()
    {
        return view('pages.admin.offices.new_office');
    }

    public function insert(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', Rule::unique('offices', 'name')],
            'prefix' => ['required', Rule::unique('offices', 'prefix')]
        ]);

        Office::create($formFields);

        return redirect('/offices');
    }

    public function edit($id)
    {
        $office = DB::table('offices')
        ->where('id', '=', $id)
        ->first();

        return view('pages.admin.offices.edit_office', ['office' => $office]);
    }

    public function update(Request $request, $office_id)
    {
        $formFields = $request->validate([
            'name' => ['required', Rule::unique('offices', 'name')->ignore($office_id)],
            'prefix' => ['required', Rule::unique('offices', 'prefix')->ignore($office_id)]
        ]);

        DB::table('offices')
        ->where('id', '=', $office_id)
        ->update($formFields);

        return redirect('/offices');
    }

    public function delete($id)
    {
        Office::destroy($id);
    }
}

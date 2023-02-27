<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{
    public function index(Request $request)
    {
        $monitors = DB::table('monitors')
        ->join('offices', 'offices.id', '=', 'monitors.office_id')
        ->select(['monitors.*', 'offices.name as office_name'])
        ->get();

        $request->session()->forget('new_monitor');


        return view('pages.admin.screens.index', ['monitors' => $monitors]);
    }
    
    public function createStepOne()
    {
        return view('pages.admin.screens.new.step_one');
    }

    public function postStepOne(Request $request)
    {
        // if($request->id == 1){
        //     $template = 'office';
        // }else if($request->id == 2) {
        //     $template = 'general';
        // }else {
        //     $template = 'purpose';
        // }

        if (empty($request->session()->get('new_monitor'))) {
            $newMonitor = new Monitor();
            $newMonitor->fill(['template' => $request->id]);
            $request->session()->put('new_monitor', $newMonitor);
        } else {
            $newMonitor = $request->session()->get('new_monitor');
            $newMonitor->fill(['template' => $request->id]);
            $request->session()->put('new_monitor', $newMonitor);
        }

        $request->session()->put('template', $request->id);
    }

    public function createStepTwo(Request $request)
    {
        $template = $request->session()->get('template');
        if($template == 1) {
            $offices = DB::table('offices')
            ->latest()
            ->get();

            $newMonitor = $request->session()->get('new_monitor');

            return view('pages.monitors.form.office', ['offices' => $offices, 'new_monitor' => $newMonitor]);
        }

    }

    public function postStepTwo(Request $request)
    {
        $formFields = $request->validate([
            'office_id' => 'required',
            'name' => 'required'
        ]);

        $newMonitor = $request->session()->get('new_monitor');
        $newMonitor->fill($formFields);
        $request->session()->put('new_monitor', $newMonitor);
        $newMonitor->save();

        return redirect('/screens');
    }

    public function display(Request $request, $monitor_id)
    {
        $monitor = DB::table('monitors')
        ->where('id', '=', $monitor_id)
        ->first();

        if($monitor->template == 1) {

            $calls = DB::table('calls')
            ->join('queues', 'queues.id', '=', 'calls.queue_id')
            ->join('offices', 'offices.id', '=', 'queues.office_id')
            ->where('offices.id', '=', $monitor->office_id)
            ->where('calls.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
            ->orderBy('calls.created_at', 'asc')
            ->get();

            // dd($calls);

            return view('pages.monitors.display.office', ['calls' => $calls]);
        }
    }
}

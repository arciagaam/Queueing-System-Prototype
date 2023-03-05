<?php

namespace App\Http\Controllers;

use App\Models\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function show($id)
    {
        $monitor = DB::table('monitors')->find($id);

        $files = DB::table('monitor_displays')
        ->where('monitor_id', '=', $id)
        ->latest()
        ->get();

        return view('pages.admin.screens.show', ['monitor' => $monitor, 'files' => $files]);
    }
    
    public function create($id)
    {
        return view('pages.admin.screens.files.create', ['monitor_id' => $id]);
    }

    public function insert(Request $request, $id)
    {
        $formData = $request->validate([
            'file' => 'required'
        ]);

        $mimeType = $formData['file']->getMimeType();
        $fileType = explode('/', $mimeType)[0];

        if($fileType == 'image'){
            Storage::makeDirectory(public_path("images/{$id}"));
            $request->file->move(public_path("images/{$id}"), $request->file->getClientOriginalName());
        }else {
            Storage::makeDirectory(public_path("videos/{$id}"));
            $request->file->move(public_path("videos/{$id}"), $request->file->getClientOriginalName());
        }
        


        DB::table('monitor_displays')
        ->insert(['monitor_id' => $id, 'type' => $fileType == 'image' ? 0 : 1, 'file' => $request->file->getClientOriginalName()]);

        return redirect("screens/$id");
    }

    public function updateContent(Request $request)
    {
        DB::table('monitors')
        ->where('id', '=', $request->id)
        ->update(['content_type' => $request->value]);

        echo json_encode(['response' => 'ok']);
    }

    public function getContents($id)
    {
        $contents = DB::table('monitor_displays')
        ->where('monitor_id', '=', $id)
        ->latest()
        ->get();

        echo json_encode($contents);
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

    public function fetchDisplay($office_id)
    {
        $calls = DB::table('calls')
        ->join('queues', 'queues.id', '=', 'calls.queue_id')
        ->Join('offices', 'offices.id', '=', 'queues.office_id')
        ->join('windows', 'windows.queue_id', '=', 'queues.id')
        ->where('offices.id', '=', $office_id)
        ->where('calls.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
        ->orderBy('calls.created_at', 'desc')
        ->select(['queues.*', 'offices.*', 'windows.number as number'])
        ->get();
        
        echo json_encode($calls);
    }

    public function display(Request $request, $monitor_id)
    {
        $monitor = DB::table('monitors')
        ->where('id', '=', $monitor_id)
        ->first();

        if($monitor->template == 1) {

            $calls = DB::table('calls')
            ->join('queues', 'queues.id', '=', 'calls.queue_id')
            ->Join('offices', 'offices.id', '=', 'queues.office_id')
            ->join('windows', 'windows.queue_id', '=', 'queues.id')
            ->where('offices.id', '=', $monitor->office_id)
            ->where('calls.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
            ->orderBy('calls.created_at', 'desc')
            ->select(['queues.*', 'offices.*', 'windows.number as number', 'windows.name as window_name', 'windows.use_name'])
            ->get();

            $contents = DB::table('monitor_displays')
            ->where('monitor_id', '=', $monitor->id)
            ->where('active', '=', 1)
            ->latest()
            ->get();

            $office = DB::table('offices')->find($monitor->office_id);

            return view('pages.monitors.display.office', ['calls' => $calls, 'office' => $office, 'monitor' => $monitor, 'contents' => $contents]);
        }
    }
}

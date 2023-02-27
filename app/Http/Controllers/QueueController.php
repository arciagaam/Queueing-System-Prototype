<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Office;
use App\Models\Queue;
use App\Models\Window;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{

    protected $office;
    protected $window;

    public function __construct(Request $request)
    {
        $this->office = Office::where('id', $request->office)->first();
        $this->window = Window::where('id', $request->window)->first();
    }

    
    public function checkQueue($queue)
    {
        if($queue){
            
            $number = $queue->number + 1;

            if($number >= 0 && $number <= 9){
                return '000'.$number;
            }else if($number >= 10 && $number <= 99) {
                return '00'.$number;
            }else if($number >= 100 && $number <= 999) {
                return '0'.$number;
            }
        }
        return '0001';
    }

    public function api($officeId, $windowId)
    {
        $purpose = DB::table('windows')
        ->where('id', '=', $windowId)
        ->select('purpose')
        ->first();

        $queues = DB::table('queues')
        ->where('office_id', '=', $officeId)
        ->where('queues.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
        ->where('queues.purpose' , '=', $purpose->purpose)
        ->join('offices', 'offices.id', '=', 'queues.office_id')
        ->select(['queues.*', 'offices.name as office'])
        ->orderBy('number', 'desc')
        ->get();
        
        echo json_encode($queues); 
    }

    public function getOfficeWindow($officeId, $windowId)
    {   
        $office = Office::where('id', $officeId)->first();
        $window = Window::where('id', $windowId)->first();
        echo json_encode(['office' => $office, 'window' => $window]);
    }

    public function windows($id)
    {
        echo json_encode(DB::table('windows')->where('office_id', '=', $id)->latest()->get());
    }

    public function index()
    {
        
        $queues = DB::table('queues')
        ->where('office_id', '=', $this->office->id)
        ->where('queues.purpose' , '=', $this->window->purpose)
        ->where('queues.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
        ->join('offices', 'offices.id', '=', 'queues.office_id')
        ->select(['queues.*', 'offices.name as office'])
        ->orderBy('number', 'desc')
        ->get();

        $current = DB::table('windows')
        ->where('windows.id', '=', $this->window->id)
        ->join('queues', 'queues.id', '=', 'windows.queue_id')
        ->first();

        $offices = DB::table('offices')
        ->latest()
        ->get();

        if(!isset($current->queue_id)){
            $current = null;
        }


        return view('pages.admin.offices.windows.queue.index', ['office' => $this->office, 'window' => $this->window, 'queues' => $queues, 'current' => $current, 'offices' => $offices]);
    }

    public function test(Request $request)
    {
        $action = $request->action;

        if($action == 'start') {
            $windowId = $request->windowId;

            DB::table('windows')->where('id', '=', $windowId)->update(['status' => 1]);

            $data=[
                'status' => 'success'
            ];

            echo json_encode($data);

        }

        if($action == 'stop') {
            $windowId = $request->windowId;

            DB::table('windows')->where('id', '=', $windowId)->update(['status' => 0, 'queue_id' => null]);

            $data=[
                'status' => 'success'
            ];
            echo json_encode($data);

        }

        if($action == 'next') {
            $windowId = $request->windowId;
            $officeId = $request->officeId;

            $purpose = DB::table('windows')
            ->where('id', '=', $windowId)
            ->select('purpose')
            ->first();

            $current = DB::table('queues')
            ->where('office_id', '=', $officeId)
            ->where('queues.purpose' , '=', $purpose->purpose)
            ->where('queues.created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
            ->where('status', '=', '0')
            ->join('offices', 'offices.id', '=', 'queues.office_id')
            ->select(['queues.*', 'offices.name as office'])
            ->orderBy('queues.created_at', 'asc')
            ->first();

            if($request->payload['next'] != 0){
                $selectedOfficeId = $request->payload['selectedOffice'];
                $selectedWindowId = $request->payload['selectedWindow'];

                if($selectedOfficeId != 'null' || $selectedWindowId != 'null'){
                    $window = DB::table('windows')
                    ->where('windows.id', '=', $windowId)
                    ->join('queues', 'queues.id', '=', 'windows.queue_id')
                    ->select('queues.code as queue_code')
                    ->first();
                    
                    $queue = DB::table('queues')
                    ->where('office_id', '=', $selectedOfficeId)
                    ->where('created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
                    ->orderBy('number', 'desc')
                    ->first();

                    $purpose = DB::table('windows')
                    ->where('id', '=', $selectedWindowId)
                    ->select('purpose')
                    ->first();


                    $queueNumber = (int) $this->checkQueue($queue);
                    
                    Queue::create(['office_id' => $selectedOfficeId, 'number' => $queueNumber, 'code' => $window->queue_code, 'purpose' => $purpose->purpose]);       
                }
            }
            
            if(isset($current)) {


                DB::table('windows')
                ->where('id', '=', $windowId)
                ->update(['queue_id' => $current->id]);
    
                DB::table('queues')
                ->where('id', '=', $current->id)
                ->update(['status' => 1]);
    
                Call::create(['queue_id' => $current->id, 'window_id' => $windowId]);
                
                $data=[
                    'status' => 'success',
                    'data' => $current
                ];
            } else {
                
                DB::table('windows')
                ->where('id', '=', $windowId)
                ->update(['queue_id' => null]);

                $data = [
                    'status' => 'No queue left',
                ];
            }

            echo json_encode($data);
        }
    }
}

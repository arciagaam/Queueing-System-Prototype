<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('new_queue');
        return view('pages.user.home');
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

    public function createStepOne()
    {
        $offices = DB::table('offices')
        ->latest()
        ->get();

        return view('pages.user.step_one', ['offices' => $offices]);
    }

    public function postStepOne(Request $request)
    {   
        $formFields = $request->validate([
            'office_id' => 'required'
        ]);
        
        $office = DB::table('offices')
        ->where('id', '=', $formFields['office_id'])
        ->first();

        $queue = DB::table('queues')
        ->where('office_id', '=', $formFields['office_id'])
        ->where('created_at', 'like', '%'.now()->toDateString('Y-m-d').'%')
        ->orderBy('number', 'desc')
        ->first();

        $queueNumber = $this->checkQueue($queue);

        $formFields['number'] = (int)$queueNumber; 
        $formFields['code'] = $office->prefix . '_' . $queueNumber;
        
        if (empty($request->session()->get('new_queue'))) {
            $newQueue = new Queue();
            $newQueue->fill($formFields);
            $request->session()->put('new_queue', $newQueue);
        } else {
            $newQueue = $request->session()->get('new_queue');
            $newQueue->fill($formFields);
            $request->session()->put('new_queue', $newQueue);
        }


        return redirect('/queueing/step-two');
    }

    public function createStepTwo(Request $request)
    {
        $newQueue = $request->session()->get('new_queue');

        $purposes = DB::table('windows')
        ->where('office_id', '=', $newQueue->office_id)
        ->select('purpose')
        ->get();

        return view('pages.user.step_two', ['new_queue' => $newQueue, 'purposes' => $purposes]);
    }

    public function postStepTwo(Request $request)
    {
        $formFields = $request->validate([
            'purpose' => 'required'
        ]);

        $newQueue = $request->session()->get('new_queue');
        $newQueue->fill($formFields);
        $request->session()->put('new_queue', $newQueue);
        $newQueue->save();
        
        return redirect('/queueing/step-three');
    }

    public function createStepThree(Request $request)
    {
        $request->session()->forget('new_queue');
        return view('pages.user.step_three');
        
    }


}

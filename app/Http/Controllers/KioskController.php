<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function index()
    {
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
        
        $request->session()->put('queue_details', $formFields);

        Queue::create($formFields);

        return redirect('/queueing/step-two');
    }

    public function createStepTwo(Request $request)
    {
        return view('pages.user.step_two');

    }

    public function postStepTwo(Request $request)
    {

    }


}

<?php

namespace App\Models;

use App\Events\NewCall;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'queue_id',
        'window_id',
    ];

    public static function booted()
    {
        static::created(function ($queue) {
            NewCall::dispatch($queue);
        });

        // static::updated(function ($queue) {
        //     UpdateQueue::dispatch($queue);
        // });
    }
}

<?php

namespace App\Models;

use App\Events\NewQueue;
use App\Events\UpdateQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $table = 'queues';

    protected $fillable = [
        'office_id',
        'number',
        'code',
        'purpose'
    ];

    public static function booted()
    {
        static::created(function ($queue) {
            NewQueue::dispatch($queue);
        });

        static::updated(function ($queue) {
            UpdateQueue::dispatch($queue);
        });
    }
}

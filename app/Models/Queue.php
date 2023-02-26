<?php

namespace App\Models;

use App\Events\NewQueue;
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
    ];

    public static function booted()
    {
        static::created(function ($queue) {
            NewQueue::dispatch($queue);
        });

        static::updated(function ($queue) {
            NewQueue::dispatch($queue);
        });
    }
}

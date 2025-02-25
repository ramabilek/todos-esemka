<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'task';
    protected $fillable = [
        'name',
        'list_id',
        'status',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($task) {
            $task->created_at = now();
            $task->updated_at = now();
        });
    }
}

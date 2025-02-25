<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;
    protected $table = 'list';
    protected $fillable = ['name'];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($task) {
            $task->created_at = now();
            $task->updated_at = now();
        });
    }
}

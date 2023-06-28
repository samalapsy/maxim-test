<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'movie_id',
        'comment',
        'ip_address',
    ];

    public static function boot()
    {
        parent::boot();

        /**
         * Listen for the creating event on this model to set the ip address
         */
        static::creating(function ($comment) {
            $comment->ip_address = request()->ip();
        });
    }
}

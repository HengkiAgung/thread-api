<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'comments_id',
        'thread_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment', "comments_id");
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}

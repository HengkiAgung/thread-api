<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', "threads_id");
    }

    public function mentions()
    {
        return $this->hasMany('App\Models\Mention');
    }

    public function mentionComment()
    {
        return $this->hasManyThrough('App\Models\Comment', 'App\Models\Mention', "thread_id", "id", "id", "comments_id");
    }
}

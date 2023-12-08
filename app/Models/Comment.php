<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'threads_id',
        'users_id',
        'comments_id',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'comments_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'comments_id', 'id');
    }

    public function thread()
    {
        return $this->belongsTo('App\Models\Thread', "threads_id");
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function mentions()
    {
        return $this->hasMany('App\Models\Mention', "comments_id");
    }
}

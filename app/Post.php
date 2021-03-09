<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'content', 'title'
    ];

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'topic_id', 'user_id', 'created_at', 'updated_at', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function topics()
    {
        return $this->belongsTo('App\Topic');
    }
}

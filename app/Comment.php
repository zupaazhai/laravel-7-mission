<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = ['topic_id', 'user_id', 'comment'];

    public function topic()
    {
        return $this->belongsTo('App\Topic', 'topic_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

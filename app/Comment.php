<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $fillable = [
        'topic_id', 'comment', 'user_id'
    ];

    /**
     * Relation with table user
     *
     * @return App\Comment
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected  $fillable = ['comment','user_id','topic_id'];

    /**
     * Relation with table user
     *
     * @return App\Topic
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
   
}

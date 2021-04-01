<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $fillable = ['user_id', 'title', 'content'];

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

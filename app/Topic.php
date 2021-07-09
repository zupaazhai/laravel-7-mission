<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $fillable = ['title','content','user_id'];

    /**
     * Relation with table user
     *
     * @return App\Topic
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment' , 'topic_id', 'id');
    }

    public function getTotalCommentsAttribute()
    {
        $count=$this->hasMany('App\Comment' , 'topic_id', 'id')->where('topic_id',$this->id)->count();
        return $count;
        
    }
}

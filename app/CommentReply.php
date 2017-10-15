<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    //
    protected $fillable = [
        'comment_id',
        'author',
        'email',
        'is_active',
        'body',
        'photo'
    ];

    public function comment(){
        return $this->belongsTo('App\Comment');
    }
}

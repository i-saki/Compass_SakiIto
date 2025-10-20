<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    public function post(){
        return $this->belongsTo('App\Models\Posts\post','id');
    }//多対一の「一」 主キー：'id'


}

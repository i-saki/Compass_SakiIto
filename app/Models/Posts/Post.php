<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Like;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }//多対一の「一」

    public function likes(){
        return $this->hasMany('App\Models\Posts\like','like_post_id');
    }//多対一の「他」 主キー：'like_post_id'

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment','post_id');
    }//他対一の「他」 主キー：'post_id'

    public function subCategories(){
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
        // リレーションの定義
    }

    //いいね数
    public function likeCounts($post_id){
        return $this->likes()->get()->count();
    }//23のlikes()メソッド

    // コメント数
    public function commentCounts($post_id){
        return $this->postComments()->get()->count();
    }//27のpostComments()メソッド
}

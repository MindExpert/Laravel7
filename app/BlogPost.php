<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    //protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public static function boot() 
    {
        parent::boot();

        //deletes all the related comments when deleting a blogPost
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete(); 
        });

        //restore all the related comments when restoring a blogPost
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore(); 
        });
    }

}
<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    //protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public static function boot() 
    {
        parent::boot();

        static::addGlobalScope(new LatestScope);

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
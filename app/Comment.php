<?php

namespace App;

use App\BlogPost;
use App\Scopes\LatestScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use softDeletes;
    
    protected $fillable = ['user_id', 'content'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }


    public static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new LatestScope);

        // reset blogpost Cache when a new comment is added
        static::creating(function (Comment $comment) {
            // since comment can be added to the user, we need to check for the type
            if($comment->commentable_type === BlogPost::class){
                Cache::forget("blog-post-{$comment->commentable_id}");
                Cache::forget('blog-post-most-commented');
            }
        });

    }
}

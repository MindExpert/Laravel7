<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use softDeletes;
    
    protected $fillable = ['user_id', 'content'];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
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

        static::creating(function (Comment $comment) {
            Cache::forget("blog-post-{$comment->blog_post_id}");
            Cache::forget('blog-post-most-commented');
        });

    }
}

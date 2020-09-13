<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    //protected $fillable = ['title', 'content'];

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps()->as('tagged');
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }


    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count 
        return $query->withCount('comments')->orderBY('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        //comments_count 
        return $query->latest()
            ->withCount('comments')
            ->with('user')
            ->with('tags');
        }


    public static function boot() 
    {
        static::addGlobalScope(new DeletedAdminScope);
        
        parent::boot();

        //deletes all the related comments when deleting a blogPost
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            Cache::forget("blog-post-{$blogPost->id}");
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
        });

        //restore all the related comments when restoring a blogPost
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore(); 
        });
        
    }

}
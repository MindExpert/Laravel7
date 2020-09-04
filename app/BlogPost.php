<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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


    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count 
        return $query->withCount('comments')->orderBY('comments_count', 'desc');
    }

    public static function boot() 
    {
        static::addGlobalScope(new DeletedAdminScope);
        
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
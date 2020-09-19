<?php

namespace App;

use App\Traits\Taggable;
use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    use Taggable;
    
    // protected $guarded = ['thumbnail'];
    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
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
        //we use the boot menu when we want to register some events
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();
    }

}
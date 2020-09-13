<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $fillable = ['path', 'blog_post_id'];

    public function blogPost()
    {
       return $this->belongsTo(BlogPost::class);
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}

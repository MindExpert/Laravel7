<?php

namespace App\Observers;

use App\BlogPost;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{

    /**
     * Handle the blog post "updated" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
        // clear cache when we update the post
        Cache::forget("blog-post-{$blogPost->id}");
    }

    /**
     * Handle the blog post "deleting" event.
     * 
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function deleting(BlogPost $blogPost)
    {
        // dd("I'am deleted");
        // deletes all the related comments when deleting a blogPost
        $blogPost->comments()->delete();
        Cache::forget("blog-post-{$blogPost->id}");
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function restoring(BlogPost $blogPost)
    {
        //restore all the related comments when restoring a blogPost
        $blogPost->comments()->restore(); 
    }
}

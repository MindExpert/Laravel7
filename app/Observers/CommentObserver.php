<?php

namespace App\Observers;

use App\Comment;
use App\BlogPost;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        // reset blogpost Cache when a new comment is added
        // since comment can be added to the user, we need to check for the type
        if($comment->commentable_type === BlogPost::class){
            // dd("I'am created");
            Cache::forget("blog-post-{$comment->commentable_id}");
            Cache::forget('blog-post-most-commented');
        }
    }

    
}

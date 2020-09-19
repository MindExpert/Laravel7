<?php

namespace App\Mail;

// use App\BlogPost;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentPostedMarkdown extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Comment was posted! on your {$this->comment->commentable->title}";
        return $this->subject($subject)->markdown('emails.posts.commented-markdown');
    }
}

<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentPostedMarkdown extends Mailable
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
        return $this
        ->attachData(Storage::get($this->comment->user->image->path), 'profile_picture_from_data.jpg',[
            'mime' => 'image/jpeg',
        ])
        ->subject($subject)
        ->markdown('emails.posts.commented-markdown');
    }
}

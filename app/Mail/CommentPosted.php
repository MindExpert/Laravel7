<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Storage;

class CommentPosted extends Mailable
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
            // First Method
            // ->attach(
            //     storage_path('app/public') . '/' . $this->comment->user->image->path,
            //     [
            //         'as' => 'profile_picture.jpg',
            //         'mime' => 'image/jpeg',
            //     ]
            // )
            // Second Method
            // ->attachFromStorage($this->comment->user->image->path, 'profile_picture.jpg')
            // Third Method
            ->attachData(Storage::get($this->comment->user->image->path), 'profile_picture_from_data.jpg',[
                'mime' => 'image/jpeg',
            ])
            // ->from('laravel@udemy.com', 'Elvis')
            ->subject($subject)
            ->view('emails.posts.commented');
    }
}

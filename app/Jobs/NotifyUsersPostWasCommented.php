<?php

namespace App\Jobs;

use App\User;
use App\Comment;
use App\Mail\CommentPostedOnPostWatched;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class NotifyUsersPostWasCommented implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all the users that have commented on a BlogPost
        User::thatHasCommentedOnPost($this->comment->commentable)
            ->get()
            ->filter(function(User $user){
                // remove the user that has posted the comment
                return $user->id !== $this->comment->user->id;
            })->map(function (User $user){
                Mail::to($user)->send(
                    new CommentPostedOnPostWatched($this->comment, $user)
                );
            });
    }
}

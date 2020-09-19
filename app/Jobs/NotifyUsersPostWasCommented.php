<?php

namespace App\Jobs;

use Mail;
use App\User;
use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Mail\CommentPostedOnPostWatched;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        // $now = now();
        
        // Get all the users that have commented on a BlogPost
        User::thatHasCommentedOnPost($this->comment->commentable)
            ->get()
            ->filter(function(User $user){
                // remove the user that has posted the comment
                return $user->id !== $this->comment->user->id;
            })->map(function (User $user){
                // ThrottledMail::dispatch( 
                //     new CommentPostedOnPostWatched($this->comment, $user), 
                //     $user
                // );
                Mail::to($user)->send(
                    new CommentPostedOnPostWatched($this->comment, $user)
                );
                // Mail::to($user)->later(
                //     $now()->addSeconds(10),
                //     new CommentPostedOnPostWatched($this->comment, $user)
                // );
            });
    }
}

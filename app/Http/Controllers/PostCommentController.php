<?php

namespace App\Http\Controllers;

use Mail;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPostedMarkdown;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Events\CommentPosted as EventsCommentPosted;
// use App\Jobs\ThrottledMail;
// use App\Mail\CommentPosted;
// use App\Mail\CommentPostedOnPostWatched;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index(BlogPost $post)
    {
        return $post->comments;
    }


    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);
        
        event(new EventsCommentPosted($comment));

        return redirect()->back()
            ->withStatus('Comment was added succesfully!');

        // Mail::to($post->user)->send(
        //     // new CommentPosted($comment)
        //     new CommentPostedMarkdown($comment)
        // );
        /* ThrottledMail::dispatch(
            new CommentPostedMarkdown($comment), 
            $post->user
            )->onQueue('low');
        */


        // $when = now()->addMinutes(1);
        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        
    }
}

<?php

namespace App\Http\Controllers;

use Mail;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Events\CommentPosted as EventsCommentPosted;
use App\Http\Resources\Comment as CommentResource;
// use App\Jobs\ThrottledMail;
// use App\Mail\CommentPosted;
// use App\Mail\CommentPostedMarkdown;
// use App\Mail\CommentPostedOnPostWatched;
// use App\Jobs\NotifyUsersPostWasCommented;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index(BlogPost $post)
    {
        // dump(is_array($post->comments));
        // dump(get_class($post->comments));
        // die;
        // return new CommentResource($post->comments->first());
        return CommentResource::collection($post->comments()->with('user')->get()); 
        // return $post->comments()->with('user')->get();
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

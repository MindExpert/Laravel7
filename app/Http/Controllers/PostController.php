<?php

namespace App\Http\Controllers;

use App\User;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Cache;

// use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function __construct()
    {   
        // $this->middleware('auth');
        // $this->middleware('auth')->except(['index']);
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();
        // $posts = BlogPost::with('comments')->get();
        // foreach($posts as $post){
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }
        // dd(DB::getQueryLog());
        
        return view(
            'posts.index', 
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get()
            ]
        );
        
    }


    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }


    public function store(StorePost $request)
    {

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id; 

        $blogPost = BlogPost::create($validatedData);

        $request->session()->flash('status' , 'Blog post was created succesfully!');
        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }


    public function show($id)
    {
        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments'=>function($query){
        //         return $query->latest();
        //     }])->findOrFail($id)
        // ]);

        /* REDIS tags*/
        // $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use($id){
        //     return BlogPost::with('comments')->findOrFail($id);
        // });

        $blogPost = Cache::remember("blog-post-{$id}", 60, function() use($id){
            return BlogPost::with('comments')->with('user')->with('tags')->findOrFail($id);
        });

        // Counter user per posts
        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        // $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            }else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >=1 ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        // Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);
        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::has($counterKey)) {
            // Cache::tags(['blog-post'])->forever($counterKey, 1);
            Cache::forever($counterKey, 1);
        } else {
            // Cache::tags(['blog-post'])->increment($counterKey, $difference);
            Cache::increment($counterKey, $difference);
        }

        // $counter = Cache::tags(['blog-post'])->get($counterKey);
        $counter = Cache::get($counterKey);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter,
        ]);

    }


    public function edit($id)
    {
        $post = BlogPost::findOrFail($id); 

        // if (Gate::denies('update-post', $post)) {
        //    abort(403, "You cant edit this post!"); 
        // }
        $this->authorize('update', $post);

        return view('posts.edit', ['post'=> $post]);
    }


    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id); 

        // if (Gate::denies('update-post', $post)) {
        //    abort(403, "You cant update this post!"); 
        // }
        $this->authorize('update', $post);

        $validatedData = $request->validated();
        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status' , 'Blog post was Updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }


    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id); 

        // if (Gate::denies('delete-post', $post)) {
        //    abort(403, "You cant delete this post!"); 
        // }
        $this->authorize('delete', $post);

        $post->delete();

        //or
        // BlogPost::destroy($id);

        $request->session()->flash('status' , 'Blog post was deleted!');
        return redirect()->route('posts.index');       
    }
}

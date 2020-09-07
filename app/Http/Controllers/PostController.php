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

        // add to cache
        $mostCommented = Cache::remember('blog-post-most-commented', now()->addSeconds(10), function(){
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('users-most-active', 60, function(){
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('users-most-active-last-month', 60, function(){
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });
        
        
        return view(
            'posts.index', 
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented' => $mostCommented,
                'mostActive' => $mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth,
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
        $blogPost = Cache::remember("blog-post-{$id}", 60, function() use($id){
            return BlogPost::with('comments')->findOrFail($id);
        });
        return view('posts.show', [
            'post' => $blogPost,
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

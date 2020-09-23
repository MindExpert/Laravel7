<?php

namespace App\Http\Controllers;

use App\Image;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use App\Events\BlogPostPostedEvent;
use App\Services\Counter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

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
        // $this->middleware('locale');
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
                // 'posts'=>BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get()
                'posts'=>BlogPost::latestWithRelations()->get()
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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            $blogPost->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPostedEvent($blogPost));
        
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
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

        $counter = resolve(Counter::class);
        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $counter->increment("blog-post-{$id}"),
        ]);

    }


    public function edit($id)
    {
        // if (Gate::denies('update-post', $post)) {
        //    abort(403, "You cant edit this post!"); 
        // }

        $post = BlogPost::findOrFail($id); 
        $this->authorize('update', $post);
        return view('posts.edit', ['post'=> $post]);
    }


    public function update(StorePost $request, $id)
    {
        // if (Gate::denies('update-post', $post)) {
        //    abort(403, "You cant update this post!"); 
        // }

        $post = BlogPost::findOrFail($id); 
        $this->authorize('update', $post);
        $validatedData = $request->validated();
        $post->fill($validatedData);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');
            
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }
        $post->save();

        $request->session()->flash('status' , 'Blog post was Updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }


    public function destroy(Request $request, $id)
    {
        // if (Gate::denies('delete-post', $post)) {
        //    abort(403, "You cant delete this post!"); 
        // }
        
        $post = BlogPost::findOrFail($id); 
        $this->authorize('delete', $post);
        $post->delete(); // or BlogPost::destroy($id);    

        $request->session()->flash('status' , 'Blog post was deleted!');
        return redirect()->route('posts.index');       
    }
}

<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
// use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
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
            ['posts'=>BlogPost::withCount('comments')->get()]
        );
        
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store(StorePost $request)
    {

        $validatedData = $request->validated();
        $blogPost = BlogPost::create($validatedData);

        $request->session()->flash('status' , 'Blog post was created succesfully!');
        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }


    public function show($id)
    {
        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id)
        ]);
    }


    public function edit($id)
    {
        
        $post = BlogPost::findOrFail($id); 
        return view('posts.edit', ['post'=> $post]);
    }


    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id); 
        $validatedData = $request->validated();
        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status' , 'Blog post was Updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }


    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id); 
        $post->delete();

        //or
        // BlogPost::destroy($id);

        $request->session()->flash('status' , 'Blog post was deleted!');
        return redirect()->route('posts.index');       
    }
}

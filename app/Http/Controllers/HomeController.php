<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function home()
    {
        // dd(Auth::id()); 
        // dd(Auth::user()); 
        // dd(Auth::check()); 
        return view('home');
    }

    public function contact()
    {
        return view('contact');
    }

    public function blog($postId, $greating = 1)
    {
        // Associative array
        $pages = [
            1 => [
                'title' => ' from Page 1'
            ],
            2 => [
                'title' => ' from Page 2'
            ],
        ];
    
        // array
        $welcome = [ 1=> 'Hello, ' , 2 => 'Welcome, '];
    
        return view('blog-post', [
            'data'=> $pages[$postId], 
            'greatings' => $welcome[$greating]
        ]);
    }
}
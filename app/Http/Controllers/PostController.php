<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('post.index');
    }

    public function create()
    {
        //redirijo a la vista para agregar un post
        return view('post.create');
    }
}

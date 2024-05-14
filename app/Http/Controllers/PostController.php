<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // 确保你创建了 Post 模型

class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::find($id);
        return view('post_details', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('post_edit', compact('post'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:80'],
            'blog_text' => ['required', 'string', 'max:5000'],
        ]);

        Post::create($validated);

        return redirect('/')->with('success', 'Your post was published!');
    }
}
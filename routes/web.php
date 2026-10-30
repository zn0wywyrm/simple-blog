<?php

use Illuminate\Support\Facades\Route;

use App\Models\Post;

Route::get('/', function () {
    $posts = Post::latest()->get();

    return view('home', ['posts' => $posts]);
});

Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
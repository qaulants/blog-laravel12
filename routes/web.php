<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});

// // route tanpa admin
// Route::get('/', [PostController::class, 'index'])->name('posts.index');
// Route::get('/posts/{post}',[ PostController::class, 'show'])->name('posts.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route CRUD hanya untuk admin
// Route::middleware(['auth', 'is_admin'])->group(function () {
//     Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//     Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//     Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
//     Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
//     Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
// });


// Semua user bisa lihat daftar post
Route::get('/', function () {
    $posts = \App\Models\Post::latest()->paginate(5);
    return view('posts.index', compact('posts'));
})->name('posts.index');

// Routes yang butuh login
Route::middleware('auth')->group(function () {

    // Admin only: Create
    Route::get('/posts/create', function () {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('posts.create');
    })->name('posts.create');

    Route::post('/posts', function (\Illuminate\Http\Request $request) {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        \App\Models\Post::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created');
    })->name('posts.store');

    // Admin only: Edit
    Route::get('/posts/{post}/edit', function (\App\Models\Post $post) {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('posts.edit', compact('post'));
    })->name('posts.edit');

    Route::put('/posts/{post}', function (\Illuminate\Http\Request $request, \App\Models\Post $post) {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated');
    })->name('posts.update');

    // Admin only: Delete
    Route::delete('/posts/{post}', function (\App\Models\Post $post) {
        if (Auth::user()->role !== 'admin') abort(403);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted');
    })->name('posts.destroy');
});

// Route dinamis untuk show post **paling bawah**
Route::get('/posts/{post}', function (\App\Models\Post $post) {
    return view('posts.show', compact('post'));
})->name('posts.show');

require __DIR__.'/auth.php';

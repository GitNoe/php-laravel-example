<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;

// use Spatie\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

    // $document = YamlFrontMatter::parseFile(resource_path('posts/my-fourth-post.html'));

    // $files = File::files(resource_path("posts")); -> pasa a collect xq solo se usa una vez

    // funciones flechas convertidas de las que se fueron creando paso a paso -> Post.php
    // $posts = collect(File::files(resource_path("posts")))
    //     ->map(fn($file) => YamlFrontMatter::parseFile($file))
    //     ->map(fn($document) => new Post(
    //         $document->title,
    //         $document->excerpt,
    //         $document->date,
    //         $document-> body(),
    //         $document->slug,
    //     ));

    // MISMA FUNCIÓN SIN COLECCIÓN ANTES DE MAPEAR
    // $posts = array_map(function($file) {
    //     $document = YamlFrontMatter::parseFile($file);

    //     return new Post(
    //         $document->title,
    //         $document->excerpt,
    //         $document->date,
    //         $document-> body(),
    //         $document->slug,
    //     );
    // }, $files);

    // dump, die, debug (ver resultados)
    // ddd($posts);

    // $posts = Post::all();

//     return view('posts', [
//         'posts' => Post::all()
//     ]);
// });

// RUTA FINAL CON SOLUCIÓN AL PROBLEMA N+1
Route::get('/', function () {
    return view('posts', [
        // latest = más reciente primero
        // 'posts' => Post::latest()->with(['category', 'author'])->get()
        'posts' => Post::latest()->get()
    ]);
});

// Route::get('posts/{post}', function ($id) {

//     // el objetivo es encontrar el post mediante un slug y pasarlo a una vista "post"

//     // $post = Post::find($slug);
//     // return view('post', ['post' => $post]);

//     return view('post', [
//         'post' => Post::findOrFail($id)
//     ]);

// });
// // ->where('post', '[A-z_\-]+');

// ROUTE MODEL BINDING (primero id, cambiado a slug)
Route::get('posts/{post:slug}', function (Post $post){
    return view('post', [
        'post' => $post
    ]);
});

// ELOQUENT RELATIONSHIP AGAIN
Route::get('categories/{category:slug}', function (Category $category){
    return view('posts', [
        // 'posts' => $category->posts->load(['category', 'author']) //load por el modelo existente
        'posts' => $category->posts
    ]);
});

// POSTS DE UN AUTOR
Route::get('authors/{author:username}', function (User $author){
    // dd($author);
    return view('posts', [
        // 'posts' => $author->posts->load(['category', 'author']) //load por el modelo existente
        'posts' => $author->posts
    ]);
});

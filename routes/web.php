<?php

use App\Models\Post;
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

Route::get('/', function () {

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
    return view('posts', [
        'posts' => Post::all()
    ]);
});


Route::get('posts/{post}', function ($slug) {

    // el objetivo es encontrar el post mediante un slug y pasarlo a una vista "post"

    // $post = Post::find($slug);
    // return view('post', ['post' => $post]);

    return view('post', [
        'post' => Post::findOrFail($slug)
    ]);

});
// ->where('post', '[A-z_\-]+');

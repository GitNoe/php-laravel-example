<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }
    // esto construye los posts con los meta-datos

    public static function all()
    {
        // función flecha para que saque los archivos
        // $files = File::files(resource_path("posts/"));

        // return array_map(fn($file) => $file->getContents(), $files);

        // $posts = return...

        // optimización -> cada vez que se carga la página se busca lo guardado en la caché, no el código una y otra vez
        // posiblemente este código se optimice aún más (con service providers) pero de momento queda así
        return cache()->rememberForever('posts.all', function(){
            return collect(File::files(resource_path("posts")))
            ->map(fn ($file) => YamlFrontMatter::parseFile($file))
            ->map(fn ($document) => new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $document->slug,
            ))
            ->sortByDesc('date');
        });

    }

    public static function find($slug)
    {
        // if (!file_exists($path = resource_path("posts/{$slug}.html"))) {
        //     // si el archivo no existe, lanzar una excepción
        //     throw new ModelNotFoundException();
        // }
        // return cache()->remember("posts.{$slug}", 3600, fn () => file_get_contents($path));

        // la función anterior encontraba todo, ahora queremos que de los post que hay, se encuentre el que tenga el slug correspondiente al que se ha pedido

        // $posts = static::all();
        // esto nos daría todos los que tenemos arriba
        // dd($posts->firstWhere('slug', $slug));
        // encuentra el primero donde slug es slug, es decir, abre los posts en modo consola (fondo negro, letra verde)

        // todo junto
        return static::all()->firstWhere('slug', $slug);

    }

    public static function findOrFail($slug){

        // incluyendo la validación de caracteres
        // $post = static::all()->firstWhere('slug', $slug);

        $post = static::find($slug);

        if(!$post) {
            throw new ModelNotFoundException();
        }

        return $post;

    }
}

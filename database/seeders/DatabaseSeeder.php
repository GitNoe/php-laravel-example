<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // se truncan las categorias para evitar conflicto de siembra de datos duplicada
        // User::truncate();
        // Post::truncate();
        // Category::truncate();
        // una vez hechas las factories y habiendo refrescado la database, ni siquiera es necesario que se trunquen

        // usuario que yo decido
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);

        // vinculado al usuario
        Post::factory(5)->create([
            'user_id' => $user->id
        ]);

        // \App\Models\User::factory(10)->create();
        // $user = User::factory()->create();

        // también necesitaremos factory para categorías pero de momento no lo hemos visto, así que creamos así:
        // (recordar que esto solo vale en testing y en local, en producción no se refresca la base constantemente)

        // esta sería la manera manual
        // $personal = Category::create([
        //     'name' => 'Personal',
        //     'slug' => 'personal'
        // ]);
        // $work = Category::create([
        //     'name' => 'Work',
        //     'slug' => 'work'
        // ]);
        // $hobbies = Category::create([
        //     'name' => 'Hobbies',
        //     'slug' => 'hobbies'
        // ]);

        // Post::create([
        //     'user_id' => $user->id,
        //     'category_id' => $personal->id,
        //     'title' => 'My Personal Post',
        //     'slug' => 'my-personal-post',
        //     'excerpt' => '<p>Lorem ipsum dolar sit amet.</p>',
        //     'body' => '<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates consectetur culpa numquam nesciunt tempora rerum, odio aliquam nostrum assumenda eaque sequi molestias molestiae adipisci accusamus natus explicabo deserunt, minima dignissimos!</p>'
        // ]);
        // Post::create([
        //     'user_id' => $user->id,
        //     'category_id' => $work->id,
        //     'title' => 'My Work Post',
        //     'slug' => 'my-work-post',
        //     'excerpt' => '<p>Lorem ipsum dolar sit amet.</p>',
        //     'body' => '<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates consectetur culpa numquam nesciunt tempora rerum, odio aliquam nostrum assumenda eaque sequi molestias molestiae adipisci accusamus natus explicabo deserunt, minima dignissimos!</p>'
        // ]);
        // para todos los que quisiéramos crear
    }
}

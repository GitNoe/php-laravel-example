# Ejemplo de aplicación PHP con Framework Laravel

El objetivo de este proyecto es seguir la construcción de un CMR (un blog) con Laravel y hacer pruebas a la par que se miran vídeos informativos y explicativos sobre este framework de [laracasts](https://laracasts.com/series/laravel-8-from-scratch).

Lo primero es crear el proyecto desde laragon con "composer", correr el servidor con "php artisan serve" y modificar el archivo ".env" para las variables de conexión con la base de datos (que también hay que crear). Si es necesario, también se pueden editar config/app.php y config/database.php.

- "composer require barryvdh/laravel-debugbar --dev" para meter una barra de control en el pie de la aplicación (una especie de consola con views, rutas, modelos, métodos, etc. -muy útil-), y "composer fund" para que se actualice todo.
- "npm install" y "npm run dev" para otras dependencias.

## Laravel Básico y Posts de un Blog (Estático con elementos Dinámicos)

Lo primero que debe estar claro es cómo funcionan las rutas dentro del framework, es sencillo:

- dentro de routes tenemos el archivo web.php, donde están las direcciones del front-end que se verá por pantalla
- los archivos de front-end se encuentran en resources/views, por defecto nos encontramos un welcome.blade.php con información sobre laravel
- estas dos carpetas hablarán entre sí para redireccionarnos a cada apartado de la app

He cambiado mi home page de welcome a otra que se llama posts (resources/views/posts.blade.php), simplemente cambiando la dirección en web.php.

*Para incluir CSS y JavaScript*: estos archivos están creados en resources y finalmente se compilarán ahí pero inicialmente creamos un app.css en la carpeta public y se linkea en blog.blade.php como una hoja de estilos. Si quisiéramos hacer JS propio sería el mismo proceso.

*Editando nuestra vista*: introducimos código html en blog.blade.php y css en la hoja de estilos para visualizar una serie de posts estáticos, ya que al no tener todavía una base de datos la página no es dinámica.

Después de tener varios artículos, vamos al archivo de rutas y creamos una nueva función de ruta para ir a cada uno de ellos, convirtiendo los títulos en links que, de momento, no funcionan porque no tienen una vista propia creada. Creamos esa vista en post.blade.php, e indicamos ahí el código del primer artículo (y un enlace para volver a home). Ahora el problema es que al clicar en cualquier artículo somos siempre redirigidos al primero.

Para solventar esto se utiliza php, de forma que declaramos una variable post en vez del código html original en la view. Como todavía no hay base de datos, creamos la carpeta "posts" en resources y dentro de ella los html individuales de los posts. Y por último indicamos en web.php cómo se abrirán las rutas a cada post y si hay alguna restricción de sintaxis (se ha visto el proceso lógico en los vídeos 8 y 9). Aunque este sistema que obtenemos ahora es funcional, se utiliza caching (cache) para facilitar operaciones y que el navegador guarde la dirección durante un tiempo.

Obviamente este sistema de archivos html no es dinámico, por lo que modificamos el proyecto creando una clase Post que se usará para encontrar los artículos mediante la función $slug. Las clases se crean en app/Models, y dentro de ellas se acumulan todas las funciones que queramos darles. De hecho, se cambia la forma de enrutar en web.php y lo que se había escrito anteriormente pasa a ser la función find($slug). Tras esto nos conviene modificar nuestro posts.blade.php para hacerlo un archivo dinámico, no estático como hasta ahora, para lo que se construye una nueva función "all" en la clase.

En cuanto a los html que se referencian, es de buena práctica separar el contenido de la información meta como título o fecha de publicación, se puede ver el el nuevo archivo "my-fourth-post.html". Para ello instalamos el siguiente paquete: "composer require spatie/yaml-front-matter" y modificamos la forma de enrutar en web.php, tras explorar este recurso tendremos una función con una colección de laravel, un array y un bucle que nos darán los posts con sus meta-datos y sus contenidos, unido a una función construct en la clase Post (y la función "all" modificada) y a los debidos cambios en los blades para referenciar las variables e imprimir los html.

Por último, se incluye la funcionalidad de clasificar (sorting) los posts para que se muestren del más reciente al más antiguo mediante un método en la función "all" de la clase Post. Además, se recupera el uso de caching para optimizar el código y que la función no tenga que cargar las variables cada vez que se refresca la página.

## Usando Blades

Hasta ahora se han usado las vistas simplemente para referenciar los archivos .html de resources, pero los templates blade nos dan muchas opciones para hacer sencillo el front-end. Por ello, cambiamos el php que teníamos hasta ahora por formato "blade", y si queremos ver el php que se crea cuando laravel traduce blade a vainilla podemos ir a "storage/framework/views" y encontrar esos archivos ahí. Blade tiene muchos recursos disponibles como sintaxis y componentes específicos, sólo debemos recordar que cada orden tiene que cerrarse con un "@end" para que todo funcione.

Visto lo básico, podemos crear layouts de blade para tener unas vistas de front-end ordenadas y simples.

- La primera forma es crear en la misma carpeta de resources/views un layout.blade.php que funcione como el esqueleto del blog, y con sintaxis de blade crear las referencias que queramos en cada archivo php.
- Otra manera es mediante el uso de componentes blade (parecidos a los components de js), que permiten agrupar pedazos de html en ellos. Para ello se crea una carpeta "components" dentro de "views", y en ella los archivos que funcionarán como componentes. El mismo layout creado en el punto anterior se puede mover a la carpeta y convertir en componente, con la diferencia de que en vez de trabajar con secciones lo haremos con variables (ver archivos).

Aunque ambas opciones son válidas, la segunda forma nos permite crear layouts de cualquier cosa (formularios, botones, secciones de página, etc.), lo que resultará muy útil en una aplicación grande que se deba dividir en pequeños componentes para su optimización.

Una última modificación en esta parte del tutorial es cambiar la "validación" del Post::find que hay en web.php (que funciona) a una condicional en la propia función de la clase Post (cambiada a findOrFail), simplemente para mejorarla.

## Conectando a la base de datos (BRANCH)

Antes de continuar, es necesario crear un repositorio Git y publicar el proyecto en Github, creando una primera rama del sitio estático antes de realizar la conexión a base de datos. Este proceso se hace desde la terminal como todos los proyectos realizados hasta la fecha, sin necesidad de crear un .gitignore porque lavarel lo trae por defecto.

Entonces el repositorio (php-laravel-example) tendría:

- Una rama general (branch:master) con el README.md del proyecto.
- Una rama inicial (branch: basics-and-blades) con lo hecho hasta ahora.
- Una nueva rama (branch: bbdd-mysql) para continuar con una mayor compartimentalización del proyecto (actual).

### Conexión a MySQL

Actuamos sobre el archivo .env (contemplado en el .gitignore para que sea privado) para modificar nombres y claves referentes a la conexión sobre la database. Después abrimos mysql por terminal con el usuario root y su contraseña (si la tiene), y creamos/usamos la base de datos cuyo nombre se refleja en ".env" (mismo que el proyecto).

El primer paso es correr el comando "php artisan migrate", que crea varias tablas pre-establecidas en la base de datos. Si entramos en mysql y ordenamos "show tables;" se mostrarán en la consola. Para manejar la base de datos y hacer operaciones se usará la aplicación de escritorio TablePlus, creando una conexión con la base local podemos visualizar las tablas y todas sus características.

### Migraciones y Modelos

Si vamos a la carpeta "database/migrations" podemos ver los archivos correspondientes a nuestras tablas, con sus clase y métodos especificados dentro (up para correr la migración, down para revertirla). Si usamos el comando "php artisan" en la terminal obtenemos una lista de comandos, entre ellos varios con la sintaxis "migrate:-order-", muy útiles para manejar migraciones. Algunos vistos aquí son:

- php artisan migrate:rollback
- php artisan migrate
- php artisan migrate:fresh (¡cuidado! si estás en producción se eliminarán todos los datos)

Probamos a crear en la app una fila de datos en la tabla "users", sobre la cual también se pueden realizar múltiples operaciones (crear, eliminar, copiar sentencia, escribir sql...); y nos disponemos a editar un "Eloquent Model", que por ahora es la forma por defecto de laravel para interactuar con la database. En este caso la tabla "users" se corresponde con el modelo y clase "User", que ya está creada en app/Models, para más información buscar "Active Record Pattern".

Para crear un nuevo user vemos en terminal:

- php artisan tinker + $user = new App\Models\User; (o $user = new User;) + atributos(*)
  - (*) $user->name = 'JeffreyWay';
  - (*) $user->email = 'jeffrey@laracast.com';
  - (*) $user->password = bcrypt('!password'); ->función de encriptado
  - $user->save(); -> guardar en la base
- Ahora podemos buscar al usuario/s en terminal mediante comandos, funciones o atributos (vídeo 19, minuto 4), incluso sacar las *colecciones* de datos que queramos con solo especificarlo.
- Creamos otro user "Sally".
  
### Modelo Post

El siguiente objetivo es transicionar a un Eloquent Model de Post, por lo que desechamos el archivo Post.php (de momento guardado en otra carpeta) y comenzamos con la migración (php artisan -> comandos "make" -> migrate y model) y creación del modelo en este orden:

- php artisan make:migration create_posts_table (el nombre de la tabla siempre debe mostrar lo que ésta hace/es).
- en "database/migrations" tendremos nuestro archivo de la migración con sintaxis básico que genera laravel.
- aprovechando lo hecho en capítulos anteriores, descartamos la carpeta "posts" de resources ya que no hará más falta y los atributos que veíamos reflejados en los meta-datos de los html pasarán a ser variables o sentencias del archivo de la migración.
- php artisan migrate para actualizar la base de datos
- php artisan make:model Post -> se crea Post.php
- al igual que se hizo con User, usando "php artisan tinker" creamos nuevos Posts ($post = new App\Models\Post;) e introducimos sus atributos (*)
  - $post->title = 'My first Post';
  - $post->excerpt = 'Lorem ipsum dolar sit amet.';
  - $post->body = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates consectetur culpa numquam nesciunt tempora rerum, odio aliquam nostrum assumenda eaque sequi molestias molestiae adipisci accusamus natus explicabo deserunt, minima dignissimos!';
  - $post->save();
- podemos ver que todo está creado y en orden en TablePlus.

Como ya había trabajo avanzado de los capítulos anteriores, nuestro archivo web.php no necesita muchos cambios, solamente cambiar lo que conocíamos como $slug al $id que genera la base de datos (y cambiarlo también en el balde de posts). Creamos un post más con el método explicado y corremos el servidor para comprobar que todo funciona bien.

No obstante, al deshacernos de los html perdemos parte del estilo establecido que teníamos antes (márgenes, espaciado...), para lo que utilizamos la opción de "php artisan tinker" para *actualizar* los datos:

- $post = App\Models\Post::first(); -> para entrar en el post que queramos, podíamos buscarlo por ejemplo por id también.
- $post->body = '</p>' . $post->body . '</p>'; -> le digo a la base que esa columna está en html (también se podría md).
- $post->save(); -> siempre necesario para la base de datos y, por tanto, lo que se ve en el navegador.
- hacemos lo mismo con el otro post, esta vez por id -> $post = App\Models\Post::find(2); + los otros 2 comandos.

Podemos hacer lo mismo con cualquier atributo/columna, incluso salvando la necesidad de poner siempre la ruta de Post:

- use App\Models\Post;
- $post = Post::first();
- $post->title = 'My </strong>First</strong> Post'; -> hará falta cambiar el blade de post/s a sintaxis con html ({!!__!!})
- $post->save();

Tener en cuenta que para hacer todo este tipo de cambios es necesaria una seguridad de que hay control sobre los datos, y que no cualquiera puede modificarlos, o será peligroso que se pueda modificar la base tan fácilmente.

### Formas de mitigar las vulnerabilidades de asignaciones masivas

Hasta ahora se han introducido los datos en la base escribíendolos uno a uno en terminal, con los comandos indiviualizados, pero es posible hacerlo con uno general de la siguiente forma:

- Post::create(['title' => 'My Third Post', 'excerpt' => 'excerpt of post', 'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates consectetur culpa numquam nesciunt tempora rerum, odio aliquam nostrum assumenda eaque sequi molestias molestiae adipisci accusamus natus explicabo deserunt, minima dignissimos!']);
- Pero esta secuencia nos provoca un error de MassAsignmentException que pide meter los datos de la forma anterior.
- Entonces, lo necesario es ir a Post.php (el modelo) y añadir una propiedad que permita introducir los datos. Esto también tiene que ver con la seguridad por defecto, para no permitir la entrada de cualquier dato por cualquier usuario.
  - "protected $fillable = ['title', 'excerpt', 'body'];"
- Sin embargo, hay atributos como el id que se pueden saltar esa seguridad, lo que constituye una gran vulnerabilidad en las asignaciones masivas. Para evitarlo tenemos varias opciones:
  - utilizar un "protected $guarded = ['id'];" que guardaría todo menos el id dado (cogería el siguiente natural).
  - utilizar un "protected $guarded = [];" es decir, un array vacío que permitiría editar los datos (opción válida siempre que tengamos control sobre ellos).
  - no utilizar asignaciones masivas para introducir los datos, de forma que nunca habrá esas vulnerabilidades.
- Una vez elegida la opción que queramos, si hay uno de estas variables en vez de actualizar los datos de forma manual como antes podemos utilizar un método update: "$post->update(['excerpt' => 'excerpt changed'])" por ejemplo.

### Enrutar el Modelo

La función de web.php para obtener los posts actualmente captura el id y usa un método de la clase, pero lo óptimo sería que laravel supiera directamrnte que queremos un post pasándole esa variable. Esto se conoce como "route model binding" o "enlace de modelo de ruta".

Lo más importante aquí es que el nombre de la wildcard {post} (lo que se pone en "get") coincida con la variable de la función, que en este caso es $post. Y esto funcionará sin mayor problema en principio porque el framework coge por defecto como identificador el id del post y la base de datos no devuelve ningún error; de hecho es la metodología más común de usar.

No obstante, habrá situaciones donde en vez del id queramos identificar un eloquent model por un slug u otra columna de la tabla. Por ejemplo, si añadiéramos una *columna slug* a la tabla (especificándolo en el archivo de migración e introduciendo cada uno haciendo migrate:fresh y rehaciendo las filas de datos), la ruta del archivo web.php cambiaría a:

Route::get('posts/{post:slug}', function (Post $post){
    return view('post', [
        'post' => $post
    ]);
});

Y por supuesto en el blade de posts se tendría que volver a cambiar id por slug (visible en la url).

Otra manera de hacer esto es implementar el Post.php un método "public function getRouteKeyName() {return 'slug';}" que devuelve el atributo que se le especifique a la función (sin necesidad de añadir "slug" a la wildcard, es decir, como si fuera a coger el id). Hace un tiempo esta era la única forma de conseguir el enrutamiento, pero ahora nos quedamos con la anterior opción.

### Primera relación Eloquent

Los posts de un blog se ordenan comúnmente en categorías mediante una relación entre ambos, así en un futuro podremos filtrar los posts de acuerdo con su categoría. Para hacer esta parte vamos a cambiar nuestros posts a ejemplos que podrían encontrarse en un blog real (family, work, hobby...), mismamente desde la app de TablePlus y commit los cambios. En la terminal se puede comprobar que todo sigue funcionando.

Lo primero es crear una tabla y un modelo de las categorías como ya hicimos antes con los posts:

- php artisan make:migration create_categories_table
- php artisan make:model Category
- (mix) se puede hacer todo de una con: "php artisan make:model Category -m" (m de migration).

Obtenemos Model/Category y el php en database/migrations (este será el que editemos para especificar las columnas que queramos en nuestra tabla categories, igual que hicimos con posts, aunque de momento sólo serán slug y name).

Además, es imprescindible que creemos una nueva columna en posts para que se corresponda con una categoría y poder asociar una tabla con la otra. En este caso será un simple "$table->foreignId('category_id');".

Migramos de nuevo nuestras tablas con "php artisan migrate:fresh", pero si no queremos perder los datos de posts debemos copiar el código SQL desde TablePlus -> Copy As -> INSERT Statement y guardarlo (en un txt) para poder reusarlo más tarde. Por el momento usaremos el modelo elocuente que hemos instaurado en la aplicación para crear las primeras categorías:

- use App\Models\Category;
- $c = new Category;
- $c->slug = 'personal';
- $c->name = 'Personal';
- $c->save();
- lo mimso con Work y Hobbies

Ahora podemos crear posts que pertenezcan a una categoría concreta (rescatar código sql para no tener que reescribir todo otra vez):

- use App\Models\Post;
- Post::create([
    ... 'title' => 'My Family Post',
    ... 'slug' => ''my-family-post',
    ... 'excerpt' => 'excerpt of post',
    ... 'body' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptates consectetur culpa numquam nesciunt tempora rerum, odio aliquam nostrum assumenda eaque sequi molestias molestiae adipisci accusamus natus explicabo deserunt, minima dignissimos!',
    ... 'category_id' => 1
    ]);
- podemos hacer lo mismo con los otros posts, uno por categoría, incluso los 3 a la vez con mass asignment (ver txt).
- si vamos a TablePlus ahora podemos seleccionar los posts por categoría con una orden de sql: "select * from posts where category_id = ?;" (? = número)

Aunque cada post tiene asignada una categoría, la relación todavía no está terminada, es necesario crear dicha función en Post.php, y por suerte laravel tiene por defecto varios métodos útiles para ello.

- public function category() { return $this->belongsTo(Category::class); } -> nuestra primera relación elocuente
- accediendo por terminal, hacer "$post->category;" (como propiedad, no como método) nos da los atributos correspondientes

Por último, sólo queda modificar el blade de posts para incluir una referencia a la clase, de momento será un link sin destino que rescataremos próximamente.

### Category Page y todos sus Posts

Una vez asociados los posts y categorías, falta hacer una página de cada que muestre todos los posts asociados a ellas. Es decir, que haciendo click en la categoría se listen los posts de la misma.

Parece que lo primero que necesitamos entonces es una ruta nueva en web.php (recordar que la wildcard y la variable deben coincidir). Después aprovechamos la función que creamos en Post.php y hacemos una parecida en Category.php, modificada porque la relación ya no será belongsTo sino hasMany.

Ahora, si comprobamos por terminal los posts de una categoría no tendremos problema en recibirlos por pantalla:

- php artisan tinker
- App\Models\Category::first() -> muestra categoría
- App\Models\Category::first()->posts; -> muestra las entradas

Por supuesto aún faltan algunas modificaciones para que todo funcione: editar los dos blades para incluir las rutas a las categorías (primero probamos con el id pero luego nos quedamos mejor con el slug, y por tanto lo indicamos en la ruta).

Cabe destacar un defecto de código que nos encontramos al hacer la ruta y su link de esta manera, es el llamado **problema N+1**: en posts.blade.php tenemos un loop foreach y dentro de él accedemos a una relación que todavía no se ha cargado, lo que se traducirá en una orden/ejecución extra de sql (query) por cada ítem del loop (y si se añaden más ítems, se sumarían las queries).

Para hacer debug de sql y visualizar el problema el tutorial enseña un método manual y después recomienda la herramienta "clockwork" (composer require itsgoingd/clockwork + añadir extensión del navegador), que cumple la misma función.

La solución al problema N+1 será modificar la ruta de get('/') de forma que "'posts' => Post::all()" se convierta en "'posts' => Post::with('category')->get()". Problem solved.

### Añadir autores, seeding de la database, turbo boost con factories

Cada vez es más común que un blog tenga varios editores o autores, y ese dato también debe mostrarse en los posts, quizás de la misma manera que la categoría y que sea un elemento más que al clicar nos devuelva unos resultados (los posts de ese autor). Pero para eso aún faltan algunas cosas.

Primero, tenemos creado por defecto un php en migrations referido a la tabla users, pero todavía no hay relación ninguna con la de posts. Para hacela usaremos otra vez la foreignId como hicimos con categorías ("$table->foreignId('user_id');"). Como añadir esa línea nos añade una columna más en nuestra tabla posts, es necesario un "php artisan migrate:fresh" (mejor guardar el sql que ya tengamos para no rehacer todo de nuevo).

#### Database Seeding y Relación Posts-Users

Aquí es buen momento para hacer un inciso, ya que cada vez en más molesto perder los datos de las tablas cuando hay un cambio y tenemos que migrarlas de nuevo. Para arreglar esto se utiliza el llamado Database Seeding (siembra de la base de datos), yendo a database/seeders/DatabaseSeeder.php (podemos ver que hay una función "run" comentada, la activamos) y corriendo en la terminal el comando "php artisan db:seed" (siembra la base con records -> registros, en este caso con 10 porque es el número especificado en la función "run").

En nuestro caso no necesitamos más que un usuario por el momento así que eliminamos los users creados y modificamos la función de DatabaseSeeder.php, importando los modelos y declarando funciones para crear contenido.

Si probamos a hacer "php artisan db:seed" otra vez, funciona y obtenemos 1 autor y 3 categorías, pero nos topamos con el problema de que si repetimos el comando las filas se duplican porque en nigún momento especificamos que el nombre o slug debe ser único. Esto se declara en los php de migrations en cada una de las variables/columnas de la tabla (categories).

Ahora podemos hacer el comando "php artisan migrate:fresh --seed", que hará 3 cosas en una: borrar las tablas, migrarlas de nuevo y hacer la siembra de datos. Pero, si hacemos "php artisan db:seed" de nuevo nos saltará un error por el intento de duplicación de datos, así que es necesario un método "truncate" al inicio de la función "run" para cada tabla que estemos sembrando, y problema solventado.

Por terminar con otro añadido de datos, hacemos con posts lo mismo que con categorías para que el seeding incluya registros en esa tabla. Comprobamos en TablePlus y todo correcto, y si de nuevo queremos refrescar la base el comando "php artisan migrate:fresh --seed" nos la devolverá con los datos declarados.

Antes de pasar a las factories, conviene dejar hecha la relación elocuente entre posts y users, ya que ahora están unidos por esa columna de id. Una vez hecho podemos encontrar cuanquiera de ellos por comandos de "php artisan tinker" en terminal.

- En Post.php -> nueva función pública, método belongsTo.
- En User.php -> nueva función pública, método hasMany (el inverso del otro).

El ultimo paso es ir a post.blade.php y hacer dinámico el link para acceder al autor. Correr "php artisan db:seed" y listo.

#### Turbo Boost with Factories

Dentro del directorio database/, nos hemos familiarizado con las carpetas migrations/ y seeders/, pero también hay una de factories/ con un archivo por defecto para la UserFactory, que contiene una función de definición con unos atributos codificados para devolver datos inventados, lo que es muy útil para el testeo de la aplicación. Lo que hacemos en DatabaseSeeder es llamar a la factory para que cree al User falso.

Podemos crear todos los users que queramos por terminal:

- php artisan tinker
- App\Models\User::factory()->create();
- App\Models\User::factory(20)->create(); //crea 20 de golpe//

Vemos que todo funciona bien, pero obviamente nos encontramos con que ni Post ni Category tienen Factories, así que las creamos y les damos el mismo formato que a la de User -> php artisan make:factory PostFactory / CategoryFactory + atributos de cada modelo con los elementos falsos que tienen que devolver.

**Nota**: para futuros proyectos, es útil saber que las migraciones, seeders, factories etc., además de sus comandos específicos también se pueden crear desde el modelo. Si creáramos un elemento más aquí, cometarios por ejemplo, podríamos hacer simplemente "php artisan make:model Comment -mf" (migration and factory)

Si no nos importa borrar los datos, corremos "php artisan migrate:fresh" para que se limpien las tablas, y en cuanto demos una orden de crear se generarán los datos sin problema. Por ejemplo:

- php artisan tinker
- App\Models\Post::factory()->create();

Por último, sólo falta limpiar el código de DatabaseSeeder, puesto que ya no es necesaria la sintaxis para introducir manualmente los datos en las columnas de las tablas.

- La función "run" pasa de tener un montón de líneas a una sola: "Post::factory()->create();".
- Corremos "php artisan db:seed" y funciona.
- Cuando eliminamos las funciones truncate, corremos "php artisan migrate:fresh --seed" y sigue funcionando todo.
- Cambiamos a "Post::factory(5)->create();" -> el número de posts que queramos.
- Otra vez "php artisan migrate:fresh --seed".

El proceso es el mismo para los otros modelos, y si quisiéramos que ciertos datos fueran establecidos y no generados aleatoriamente, también es posible (ver DatabaseSeeder). De hecho, ahora tenemos un sólo usuario con 5 posts.

#### Ver todos los Posts de un Autor

Tras todas estas funcionalidades de nuestro blog, lo que queda es poder clicar en un usuario o autor y que se nos muestren todos los posts escritos por el mismo. Pero antes hacemos un pequeño cambio en web.php para que los posts más recientes se vean los primeros en la página.

Bien, lo indicado ahora es que los posts se correspondan con un autor en vez de un usuario, por lo que hay que cambiar esa variable de alguna forma. Como estamos usando laravel (que asume ciertos parámetros de sintaxis) no es posible hacer esto simplemente cambiando el nombre de la función o el atributo, es necesario indicarle que la llave foránea de la tabla sigue siendo user_id. Además se cambia user por author en la vista blade de post, y se añade el autor en la página de todos los posts.

Aquí volvemos a encontrarnos con el **problema N+1**, pero lo solucionamos en web.php como la otra vez, incluyendo author al igual que hicimos con category.

Ahora sí que estamos preparados para crear una página que despliegue los posts de cada autor.

- Ruta en web.php
- Links en blades

En principio indicamos que se recoja el id del autor como identificador, así que es lo que se ve en la url del blog, pero lo mejor sería mostrar un nombre de usuario reconocible porque el lector podría buscarlo directamente. Así que vamos al php de la migración de users y añadimos la columna "username" para utilizarla en estos términos (también añadirla en UserFactory).

Hacemos "php artisan migrate:fresh --seed" y tenemos nuestros datos actualizados. Cambiamos id por username en los blades y añadimos el atributo en web.php, y listo.

### Final de Capítulo: Cargar Relaciones en un Modelo Existente

Echemos un vistazo a alguna de las categorías. Si solo tenemos un post en ella, creamos algunos más:

- php artisan tinker
- App\Models\Post::factory(10)->create(['category_id' => 1]);

Si nos fijamos con la herramienta clockwork mencionada anteriormente, volvemos a tener el **problema N+1** en las categorías (y en authors), ya que las relaciones se han hecho en modelos existentes. Para arreglarlo nos vamos de nuevo a web.php y usamos el método load, que rebaja considerablemente el número de queries que se van a enviar y recibir.

Otra forma de conseguir esto es indicar que cada vez que pedimos un post siempre se incluyan la categorís y el autor como parte del resultado, se puede hacer mediante la propiedad "with" declarándola en Post.php y después modificando web.php (donde teniamos repetido varias veces el array de categoría y autor ya no hace falta).

Si bien este método funciona muy bien, no siempre querremos utilizarlo porque dependerá de las relaciones que se cargan (o no). Selectivamente podemos desmarcar alguno de esos resultados con el método "without".

Las opciones son innumerables y se pueden hacer muchas más cosas pero hasta esta fase lo dejaremos así.

*Vídeos vistos del tutorial*: **30/70**

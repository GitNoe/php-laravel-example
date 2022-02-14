# Ejemplo de aplicación PHP con Framework Laravel

El objetivo de este proyecto es seguir la construcción de un CMR (un blog) con Laravel y hacer pruebas a la par que se miran vídeos informativos y explicativos sobre este framework de [laracasts](https://laracasts.com/series/laravel-8-from-scratch).

Lo primero es crear el proyecto desde laragon con "composer", correr el servidor con "php artisan serve" y modificar el archivo ".env" para las variables de conexión con la base de datos (que también hay que crear). Si es necesario, también se pueden editar config/app.php y config/database.php.

- "composer require barryvdh/laravel-debugbar --dev" para meter una barra de control en el pie de la aplicación (una especie de consola con views, rutas, modelos, métodos, etc. -muy útil-), y "composer fund" para que se actualice todo.
- "npm install" y "npm run dev" para otras dependencias.

## Usando Laravel Base y Creando Posts de un Blog (Estático con elementos Dinámicos)

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

## Conectando a la base de datos

Antes de continuar, es necesario crear un repositorio Git y publicar el proyecto en Github, creando una primera rama del sitio estático antes de realizar la conexión a base de datos. Este proceso se hace desde la terminal como todos los proyectos realizados hasta la fecha, sin necesidad de crear un .gitignore porque lavarel lo trae por defecto.

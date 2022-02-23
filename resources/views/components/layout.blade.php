<!DOCTYPE html>

<title>My Blog</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="/app.css">
<!-- todos los archivos que queramos referenciar irán aquí una sola vez, no en cada vista como antes -->

<body>

    <!-- <header>@yield('banner')</header> -->
    <!-- en cada vista habrá una referencia -sección- a este yield -->
    <!-- @yield('content') -->

    <!-- trabajando con componentes -> $content entre dobles llaves -->

    <!-- para ir acomodándonos a la sintaxis propia, slot es el contenido por defecto de blade -->
    {{ $slot }}

</body>
</html>

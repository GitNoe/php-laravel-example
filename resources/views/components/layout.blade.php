<!DOCTYPE html>

<title>My Blog</title>
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

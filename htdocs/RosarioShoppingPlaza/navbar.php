<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles/navbar.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="text-light navbar-brand" href="#">[Logo]</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/ElShopping">    Shopping</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/Servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/Contactanos">Contactanos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/Locales">Locales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/Promociones">Promociones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="navitem" href="/Novedades">Novedades</a>
                    </li>
                </ul>
                <form class="d-flex me-auto ms-auto justify-content-center" role="search" method="get" action="buscadorLocales.php">
                    <input type="search" class="form-control ms-2 me-2" id="searchbar" name="searchbar" placeholder="Busca un local" aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </form>
                <ul class="navbar-nav ms-2 mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="btn me-2" id="boton" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn " id="boton" href="/register">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
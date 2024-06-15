<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href="index.php"><img src="images/logo.png" width="50px"></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav_item" href="el_shopping.php">El Shopping</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav_item" href="servicios.php">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav_item" href="contacto.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav_item" href="locales.php">Locales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav_item" href="promociones.php">Promociones</a>
                </li>
            </ul>
            <form class="d-flex me-auto ms-auto justify-content-center" role="search" method="get" action="buscadorLocales.php">
                <input type="search" class="form-control ms-2 me-2" id="searchbar" name="searchbar" placeholder="Busca un local" aria-label="Search">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <ul class="navbar-nav ms-2 mb-2 mb-lg-0">
                <?php 
                if (isset($_SESSION["logged"])) {
                    ?>
                    <li class="nav-item">
                        <a class="btn me-2 navbar-btn-outline navbar-logout" href="logout.php">Cerrar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn navbar-btn navbar-profile" href="perfil.php"><i class="fa-solid fa-user"></i></a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="btn me-2 navbar-btn navbar-login" href="login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn navbar-btn navbar-signup" href="signup.php">Registrarse</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

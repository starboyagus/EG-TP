<?php

// ↓-↓ Elementos de navbar //

# Logo (ancho y alto variable)
function shopping_logo(float $width, float $height = -1) {
    if($height > 0) {
        echo "<a class='navbar-brand' href='index.php'><img src='./images/logo.png' width='$width"."px' height='$height"."px'></a>";
    } else {
        echo "<a class='navbar-brand' href='index.php'><img src='./images/logo.png' width='$width"."px'></a>";

    }
}

# Crea un elemento link para la navbar
function navbar_item($label, $link, $active) {
    echo "<li class='nav-item";
    echo $active ? "active'>" : "'>";
    echo "<a class='nav-link' href='$link'>$label</a>";
}

# Navbar
function navbar() {
    echo '<nav class="navbar navbar-expand">';
    shopping_logo(50);
    echo '<div id=navbarNav><ul class="navbar-nav">';
    navbar_item("El Shopping", "index.php", false);
    navbar_item("Servicios", "#", false);
    navbar_item("Contacto", "#", false);
    navbar_item("Locales", "locales.php", true);
    navbar_item("Promociones", "#", false);
    navbar_item("Novedades", "#", false);
    echo '</ul></div>';
    echo '<div id=navbarBtns><ul class="navbar-nav">';
    if (isset($_SESSION["logged"])) {
        navbar_item("Perfil", "#", false);
        navbar_item("Cerrar sesión", "logout.php", false);
    } else {
        navbar_item("Iniciar sesión", "login.php", false);
        navbar_item("Registrarse", "signup.php", false);
    }
    echo '</ul></div></nav>';
}


// ↑-↑ Elementos de navbar //

?>
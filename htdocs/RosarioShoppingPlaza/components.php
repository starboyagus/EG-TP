<?php

# Elemento Input (preferiblemente usar solo para $type=[text | password | email])
function input_field($label, $type, $name, $placeholder = "", $pattern = "") {
    echo '<label for="' . $name . '">' . $label . '</label>';
    echo '<br>';
    echo '<input type="' . $type . '" name="' . $name . '" id="' . $name;
    if ($placeholder != "") {
        echo '" placeholder="' . $placeholder;
    }
    if (isset($_POST[$name]) && $_POST[$name] != "") {
        echo '" value="' . htmlspecialchars($_POST[$name]);
    }
    if ($pattern != "") {
        echo '" pattern="' . $pattern;
    }
    echo '" class="form_field">';
}

# Elemento Checkbox
function checkbox($text, $name, $onclick = "") {
    echo '<input type="checkbox" name="' . $name . '" id="' . $name;
    if ($onclick != "") {
        echo '" onclick="' . $onclick;
    }
    echo '">';
    echo '<label for="' . $name . '">' . $text . '</label>';
}

# Elemento Boton
function button($text, $name) {
    echo '<button type="submit" name="' . $name . '" value="'. $name .'" class="btn form_btn">' . $text . '</button>';
}

# Elemento A (Link)
function a($text, $url) {
    echo '<a href="' . $url . '" class="a_link">' . $text . '</a>';
}

# Elemento A en P (Link en párrafo)
function p_a_p($text, $url, $p_left = "", $p_right = "") {
    echo '<p>';
    if ($p_left != "") {
        echo $p_left;
    }
    a($text, $url);
    if ($p_right != "") {
        echo $p_right;
    }
    echo '</p>';
}

# Navbar
function navbar() {
    echo '<div class="top-nav">';
    shopping_logo(50);
    echo '<nav class="nav-links">';
    echo '<a href="#">El Shopping</a>';
    echo '<a href="#">Servicios</a>';
    echo '<a href="#">Contacto</a>';
    echo '<a href="#">Locales</a>';
    echo '<a href="#">Promociones</a>';
    echo '<a href="#">Novedades</a>';
    echo '</nav><div class="session-btns">';
    if (isset($_SESSION["logged"])) {
        echo '<a href="#">Perfil</a>';
        echo '<a href="logout.php">Cerrar sesión</a>';
    } else {
        echo '<a href="login.php">Iniciar sesión</a>';
        echo '<a href="signup.php">Registrarse</a>';
    }
    echo '</div></div>';
}

function shopping_logo(float $width, float $height = -1) {
    if($height > 0) {
        echo '<a href="index.php"><img src="./images/logo.png" width="'.$width.'px" height="'.$height.'px"></a>';
    } else {
        echo '<a href="index.php"><img src="./images/logo.png" width="'.$width.'px"></a>';

    }
}

?>
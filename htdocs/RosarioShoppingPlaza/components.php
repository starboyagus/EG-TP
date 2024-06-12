<?php

// ↓-↓ Elementos de formulario //
# Elemento Label
function label($label, $id) {
    echo '<label for="' . $id . '">' . $label . '</label>';
}


# Elemento Input (preferiblemente usar solo para $type=[text | password | email])
function input($label, $type, $id, $placeholder = "", $pattern = "") {
    echo '<input type="' . $type . '" name="' . $id . '" id="' . $id;
    if (!empty($placeholder)) {
        echo '" placeholder="' . $placeholder;
    }
    if (isset($_POST[$id]) && !empty($_POST[$id])) {
        echo '" value="' . htmlspecialchars($_POST[$id]);
    }
    if (!empty($pattern != "")) {
        echo '" pattern="' . $pattern;
    }
    echo '" class="form-control">';
}

# Elemento Checkbox
function checkbox($label, $id, $onclick = "") {
    echo '<input type="checkbox" name="cb-' . $id . '" id="cb-' . $id;
    if ($onclick != "") {
        echo '" onclick="' . $onclick;
    }
    echo '" class="checkbox">';
    echo '<label class="form-check-label" for="cb-' . $id . '">' . $label . '</label>';
}

# Elemento Option
function option($option, $value) {
    echo '<option value="' . $value . '">' . $option . '</option>';
}

# Elemento Button
function button($text, $id) {
    echo '<button type="submit" name="' . $id . '" id="'. $id . '" value="'. $text . '" class="btn form-btn form-control">' . $text . '</button>';
}

# Elemento A (Link)
function a($text, $url) {
    echo '<a href="' . $url . '" class="a-link">' . $text . '</a>';
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

# Grupo de formulario (Input)
function form_input($label, $type, $id, $cols, $placeholder = "", $pattern = "") {
    echo '<div class="form-group' . (($cols < 1 || $cols > 12) ? '' : (' col-md-' . $cols)) . '">';
    label($label, $id);
    input($label, $type, $id, $placeholder, $pattern);
    if($type === 'password') {
        checkbox('Revelar', $id, "reveal_password('" . $id . "')");
    }
    echo '</div>';
}

# Grupo de formulario (Select)
function form_select($label, $id, $options, $values = []) {
    if(count($options) > 0) {
        echo '<div class="form-group' . (($cols < 1 || $cols > 12) ? '' : (' col-md-' . $cols)) . '">';
        if(count($values) == 0) {
            $values = $option;
        }
        label($label, $id);
        echo '<select name="' . $id . '" id="' . $id . '" class="form-control">';
        for($i = 0; $i < count($options); $i++) {
            option($options[$i], $values[$i]);
        }
        echo '</select></div>';
    }
}

# Grupo de formulario (Select) (Toma el resultado de una query para definir las opciones)
function form_select_query($label, $id, $cols, $query, $option_id, $value_id) {
    if($query->num_rows > 0) {
        echo '<div class="form-group' . (($cols < 1 || $cols > 12) ? '' : (' col-md-' . $cols)) . '">';
        label($label, $id);
        echo '<select name="' . $id . '" id="' . $id . '" class="form-control">';
        for($i = 0; $i < $query->num_rows; $i++) {
            $result = $query->fetch_array();
            option($result[$option_id], $result[$value_id]);
            }
        echo '</select>';
        echo '</div>';
    }
}

// ↑-↑ Elementos de formulario //
// ↓-↓ Elementos de navbar //

# Logo (ancho y alto variable)
function shopping_logo(float $width, float $height = -1) {
    if($height > 0) {
        echo '<a class="navbar-brand" href="index.php"><img src="./images/logo.png" width="'.$width.'px" height="'.$height.'px"></a>';
    } else {
        echo '<a class="navbar-brand" href="index.php"><img src="./images/logo.png" width="'.$width.'px"></a>';

    }
}

# Crea un elemento link para la navbar
function navbar_item($label, $link, $active) {
    echo '<li class="nav-item';
    echo $active ? 'active">' : '">';
    echo '<a class="nav-link" href="' . $link . '">' . $label . '</a>';
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

# Breadcrumbs
function breadcrumbs(array $labels, array $links) {

}

// ↑-↑ Elementos de navbar //
// ↓-↓ Alertas y notificaciones //

# Alertas
function alert(string $type, string $text) {
    echo '<div class="alert alert-'. $type . '" role="alert">';
    echo $text;
    echo '</div>';
}

// ↑-↑ Alertas y notificaciones //
// ↓-↓ Locales //

# Elemento Local
function local_item($local) {
    button($local, 'local');
}

?>
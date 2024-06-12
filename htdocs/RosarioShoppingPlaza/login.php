<?php session_start();  # Iniciar/Reanudar sesión
if (isset($_SESSION["logged"])) {
    header('Location: index.php');  # Redireccionar a la página principal en caso de estar logeado
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosario Shopping Plaza</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login_signup.css">
</head>
<body>
    <?php include('components.php');    # Incluir librería de componentes
    shopping_logo(50);
    ?>
    <div class="login_signup_container">
        <h1>Iniciar sesión</h1>
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
            <?php

            input_field("Email", "email", "email", "Ingrese su email", "[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$");
            
            echo '<br><br>';
            
            input_field("Contraseña", "password", "pass", "Ingrese su contraseña");
            
            echo '<br>';
            
            checkbox("Mostrar contraseña", "show_pass", "reveal_password()");

            echo '<br><br>';

            button("Ingresar", "login")

            ?>
        </form>
        <br>
        <?php
        p_a_p("Recuperar contraseña", "#");
        p_a_p("Registrate", "signup.php", "¿No tienes una cuenta? ");

        # Si el formulario ha sido enviado se ejecuta lo siguiente
        if(isset($_POST["login"])) {
            include('db_utility.php');
            $query = get_user($_POST["email"]);
        
            if ($query->num_rows == 0) {
                echo "No se ha encontrado un usuario con ese email";
            } else {
                $row = $query->fetch_array();
                if ($row["claveUsuario"] === $_POST["pass"]) { 
                    $_SESSION["logged"] = true;
                    $_SESSION["f_name"] = $row["nombreUsuario"];
                    $_SESSION["l_name"] = $row["apellidoUsuario"];
                    $_SESSION["userType"] = $row["tipoUsuario"];
                    if ($_SESSION["userType"] == 3) {
                        $_SESSION["category"] = $row["categoriaCliente"];
                    }
                    header("Location: index.php");
                    exit;
                } else {
                    echo "Contraseña incorrecta";
                }
            }
        }
        ?>
    </div>
    <!-- Script en JS para mostrar y ocultar el campo contraseña -->
    <script>
        function reveal_password()
        {
            let x = document.getElementById("pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
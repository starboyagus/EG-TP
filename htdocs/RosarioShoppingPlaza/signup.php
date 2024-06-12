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
    <!--<link rel="stylesheet" href="styles/login_signup.css">-->
</head>
<body>
    <?php include('components.php');    # Incluir librería de componentes

    echo '<nav class="navbar navbar-expand">';
    shopping_logo(50);
    echo '</nav>';

    # Si el formulario ha sido enviado se ejecuta lo siguiente
    if(isset($_POST["signup"])) {
        if(!($_POST["pass"] === $_POST["rep_pass"])) {
            alert("warning", "Las contraseñas ingresadas no coinciden");
        } else {
            include('db_utility.php');
            if(!user_exists($_POST["email"])) {
                new_user($_POST["f_name"], $_POST["l_name"], $_POST["email"], $_POST["pass"]);
                alert("success", "Tu cuenta ha sido creada con éxito.");
            } else {
                alert("warning", "El mail ya se encuentra registrado");
            }
        }
    }
    ?>
    <div class="form-container form-container-signup">
        <h1>Registrarse</h1>
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
            <?php
            echo '<div class="form-row">';
            form_input("Nombre", "text", "f_name", 6, "Nombre");
            form_input("Apellido", "text", "l_name", 6, "Apellido");
            echo '</div>';
            
            form_input("Email", "email", "email", 0, "ejemplo@ejemplo.com", "[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$");

            echo '<div class="form-row">';
            form_input("Contraseña", "password", "pass", 6, "Contraseña");
            form_input("Confirmar contraseña", "password", "rep-pass", 6, "Repetir Contraseña");
            echo '</div>';

            button("Registrarse", "signup")
            
            ?>
        </form>
        <br>
        <?php
        p_a_p("Inicia Sesión", "login.php", "¿Ya tienes una cuenta? ");
        ?>
    </div>
    <!-- Script en JS para mostrar y ocultar el campo contraseña -->
    <script>
        function reveal_password(id)
        {
            let x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
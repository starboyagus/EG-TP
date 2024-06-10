<?php session_start();
if (isset($_SESSION["logged"])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rosario Shopping Plaza</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="login_signup_container">
        <h1>Registrarse</h1>
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
            <?php include('components.php');

            input_field("Nombre", "text", "f_name", "Ingrese su nombre");
            
            echo '<br><br>';

            input_field("Apellido", "text", "l_name", "Ingrese su apellido");
            
            echo '<br><br>';
            
            input_field("Email", "email", "email", "Ingrese su email", "[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$");
            
            echo '<br><br>';

            input_field("Contraseña", "password", "pass", "Ingrese su contraseña");
            
            echo '<br><br>';

            input_field("Confirmar contraseña", "password", "rep_pass", "Repita su contraseña");
            
            echo '<br><br>';

            checkbox("Mostrar contraseña", "show_pass", "reveal_password()");

            echo '<br><br>';

            button("Registrarse", "signup")
            
            ?>
        </form>
        <br>
        <?php
        p_a_p("Inicia Sesión", "login.php", "¿Ya tienes una cuenta? ");
        ?>
        <br>
    </div>
    <script>
        function reveal_password()
        {
            let x = document.getElementById("rep_pass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
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
    <!-- Estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Kit de iconos -->
    <script src="https://kit.fontawesome.com/e94f1b6b83.js" crossorigin="anonymous"></script>
    <!-- Estilos propios -->
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <?php include('navbar.php');

    # Si el formulario ha sido enviado se ejecuta lo siguiente
    if(isset($_POST["signup"])) {
        extract($_POST);
        if(!($_POST["pass"] === $_POST["rep-pass"])) {
            ?>
            <div class="alert alert-warning" role="alert">
                Las contraseñas ingresadas no coinciden
            </div>
            <?php
        } else {
            include('db_connection.php');
            $query = "SELECT * FROM usuarios u WHERE u.emailUsuario='$email'";
            $result = mysqli_query($connection, $query);
            if($result->fetch_array()) {
                ?>
                <div class="alert alert-warning" role="alert">
                    El mail ya se encuentra registrado
                </div>
                <?php
            } else {
                $query = "INSERT
                          INTO usuarios(nombreUsuario, apellidoUsuario, emailUsuario, claveUsuario, tipoUsuario, categoriaCliente)
                          VALUES ('$f_name', '$l_name', '$email', '$pass', 3, 1)";
                mysqli_query($connection, $query);
                ?>
                <div class="alert alert-success" role="alert">
                    Tu cuenta ha sido creada con éxito
                </div>
                <?php
            }
        }
    }
    ?>

    <br>
    
    <div class="form-container form-container-signup ">
        <h1>Registrarse</h1>
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
            <!-- Campo Nombre -->
            <div class="col-6">
                <label for="f_name" class="form-label">Nombre</label>
                <input type="text" name="f_name" id="f_name" class="form-control" placeholder="Nombre">
            </div>

            <!-- Campo Apellido -->
            <div class="col-6">
                <label for="l_name" class="form-label">Apellido</label>
                <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Apellido">
            </div>

            <!-- Campo Email -->
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$">
            </div>

            <!-- Campo Contraseña -->
            <div class="col-6">
                <label for="pass" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña">
                    <div class="input-group-text">
                        <input type="checkbox" name="cb-pass" id="cb-pass" class="form-check-input mt-0" onclick="reveal_password('pass')">
                    </div>
                </div>
            </div>

            <!-- Campo Confirmar Contraseña-->
            <div class="col-6">
                <label for="pass" class="form-label">Confirmar contraseña</label>
                <div class="input-group">
                    <input type="password" name="rep-pass" id="rep-pass" class="form-control" placeholder="Repetir Contraseña">
                    <div class="input-group-text">
                        <input type="checkbox" name="cb-rep-pass" id="cb-rep-pass" class="form-check-input mt-0" onclick="reveal_password('rep-pass')">
                    </div>
                </div>
            </div>
            <div class="col-12">
            <button type="submit" name="signup" id="signup" class="btn form-control form-btn">Ingresar</button>
            </div>
        </form>
        <div class="mt-3 mb-0">¿Ya tienes una cuenta?<a href="login.php" class="a-link"> Inicia Sesión</a></div>
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
    <?php include('footer.php');
    ?>
</body>
</html>
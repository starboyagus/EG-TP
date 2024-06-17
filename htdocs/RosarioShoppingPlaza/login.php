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
    if(isset($_POST["login"])) {
        include('db_connection.php');
            $query = "SELECT * FROM usuarios u WHERE u.emailUsuario='" . $_POST['email'] . "'";
            $result = mysqli_query($connection, $query);
        if ($user = $result->fetch_array()) {
            if ($user["claveUsuario"] === $_POST["pass"]) { 
                $_SESSION["logged"] = true;
                $_SESSION["userId"] = $user["codUsuario"];
                $_SESSION["f_name"] = $user["nombreUsuario"];
                $_SESSION["l_name"] = $user["apellidoUsuario"];
                $_SESSION["userType"] = $user["tipoUsuario"];
                if ($_SESSION["userType"] == 3) {
                    $_SESSION["category"] = $user["categoriaCliente"];
                }
                header("Location: index.php");
                exit;
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    Contraseña incorrecta
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                No se ha encontrado un usuario con ese email
            </div>
            <?php
        }
    }
    ?>

    <br>
    <h1 class="form-header">Iniciar sesión</h1>
    <div class="container form-container" style="max-width:25em;">
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
            <!-- Campo Email -->
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="nombre@ejemplo.com" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$">
            </div>

            <!-- Campo Contraseña -->
            <div class="col-12">
                <div class="row">
                    <div class="col col-4">
                        <label for="pass" class="form-label">Contraseña</label>
                    </div>
                    <div class="col col-8">
                        <p class="text-end m-0"><a href="#" class="a-link"><small>Recuperar contraseña</small></a></p>
                    </div>
                </div>
                <div class="input-group">
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña">
                    <div class="input-group-text">
                        <input type="checkbox" name="cb-pass" id="cb-pass" class="form-check-input mt-0" onclick="reveal_password('pass')">
                    </div>
                </div>
            </div>

            <!-- Boton Submit -->
            <div class="col-12">
            <button type="submit" name="login" id="login" class="btn form-control form-btn">Ingresar</button>
            </div>
        </form>
        <div class="mt-2 mb-0">¿No tienes una cuenta? <a href="signup.php" class="a-link">Registrate</a></div>
    </div>
        
    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php session_start(); # Iniciar/Reanudar sesión ?>

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

    // Funcion para enviar Mail

    function enviarMAIL($f_name, $l_name, $mail, $tel, $msg){
        $needle = 'dueño';

        // Si contiene la palabra dueño salta error
        if (strpos($msg, $needle) !== false){
            ?>
            <div class="container form-container mt-4" style="max-width:32em">
                <h1>Detectamos un error</h1>
                <p>Detectamos que usted quiere inscribirse como dueño <br> 
                Para inscribirse como dueño tiene que ir a la siguiente pagina</p>
                <a class="btn form-btn form-control" href="locales_alta.php">Registrarse como dueño</a>
            </div>
        <?php
        }

        // Si no contiene, envia el mail
        else{
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From:". $f_name. " " . $l_name . "\r\n";
        //$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $to="agusdownbad@icloud.com";
        $subject="Solicitud de Contacto - Rosario Shopping Plaza";
        $body=  "Nombre: ". $f_name . " " . $l_name ."\n" . 
                "Mail: ".$mail."\n".
                "Telefono: ".$tel."\n".
                "Comentario: ". $msg;

        mail($to, $subject, $body, $headers);
        ?>
        <div class="container form-container mt-4" style="max-width:32em">
            <h1>Mail Enviado</h1>
            <p>El Mail fue enviado con exito! <br> 
            Recuerde que recibira una respuesta en las siguientes 48 horas</p>
            <a class="btn form-btn form-control" href="index.php">Volver a la pagina principal</a>
        </div>
        <?php
        return true;
        }
    }

    // Form de Contacto
    if(!isset($_POST['submit'])){
        ?>
        <br>
        <h1 class="form-header">Contactanos</h1>
        <div class="container form-container" style="max-width:70em;">
            <!-- Formulario -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row g-3">
                <!-- Campo Nombre -->
                <div class="col-6">
                    <label for="f_name" class="form-label">Nombre</label>
                    <input type="text" name="f_name" id="f_name" class="form-control" placeholder="Nombre" required>
                </div>

                <!-- Campo Apellido -->
                <div class="col-6">
                    <label for="l_name" class="form-label">Apellido</label>
                    <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Apellido" required>
                </div>

                <!-- Campo Email -->
                <div class="col-12">
                    <label for="mail" class="form-label">Email</label>
                    <input type="email" name="mail" id="mail" class="form-control" placeholder="Email" required>
                </div>

                <!-- Campo Telefono -->
                <div class="col-12">
                    <label for="tel" class="form-label">Telefono</label>
                    <input type="tel" name="tel" id="tel" placeholder="XXXX-XXXXXX" class="form-control" pattern="[0-9]{4}-[0-9]{6}" required>
                </div>

                <!-- Campo Mensaje -->
                <div class="col-12">
                    <label for="msg" class="form-label">Dejanos tu mensaje</label>
                    <textarea class="form-control form-textarea" name="msg" id="msg" placeholder="Mensaje" rows="10" required></textarea>
                </div>

                <!-- Boton Submit -->
                <div class="col-12">
                    <button type="submit" name="submit" class="btn form-control form-btn" for="btn-modal" >Enviar Mensaje</button>
                </div>
            </form>
        </div>
    <?php
    }
    
    // Variables para utilizar en la funcion
    else{
        $f_name = ucfirst($_POST['f_name']);
        $l_name = ucfirst($_POST['l_name']);
        $mail = $_POST['mail'];
        $tel = $_POST['tel'];
        $msg = ucfirst($_POST['msg']);

        enviarMAIL($f_name, $l_name, $mail, $tel, $msg);
    }
    
    include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
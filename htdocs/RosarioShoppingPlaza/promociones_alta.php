<?php session_start(); # Iniciar/Reanudar sesión

# Verifica que el usuario esté loggeado y sea administrador
if(!isset($_SESSION['userType']) || $_SESSION['userType'] != 2) {
    header('Location: locales.php');
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
    <?php
    include('navbar.php');

    $tools = 'admin_locales';
    include('tools.php');
    unset($tools);

    include('db_connection.php');

    if (isset($_POST["create-promocion"])) {
        extract($_POST);

        # Verificar que exista el local
        $query = "SELECT * FROM locales l WHERE l.codLocal='$local_id' AND l.codUsuario='" . $_SESSION['userId'] . "'";
        $result = mysqli_query($connection, $query);
        if ($result->fetch_array()) {
            $days = isset($day_1) ? "1" : "0";
            $days .= isset($day_2) ? "1" : "0";
            $days .= isset($day_3) ? "1" : "0";
            $days .= isset($day_4) ? "1" : "0";
            $days .= isset($day_5) ? "1" : "0";
            $days .= isset($day_6) ? "1" : "0";
            $days .= isset($day_7) ? "1" : "0";

            $query = "INSERT
                      INTO promociones(textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo, codLocal)
                      VALUES ('$promo_text', '$promo_from', '$promo_to', '$category', b'$days', '1', '$local_id')";
            $result = mysqli_query($connection, $query);

            ?>
            <div class="alert alert-success" role="alert">
                La solicitud de creación de promoción ha sido registrada correctamente
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                El código de Local "<?= $local_id; ?>" no existe o usted no es dueño de dicho Local
            </div>
            <?php
        }
    }
    ?>

    <br>
    <h1 class="form-header">Crear Promoción</h1>
    <div class="container form-container" style="max-width:70em;">
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
            <!-- Campo Codigo Local -->
            <div class="col-12 col-md-4">
                <label for="local_id" class="form-label">Código de Local</label>
                <input type="number" name="local_id" id="local_id" class="form-control" placeholder="Código de Local" min="0" required>
            </div>
            
            <!-- Campo Fecha Inicio -->
            <div class="col-12 col-sm-6 col-md-4">
                <label for="promo_from" class="form-label">Desde</label>
                <input type="date" name="promo_from" id="promo_from" class="form-control" value="<?= date("Y-m-d");?>" min="<?= date("Y-m-d");?>" required>
            </div>

            <!-- Campo Fecha Fin -->
            <div class="col-12 col-sm-6 col-md-4">
                <label for="promo_to" class="form-label">Hasta</label>
                <input type="date" name="promo_to" id="promo_to" class="form-control" value="<?= date("Y-m-d");?>" min="<?= date("Y-m-d");?>" required>
            </div>

            <!-- Campo Categoría Cliente -->
            <div class="col-12 col-lg-4">
                <label for="category" class="form-label">Categoría&nbsp;&nbsp;&nbsp;&nbsp;</label>
                
                <br>

                <input type="radio" name="category" id="client_category_1" class="btn-check" value="1" checked>
                <label class="btn btn-outline-inicial" for="client_category_1">Inicial</label>

                <input type="radio" name="category" id="client_category_2" class="btn-check" value="2">
                <label class="btn btn-outline-medium" for="client_category_2">Medium</label>

                <input type="radio" name="category" id="client_category_3" class="btn-check" value="3">
                <label class="btn btn-outline-premium" for="client_category_3">Premium</label>
            </div>

            <!-- Campo Días Semana -->
            <div class="col-12 col-lg-8">
                <label for="days" class="form-label">Días&nbsp;&nbsp;&nbsp;&nbsp;</label>
                
                <br>
                
                <?php
                $days = [1 => "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                foreach($days as $key => $value) {
                    ?>
                    <input type="checkbox" name="day_<?= $key;?>" id="day_<?= $key;?>" class="btn-check" value="<?= $key;?>">
                    <label class="btn btn-check-dia" for="day_<?= $key;?>"><?= $value;?></label>
                    <?php
                }
                unset($days);
                ?>
            </div>

            <div class="col-12">
            <label for="promo_text" class="form-label">Detalles de la promoción</label>
                <textarea name="promo_text" id="promo_text" class="form-control" rows="5"></textarea>
            </div>

            <!-- Boton Submit-->
            <div class="col-12">
                <button type="submit" name="create-promocion" id="create-promocion" class="form-control btn btn-local"><i class="fa-solid fa-plus"></i> Crear Promoción</button>
            </div>
        </form>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
    
    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
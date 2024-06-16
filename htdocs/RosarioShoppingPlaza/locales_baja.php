<?php session_start(); # Iniciar/Reanudar sesión

# Verifica que el usuario esté loggeado y sea administrador
if(!isset($_SESSION['userType']) || $_SESSION['userType'] != 1) {
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

    $tools = 'locales';
    include('admin_tools.php');
    unset($tools);

    include('db_connection.php');

    $search = true;

    if (isset($_GET['id'])) {
        $local_id = $_GET['id'];
        $query = "SELECT * FROM locales l WHERE l.codLocal=$local_id";
        $result = mysqli_query($connection, $query);
        if($local = $result->fetch_array()) {
            $search = false;
            $result = mysqli_query($connection, "SELECT * FROM rubros_local");

            if(isset($_GET['error'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                    El código de usuario "<?= $_GET['error']; ?>" no pertenece a un dueño
                </div>
                <?php
            }
            ?>

            <br>
            <h1 class="form-header">Eliminar Local</h1>
            <div class="container form-container" style="max-width:70em;">
                <!-- Formulario -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
                    <!-- Campo Código de Local -->
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                        <label for="local_id" class="form-label">Código de Local</label>
                        <input type="number" name="local_id" id="local_id" class="form-control" value="<?= $local_id; ?>" readonly>
                    </div>

                    <!-- Campo Codigo Dueño -->
                    <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                        <label for="owner" class="form-label">Código de Dueño</label>
                        <input type="number" id="owner" class="form-control" value="<?= $local['codUsuario']; ?>" readonly>
                    </div>

                    <!-- Campo Nombre Local -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="local_name" class="form-label">Nombre del Local</label>
                        <input type="text" id="local_name" class="form-control" value="<?= $local['nombreLocal']; ?>" readonly>
                    </div>

                    <!-- Campo Ubicación -->
                    <div class="col-12 col-md-6 col-lg-2">
                        <label for="local_ubi" class="form-label">Ubicación</label>
                        <input type="text" id="local_ubi" class="form-control" value="<?= $local['ubicacionLocal']; ?>" readonly>
                    </div>

                    <!-- Campo Rubro -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="category" class="form-label">Rubro</label>
                        <input type="text" id="category" class="form-control" value="<?= $local['rubroLocal']; ?>" readonly>
                    </div>
                        
                    <!-- Boton Submit-->
                    <div class="col-12">
                        <button type="submit" name="delete-local" id="delete-local" class="form-control btn btn-danger"><i class="fa-regular fa-trash-can"></i> Eliminar Local</button>
                    </div>
                </form>
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                No existe un local con el id "<?= $_GET['id']?>"
            </div>
            <?php
        }
    } else if(isset($_POST['delete-local'])) {
        extract($_POST);
        $query = "DELETE FROM locales WHERE codLocal='$local_id'";
        $result = mysqli_query($connection, $query);
        ?>
        <div class="alert alert-success" role="alert">
            El local "<?= $local_id; ?>" se ha eliminado correctamente
        </div>
        <?php
    }

    if ($search) {
    ?>

    <br>
    <h1 class="form-header">Buscar un Local</h1>
    <div class="container form-container" style="max-width:20em;">
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="GET" class="row g-3">
            <!-- Campo Codigo Local -->
            <div class="col-12">
                <label for="id" class="form-label">Código de Local</label>
                <input type="number" name="id" id="id" class="form-control" placeholder="Código de Local" min="0" required>
            </div>

            <!-- Boton Submit-->
            <div class="col-12">
                <button type="submit" id="search-local" class="form-control btn btn-local"><i class="fa-solid fa-trash-glass"></i> Buscar Local</button>
            </div>
        </form>
    </div>

    <?php } ?>
    
    <br><br><br><br><br><br><br><br><br><br>
    
    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
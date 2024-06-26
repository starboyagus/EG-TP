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

    $tools = 'admin_locales';
    include('tools.php');
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
        } else {
            mysqli_free_result($result);
            ?>
            <div class="alert alert-warning" role="alert">
                No existe un local con el id "<?= $_GET['id']?>"
            </div>
            <?php
        }
    } else if(isset($_POST['update-local'])) {
        extract($_POST);
        $query = "SELECT * FROM usuarios u WHERE u.codUsuario='$owner' AND u.tipoUsuario=2";
        $result = mysqli_query($connection, $query);
        if ($result->fetch_array()) {
            mysqli_free_result($result);
            $query = "UPDATE locales SET nombreLocal='$local_name', ubicacionLocal='$local_ubi', rubroLocal='$category', codUsuario='$owner' WHERE codLocal='$local_id'";
            mysqli_query($connection, $query);
            ?>
            <div class="alert alert-success" role="alert">
                El local "<?= $local_id; ?>" se ha modificado correctamente
            </div>
            <?php
        } else {
            $search = false;
            $local = [
                'nombreLocal' => $local_name,
                'ubicacionLocal' => $local_ubi,
                'rubroLocal' => $category,
                'codUsuario' => $owner
            ];
            $result = mysqli_query($connection, "SELECT * FROM rubros_local");
            ?>
            <div class="alert alert-danger" role="alert">
                El código de usuario "<?= $owner; ?>" no existe o no pertenece a un dueño
            </div>
            <?php
        }
        
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
                <button type="submit" id="search-local" class="form-control btn btn-local"><i class="fa-solid fa-magnifying-glass"></i> Buscar Local</button>
            </div>
        </form>
    </div>

    <?php } else { ?>

        <br>
        <h1 class="form-header">Modificar Local</h1>
        <div class="container form-container" style="max-width:70em;">
            <!-- Formulario -->
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
                <!-- Campo Código de Local -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label for="local_id" class="form-label">Código de Local</label>
                    <input type="number" name="local_id" id="local_id" class="form-control" placeholder="Nombre del Local" min="0" value="<?= $local_id; ?>" readonly>
                </div>
                
                <!-- Campo Codigo Dueño -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <label for="owner" class="form-label">Código de Dueño</label>
                    <input type="number" name="owner" id="owner" class="form-control" placeholder="Código de Dueño" min="0" value="<?= $local['codUsuario']; ?>" required>
                </div>
                
                <!-- Campo Nombre Local -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="local_name" class="form-label">Nombre del Local</label>
                    <input type="text" name="local_name" id="local_name" class="form-control" placeholder="Nombre del Local" value="<?= $local['nombreLocal']; ?>" required>
                </div>
                
                <!-- Campo Ubicación -->
                <div class="col-12 col-md-6 col-lg-2">
                    <label for="local_ubi" class="form-label">Ubicación</label>
                    <select name="local_ubi" id="local_ubi" class="form-select">
                        <option <?= $local['ubicacionLocal'] == "Planta baja" ? "selected" : ""; ?>>Planta baja</option>
                        <option <?= $local['ubicacionLocal'] == "Piso 1" ? "selected" : ""; ?>>Piso 1</option>
                        <option <?= $local['ubicacionLocal'] == "Piso 2" ? "selected" : ""; ?>>Piso 2</option>
                        <option <?= $local['ubicacionLocal'] == "Piso 3" ? "selected" : ""; ?>>Piso 3</option>
                    </select>
                </div>
                
                <!-- Campo Rubro -->
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="category" class="form-label">Rubro</label>
                    <select name="category" id="category" class="form-select">
                        <?php
                        while($row = mysqli_fetch_assoc($result)) { 
                            ?>
                            <option value="<?= $row['codRubro']; ?>" <?= $row['codRubro'] == $local['rubroLocal'] ? "selected" : ""; ?>><?= $row['nombreRubro']; ?></option>
                            <?php
                        }
                        mysqli_free_result($result);
                        ?>
                    </select>
                </div>
                    
                <!-- Boton Submit-->
                <div class="col-12">
                    <button type="submit" name="update-local" id="update-local" class="form-control btn btn-local"><i class="fa-regular fa-pen-to-square"></i> Modificar Local</button>
                </div>
            </form>
        </div>

    <?php
    } 
    mysqli_close($connection);
    ?>
    
    <br><br><br><br><br><br><br><br><br><br>
    
    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
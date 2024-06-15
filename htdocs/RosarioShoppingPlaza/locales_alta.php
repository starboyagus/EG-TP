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

    if (isset($_POST["create-local"])) {
        extract($_POST);
    
        # Verificar que exista el dueño
        $query = "SELECT * FROM usuarios u WHERE u.codUsuario='$owner' AND u.tipoUsuario=2";
        $result = mysqli_query($connection, $query);
        if ($result->fetch_array()) {
            $query = "INSERT
                      INTO locales(nombreLocal, ubicacionLocal, rubroLocal, codUsuario)
                      VALUES ('$local_name', '$local_ubi', '$category', '$owner')";
            mysqli_query($connection, $query);
            ?>
            <div class="alert alert-success" role="alert">
                El local ha sido creado con éxito
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-danger" role="alert">
                No se ha encontrado un dueño con ese código
            </div>
            <?php
        }
        mysqli_free_result($result);
    
        
    }

    $result = mysqli_query($connection, "SELECT * FROM rubros_local");
    ?>
    <br>
    <h1 class="form-header">Crear Local</h1>
    <div class="container form-container" style="max-width:40em;">
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="row g-3">
            <!-- Campo Nombre Local -->
            <div class="col-6">
                <label for="local_name" class="form-label">Nombre del Local</label>
                <input type="text" name="local_name" id="local_name" class="form-control" placeholder="Nombre del Local">
            </div>
            
            <!-- Campo Codigo Dueño -->
            <div class="col-6">
                <label for="owner" class="form-label">Código de Dueño</label>
                <input type="number" name="owner" id="owner" class="form-control" placeholder="Código de Dueño" min="0">
            </div>

            <!-- Campo Ubicación -->
            <div class="col-6">
                <label for="local_ubi" class="form-label">Ubicación</label>
                <select name="local_ubi" id="local_ubi" class="form-select">
                    <option>Planta baja</option>
                    <option>Piso 1</option>
                    <option>Piso 2</option>
                    <option>Piso 3</option>
                </select>
            </div>

            <!-- Campo Rubro -->
            <div class="col-6">
                <label for="category" class="form-label">Rubro</label>
                <select name="category" id="category" class="form-select">
                    <?php
                    while($row = mysqli_fetch_assoc($result)) { 
                        ?>
                        <option value="<?= $row['codRubro']; ?>"><?= $row['nombreRubro']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <!-- Boton Submit-->
            <div class="col-12">
                <button type="submit" name="create-local" id="create-local" class="form-control btn btn-create-local"><i class="fa-solid fa-hammer"></i> Crear Local <i class="fa-solid fa-hammer"></i></button>
            </div>
        </form>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
    <?php
    include('footer.php');
    ?>
</body>
</html>
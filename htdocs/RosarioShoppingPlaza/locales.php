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
    include('db_connection.php');
    

    # Verifica si se encuentra la id de algún local en la URL
    if(isset($_GET['id'])) { # Si la encuentra
        $query = "SELECT * FROM locales l WHERE l.codLocal='" . $_GET['id'] . "'";
        $result = mysqli_query($connection, $query);
        $local = mysqli_fetch_array($result);
        ?>
        <p>
            <?= $local['nombreLocal']; ?> <br>
            <?= $local['ubicacionLocal']; ?> <br>
            <?= $local['rubroLocal']; ?>
        </p>
        <?php
    } else { # Sino
        if(isset($_GET['category'])){
            $query = "SELECT * FROM locales l WHERE l.rubroLocal='" . $_GET['category'] . "'";
        } else {
            $query = "SELECT * FROM locales";
        }
        $result = mysqli_query($connection, $query);
        ?> <div class="abc row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-4"> <?php
        while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col">
                <div class="card m-1">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nombreLocal']; ?></h5>
                        <a href="locales.php?<?= SID; ?>&id=<?= $row['codLocal']; ?>" class="btn btn-primary">Info del local</a>
                        <a href="locales.php?<?= SID; ?>&id=<?= $row['codLocal']; ?>" class="btn btn-primary"><i class="fa-solid fa-tags"></i> Promociones</a>
                    </div>
                </div>
            </div>
        <?php }
        ?> </div> <?php
    }
    mysqli_free_result($result);

    # Verifica si el usuario está loggeado y es administrador
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) {
        $result = mysqli_query($connection, "SELECT * FROM rubros_local");
        ?>
        <br>
        
        <div class="form-container form-container-local">        
            <h1>Crear Local</h1>
            <form action="locales_alta.php" method="POST" class="row g-3">
                <div class="col-11">
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nombre del Local">
                            <label for="name" class="placeholder-label">Nombre del Local</label>
                        </div>
                        <select name="ubi" id="ubi" class="form-select">
                            <option>Nivel 1</option>
                            <option>Nivel 2</option>
                            <option>Nivel 3</option>
                        </select>
                        <select name="category" id="category" class="form-select">
                            <?php
                            while($row = mysqli_fetch_assoc($result)) { 
                                ?>
                                <option value="<?= $row['codRubro']; ?>"><?= $row['nombreRubro']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="form-floating">
                            <input type="text" name="owner" id="owner" class="form-control" placeholder="Código de Dueño">
                            <label for="name" class="placeholder-label">Código de Dueño</label>
                        </div>
                    </div>
                </div>
                <div class="col-1">
                    <button type="submit" name="create-local" id="create-local" class="form-control btn btn-create-local"><i class="fa-solid fa-hammer"></i></button>
                </div>
            </form>
        </div>
    <?php
    mysqli_close($connection);
    }
    ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


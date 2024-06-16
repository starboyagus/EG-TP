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

    $tools = 'admin_locales';
    include('tools.php');
    unset($tools);

    include('db_connection.php');
    extract($_GET);

    $query = "SELECT * FROM rubros_local";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $rubros[$row['codRubro']] = $row['nombreRubro'];
    }
    mysqli_free_result($result);

    # Verifica si se encuentra la id de algún local en la URL
    if(isset($id)) { # Si la encuentra
        $query = "SELECT * FROM locales l WHERE l.codLocal='$id'";
        $result = mysqli_query($connection, $query);
        $local = mysqli_fetch_array($result);
        ?>
        <br>
        <div class="container">
            <div class="row g-4">
                <div class="col">
                    <div class="card m-1">
                        <div class="card-header" style="text-align: center;">
                            <img src="images/logo.png" class="img-fluid rounded-top" style="max-width:200px; margin:0 auto;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $local['nombreLocal']; ?></h5>
                            <p class="card-text m-0"><small><i>
                                <?= $rubros[$local['rubroLocal']]; ?>
                            </i></small></p>
                            <p class="card-text mb-2"><small><i>
                                <?= $local['ubicacionLocal']; ?> - Local <?= $local['codLocal']; ?>
                            </i></small></p>
                            <a href="locales.php?<?= SID; ?>&id=<?= $id; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-tags"></i> Promociones</a>
                            <?php
                            if (isset($_SESSION['userType']) && $_SESSION['userType'] == 1) {
                                ?>
                                    <a href="locales_baja.php?<?= SID; ?>&id=<?= $id; ?>" class="btn btn-danger btn-sm"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
                                    <a href="locales_modificacion.php?<?= SID; ?>&id=<?= $id; ?>" class="btn btn-local btn-sm"><i class="fa-regular fa-pen-to-square"></i> Modificar</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
        mysqli_free_result($result);
    } else { # Sino
        if(!isset($order)) {
            $order = "ASC";
        }

        if(isset($category)){
            $query = "SELECT * FROM locales l WHERE l.rubroLocal='$category' ORDER BY nombreLocal $order";
        } else {
            $query = "SELECT * FROM locales ORDER BY nombreLocal $order";
        }
        
        $result = mysqli_query($connection, $query);
        ?> <div class="card-container row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4"> <?php
        while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col">
                <div class="card m-1">
                    <img src="images/logo.png" class="img-fluid rounded-top">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['nombreLocal']; ?></h5>
                        <p>
                            <?= $rubros[$row['rubroLocal']]; ?> <br>
                            <?= $row['ubicacionLocal']; ?> <br>
                        </p>
                        <a href="locales.php?<?= SID; ?>&id=<?= $row['codLocal']; ?>" class="btn btn-primary btn-sm">Más info</a>
                        <a href="locales.php?<?= SID; ?>&id=<?= $row['codLocal']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-tags"></i></a>
                    </div>
                </div>
            </div>
        <?php }
        ?> </div> <?php
        mysqli_free_result($result);
    }
    mysqli_close($connection);
    ?>
    <br><br><br><br><br><br><br><br><br><br>
    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


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
    <?php include('navbar.php');

    $tools = 'locales';
    include('admin_tools.php');
    unset($tools);

    include('db_connection.php');

    $query = "SELECT * FROM rubros_local";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $categories[$row['codRubro']] = $row['nombreRubro']; # Creamos un array con todos los rubros
    }

    $query = "SELECT * FROM usuarios u WHERE u.tipoUsuario=2";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $owners[$row['codUsuario']] = $row['nombreUsuario']; # Creamos un array con todos los dueños
    }

    $num_per_page = 10; # Cantidad de locales que se mostrarán por página
    $page = isset( $_GET['page']) ? $_GET['page'] : null; # Página en la que me encuentro
    if (!$page) {
        $start = 0; # Primer local a mostrar
        $page = 1;  # Página en la que me encuentro
    }
    else {
        $start = ($page - 1) * $num_per_page; # Primer local a mostrar
    } 

    $query = "SELECT * FROM locales";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result); # Cantidad de locales en la base de datos
    $num_pages = ceil($num_rows / $num_per_page); # Cantidad de páginas

    $query = "SELECT * FROM locales LIMIT $start , $num_per_page";
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result); # Cantidad de locales para mostrar en la página actual
    
    
    ?>
    <br>

    <h1>Listado de Locales</h1>
    <div class="container table-container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Cod</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ubicación</th>
                    <th scope="col">Rubro</th>
                    <th scope="col">Dueño</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <th scope="row"><?= $row['codLocal']; ?></th>
                        <td><?= $row['nombreLocal']; ?></td>
                        <td><?= $row['ubicacionLocal']; ?></td>
                        <td><?= $categories[$row['rubroLocal']]; ?></td>
                        <td><?= $owners[$row['codUsuario']]; ?></td>
                        <td>
                            <a href="locales_modificacion.php?<?= SID ?>local=<?= $row['codLocal']; ?>" class="btn btn-primary">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td>
                            <a href="locales_baja.php?<?= SID ?>local=<?= $row['codLocal']; ?>" class="btn btn-danger">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br>
        <nav>
            <ul class="pagination">
                <!-- Ir a la primer página -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=1" class="page-link <?= $page == 1 ? 'disabled' : ''?>"><i class="fa-solid fa-angles-left"></i></a>
                </li>

                <!-- Ir a la página anterior -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $page-1 ?>" class="page-link <?= $page == 1 ? 'disabled' : ''?>"><i class="fa-solid fa-angle-left"></i></a>
                </li>
                
                <!-- Ir a la página $i -->
                <?php
                for($i = 1; $i <= $num_pages; $i++) {
                        ?>
                        <li class="page-item">
                            <a href="locales_listado.php?<?= SID ?>page=<?= $i ?>" class="page-link <?= $page == $i ? 'disabled' : ''?>"><?= $i ?></a>
                        </li>
                        <?php
                    }
                ?>

                <!-- Ir a la página siguiente -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $page+1 ?>" class="page-link <?= $page == $num_pages ? 'disabled' : ''?>"><i class="fa-solid fa-angle-right"></i></a>
                </li>

                <!-- Ir a la última página -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $num_pages ?>" class="page-link <?= $page == $num_pages ? 'disabled' : ''?>"><i class="fa-solid fa-angles-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
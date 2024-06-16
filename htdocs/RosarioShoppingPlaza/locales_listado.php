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

    $tools = 'admin_locales';
    include('tools.php');
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

    $num_per_page = isset($_GET['n']) ? $_GET['n'] : 10; # Cantidad de locales que se mostrarán por página
    $num_per_page = match ($num_per_page) {
        '10', '25', '50', '100' => (int)$num_per_page,   # Si la cantidad que se mostrará por página es alguna de estas, está todo correcto
        default => 10                       # Si es un número distinto, es incorrecto y se toma por defecto 10
    };

    $page = isset($_GET['page']) ? $_GET['page'] : null; # Página en la que me encuentro
    if (!$page) {
        $start = 0; # Primer local a mostrar
        $page = 1;  # Página en la que me encuentro
    }
    else {
        $start = ($page - 1) * $num_per_page; # Primer local a mostrar
    }

    $by = isset($_GET['by']) ? $_GET['by'] : 0; # Campo por el que se ordenará la lista
    $order = isset($_GET['order']) ? $_GET['order'] : "asc"; # Criterio de orden
    $by_col = match ($by) {
        '1' => "codLocal",
        '2' => "nombreLocal",
        '3' => "ubicacionLocal",
        '4' => "rubroLocal",
        '5' => "codUsuario",
        default => null
    };

    $query = "SELECT * FROM locales";
    $result = mysqli_query($connection, $query);
    $num_registers = mysqli_num_rows($result); # Cantidad de locales en la base de datos
    $num_pages = ceil($num_registers / $num_per_page); # Cantidad de páginas

    if ($by_col) {
        $query = "SELECT * FROM locales ORDER BY $by_col $order LIMIT $start , $num_per_page";
    } else {
        $query = "SELECT * FROM locales LIMIT $start , $num_per_page";
    }
    $result = mysqli_query($connection, $query);
    $num_rows = mysqli_num_rows($result); # Cantidad de locales para mostrar en la página actual
    
    ?>
    <br>

    <div class="container table-container">
        <h1>Listado de Locales</h1>
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr class="align-middle">
                    <?php
                    $ths = [1 => "Codigo", "Nombre", "Ubicación", "Rubro", "Dueño"];
                    foreach ($ths as $key => $value) {
                    ?>
                        <!-- Encabezado $ths[$key] con filtro -->
                        <th scope="col" class="text-center"> <?= $value; 
                            if ($by == $key) {
                                if ($order == "asc") {
                                    ?>
                                    <a href="locales_listado.php?<?= SID ?>page=<?= $page; ?>&n=<?= $num_per_page; ?>&order=<?= "desc"; ?>&by=<?= $key; ?>">
                                    <small><i class="fa-solid fa-sort-up" style="color:black;"></i></small>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="locales_listado.php?<?= SID ?>page=<?= $page; ?>&n=<?= $num_per_page; ?>&order=<?= "asc"; ?>&by=0">
                                    <small><i class="fa-solid fa-sort-down" style="color:black;"></i></small>
                                    </a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="locales_listado.php?<?= SID ?>page=<?= $page; ?>&n=<?= $num_per_page; ?>&order=<?= "asc"; ?>&by=<?= $key; ?>">
                                        <small><i class="fa-solid fa-sort" style="color:black;"></i></small>
                                    </a>
                            <?php }
                            ?>
                        </th>
                    <?php
                    }
                    ?>
                    <th scope="col" class="text-center">Modificar</th>
                    <th scope="col" class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                    while($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $row['codLocal']; ?></th>
                        <td><?= $row['nombreLocal']; ?></td>
                        <td><?= $row['ubicacionLocal']; ?></td>
                        <td><?= $categories[$row['rubroLocal']]; ?></td>
                        <td><?= $owners[$row['codUsuario']]; ?></td>
                        <td class="text-center" width="90px">
                            <a href="locales_modificacion.php?<?= SID ?>id=<?= $row['codLocal']; ?>" class="btn btn-primary btn-sm">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td class="text-center" width="90px">
                            <a href="locales_baja.php?<?= SID ?>id=<?= $row['codLocal']; ?>" class="btn btn-danger btn-sm">
                                <i class="fa-regular fa-trash-can"></i>    
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div class="row">
            <p class="col text-start">
                Ver:
                <a href="locales_listado.php?<?= SID ?>page=1&n=10&order=<?= $order; ?>&by=<?= $by; ?>" class="a-link">10</a>
                <a href="locales_listado.php?<?= SID ?>page=1&n=25&order=<?= $order; ?>&by=<?= $by; ?>" class="a-link">25</a>
                <a href="locales_listado.php?<?= SID ?>page=1&n=50&order=<?= $order; ?>&by=<?= $by; ?>" class="a-link">50</a>
                <a href="locales_listado.php?<?= SID ?>page=1&n=100&order=<?= $order; ?>&by=<?= $by; ?>" class="a-link">100</a>
            </p>
            <p class="col text-end"><small>Mostrando <?= $start + 1 . "-" . $start + $num_rows . " de " . $num_registers; ?></small></p>
        </div>
        <nav>
            <ul class="pagination pagination-sm justify-content-center">
                <!-- Ir a la primer página -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=1&n=<?= $num_per_page; ?>&order=<?= $order; ?>&by=<?= $by; ?>" class="page-link <?= $page == 1 ? 'disabled' : ''?>"><i class="fa-solid fa-angles-left"></i></a>
                </li>

                <!-- Ir a la página anterior -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $page-1 ?>&n=<?= $num_per_page; ?>&order=<?= $order; ?>&by=<?= $by; ?>" class="page-link <?= $page == 1 ? 'disabled' : ''?>"><i class="fa-solid fa-angle-left"></i></a>
                </li>
                
                <!-- Ir a la página $i -->
                <?php
                for($i = 1; $i <= $num_pages; $i++) {
                        ?>
                        <li class="page-item">
                            <a href="locales_listado.php?<?= SID ?>page=<?= $i ?>&n=<?= $num_per_page; ?>&order=<?= $order; ?>&by=<?= $by; ?>" class="page-link <?= $page == $i ? 'active' : ''?>"><?= $i ?></a>
                        </li>
                        <?php
                    }
                ?>

                <!-- Ir a la página siguiente -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $page+1 ?>&n=<?= $num_per_page; ?>&order=<?= $order; ?>&by=<?= $by; ?>" class="page-link <?= $page == $num_pages ? 'disabled' : ''?>"><i class="fa-solid fa-angle-right"></i></a>
                </li>

                <!-- Ir a la última página -->
                <li class="page-item">
                    <a href="locales_listado.php?<?= SID ?>page=<?= $num_pages ?>&n=<?= $num_per_page; ?>&order=<?= $order; ?>&by=<?= $by; ?>" class="page-link <?= $page == $num_pages ? 'disabled' : ''?>"><i class="fa-solid fa-angles-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
    <?php include('footer.php'); ?>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
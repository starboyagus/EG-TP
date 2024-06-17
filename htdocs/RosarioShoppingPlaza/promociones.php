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

    $tools = 'owner_promociones';
    include('tools.php');
    unset($tools);

    include('db_connection.php');

    ?>

    <div class="container">
        <div class="row g-4">
            <?php
            $query = "SELECT * FROM promociones";
            $result = mysqli_query($connection, $query);
            $i = 0;
            while ($promo = mysqli_fetch_assoc($result)) {
                $dayBits = str_split(str_pad(decbin($promo['diasSemana']), 7, "0", STR_PAD_LEFT));
                $days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                foreach ($dayBits as $key => $value) { 
                    if($value == '0') {
                        unset($days[$key]);
                    }
                }
                ?>
                <div class="col col-12">
                    <div class="card mt-4">
                      <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h5 class="card-title"><?= mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM locales l WHERE l.codLocal='" . $promo['codLocal'] . "'"))['nombreLocal']; ?></h5>
                            </div>
                            <div class="col-12 col-sm-6 text-sm-end">
                                <?php
                                switch($promo['categoriaCliente']) {
                                    case '1':
                                        ?>
                                        <span class="badge badge-inicial"><a href="#" class="badge-text">Inicial</a></span>
                                        <?php
                                        break;
                                    case '2':
                                        ?>
                                        <span class="badge badge-medium"><a href="#" class="badge-text">Medium</a></span>
                                        <?php
                                        break;
                                    case '3':
                                        ?>
                                        <span class="badge badge-premium"><a href="#" class="badge-text">Premium</a></span>
                                        <?php
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Separador -->
                        <div class="text-center mt-3">
                            <a class="a-expand" data-bs-toggle="collapse" href="#card-text-<?= ++$i; ?>" role="button">
                                Ver detalles
                            </a>
                        </div>

                        <div class="collapse" id="card-text-<?= $i; ?>">
                            <hr style="color:var(--primary);">
                            <p class="card-text small mb-0">Días: <?= implode(", ", $days); ?></p>
                            <p class="card-text small">Desde <?= date("d/m/y", strtotime($promo['fechaDesdePromo'])); ?> - Hasta <?= date("d/m/y", strtotime($promo['fechaHastaPromo'])); ?></p>
                            <p class="card-text"><?= $promo['textoPromo']; ?></p>
                        </div>
                      </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <br><br><br><br><br><br><br><br><br><br>

    <?php include('footer.php'); ?>
    
    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
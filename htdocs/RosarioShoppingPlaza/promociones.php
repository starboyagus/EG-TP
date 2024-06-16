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

    ?>

    <div class="container">
        <div class="row g-4">
            <div class="col col-12">
                <div class="card mt-4">
                  <div class="card-body">
                    <h5 class="card-title">Nombre del Local</h5>
                    <span class="badge badge-inicial"><a href="#" class="badge-text">Inicial</a></span>
                    <span class="badge badge-medium"><a href="#" class="badge-text">Medium</a></span>
                    <span class="badge badge-premium"><a href="#" class="badge-text">Premium</a></span>
                    <br>
                    <div class="text-center mt-3">
                        <a class="a-expand" data-bs-toggle="collapse" href="#card-text" role="button">
                            Ver detalles
                        </a>
                    </div>
                    <div class="collapse" id="card-text">
                        <hr style="color:var(--primary);">
                        <p class="card-text small mb-0">Días [Lunes|Martes|Miércoles|Jueves|Viernes|Sábado|Domingo]</p>
                        <p class="card-text small">Desde xx/xx/xx - Hasta xx/xx/xx</p>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident at consequatur dolores quam iure dolore tenetur inventore repellendus pariatur aspernatur illum fugiat delectus fugit voluptates eos impedit quis, molestiae repudiandae corrupti facere repellat ipsum nesciunt unde amet? Ab iure dolorum natus deserunt amet sit quo aspernatur vitae dolore, molestias aperiam!</p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    
    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
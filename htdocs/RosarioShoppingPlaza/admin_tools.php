<?php
if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) {
    if ($tools == 'locales'){
        ?>
        <ul class="nav justify-content-end admin-tools py-1">
            <li class="nav-item">
                <a href="locales_alta.php" class="btn mx-1 btn-tool btn-sm"><i class="fa-solid fa-plus"></i> Alta</a>
            </li>
            <li class="nav-item">
                <a href="locales_baja.php" class="btn me-1 btn-tool btn-sm"><i class="fa-regular fa-trash-can"></i> Baja</a>
            </li>
            <li class="nav-item">
                <a href="locales_menu_modificacion.php" class="btn me-1 btn-tool btn-sm"><i class="fa-regular fa-pen-to-square"></i> Modificación</a>
            </li>
            <li class="nav-item">
                <a href="locales_listado.php" class="btn me-1 btn-tool btn-sm"><i class="fa-solid fa-list-ul"></i> Listado</a>
            </li>
        </ul>
        <?php
    }
}
?>
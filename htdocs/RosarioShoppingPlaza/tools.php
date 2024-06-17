<?php
// Admin Tools
if(isset($_SESSION['userType'])) {
    if ($_SESSION['userType'] == 1){
        if (isset($tools) && $tools == 'admin_locales'){
            ?>
            <ul class="nav justify-content-end admin-tools py-1">
                <li class="nav-item">
                    <a href="locales_alta.php" class="btn mx-1 btn-tool btn-sm"><i class="fa-solid fa-plus"></i> Alta</a>
                </li>
                <li class="nav-item">
                    <a href="locales_baja.php" class="btn me-1 btn-tool btn-sm"><i class="fa-regular fa-trash-can"></i> Baja</a>
                </li>
                <li class="nav-item">
                    <a href="locales_modificacion.php" class="btn me-1 btn-tool btn-sm"><i class="fa-regular fa-pen-to-square"></i> Modificación</a>
                </li>
                <li class="nav-item">
                    <a href="locales_listado.php" class="btn me-1 btn-tool btn-sm"><i class="fa-solid fa-list-ul"></i> Listado</a>
                </li>
            </ul>
            <?php
        }
    } else if ($_SESSION['userType'] == 2) {
        if (isset($tools) && $tools == 'owner_promociones'){
            ?>
            <ul class="nav justify-content-end admin-tools py-1">
                <li class="nav-item">
                    <a href="promociones_alta.php" class="btn mx-1 btn-tool btn-sm"><i class="fa-solid fa-plus"></i> Crear Promoción</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="btn me-1 btn-tool btn-sm"><i class="fa-regular fa-trash-can"></i> Eliminar Promoción</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="btn me-1 btn-tool btn-sm"><i class="fa-solid fa-list-ul"></i> Promociones Usadas</a>
                </li>
            </ul>
            <?php
        }
    }
}
?>
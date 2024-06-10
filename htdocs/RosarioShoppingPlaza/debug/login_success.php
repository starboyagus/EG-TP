<?php
session_start();

if(isset($_SESSION["logged"])) {
    echo $_SESSION["f_name"];
    echo $_SESSION["l_name"];
    echo $_SESSION["userType"];
    if ($_SESSION["userType"] == 3) {
        echo $_SESSION["category"];
    }
} else {
    # Puedo usar "header('Location: index.php')" para redireccionar
    echo "Este mensaje no se deberia ver";
}
?>
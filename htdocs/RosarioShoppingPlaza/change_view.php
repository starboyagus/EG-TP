<?php
session_start();

extract($_GET);

if (isset($type)) {
    if ($type > 0 && $type < 4) {
        $_SESSION["userType"] = $type;
    }
    if (isset($cat)){
        $_SESSION["category"] = $category;
    } else {
        unset($_SESSION["category"]);
    }
}

header("Location: index.php");
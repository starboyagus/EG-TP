<?php
    function db_connect() {
        $connection = mysqli_connect("localhost", "nico", "1234");
        mysqli_select_db($connection, "rosario_shopping_plaza_test");
        return $connection;
    }
?>
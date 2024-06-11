<?php
    
    function db_connect() {
        $connection = mysqli_connect("localhost", "nico", "1234");
        mysqli_select_db($connection, "rosario_shopping_plaza_test");
        return $connection;
    }

    function get_user(string $email) {
        $connection = db_connect();
        $query = mysqli_query($connection,
            "SELECT *
            FROM usuarios u
            WHERE u.emailUsuario = '" . strtolower($email) . "'");
        mysqli_close($connection);
        return $query;
    }

    function user_exists(string $email) {
        $query = get_user($email);
        if ($query->num_rows === 0) {
            return false;
        } else {
            return true;
        }
    }

    function new_user(string $f_name, string $l_name, string $email, string $pass) {
        $connection = db_connect();
        $query = mysqli_query($connection,
        "INSERT
        INTO usuarios(nombreUsuario, apellidoUsuario, emailUsuario, claveUsuario, tipoUsuario, categoriaCliente)
        VALUES ('$f_name', '$l_name', '$email', '$pass', 1, 1)");
        mysqli_close($connection);
        return $query;
    }
?>
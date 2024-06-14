<?php
session_start();

if (isset($_POST["create-local"])){
    include('db_connection.php');
    extract($_POST);
    $query = "INSERT
                  INTO locales(nombreLocal, ubicacionLocal, rubroLocal, codUsuario)
                  VALUES ('$name', '$ubi', '$category', '$owner')";
    mysqli_query($connection, $query);
    }

header("Location: locales.php");
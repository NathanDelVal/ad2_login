<?php
include_once './conn.php';
session_start();

if(!$_COOKIE['isLogged']) {
    header('location: ./login.php');
}

if($_SESSION['isAdmin']) {
    header('location: ./gerencia.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AD2 - Programação de Aplicações Web</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>

<body>
    <h1>
        BEM-VINDO AO SISTEMA DE LOGIN
    </h1>
    <button class="goBack">Voltar</button>
</body>

</html>
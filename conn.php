<?php 
    $conn = new mysqli('localhost', 'root', '', 'ad2_login_nathan');

    if ($conn->connect_error) {
        die("Conexão falhou: " ."<span class='error'>".$conn->connect_error."</span>");
      }
?>
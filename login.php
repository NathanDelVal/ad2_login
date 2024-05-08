<?php
include_once './conn.php';
setcookie('miss', 0, time() + (60 * 60), "/");

if (!empty($_POST)) {
    if ($_POST['isCadastro'] == 1) {

        $_POST['senha'] = password_hash($_POST['senha'], PASSWORD_BCRYPT);

        $query = 'INSERT INTO `users`(`nome`,`email`,`senha`) VALUES ("' . $_POST['nome'] . '", "' . $_POST['email'] . '", "' . $_POST['senha'] . '")';

        if ($conn->query($query) === TRUE) {
            echo "Registrado com sucesso";
        } else {
            echo "<span class='error'>Erro: " . $conn->error . "</span>";
        }

        $conn->close();
        $_POST = [];
    } else {
        $query = 'SELECT * FROM users WHERE email = "' . $_POST['email'] . '"';
        $result = $conn->query($query);
        $fetch = $result->fetch_assoc(); // $result->fetch_all() para multiplos resultados

        if (!empty($fetch)) {
            if ($fetch['blocked']) {
                echo "<span class='error'> Você atingiu o limite máximo de tentativas. <br>Sua conta será bloqueada durante 1 hora ou até um dos administradores liberar o seu acesso</span>";
            } else {
                if (password_verify($_POST['senha'], $fetch['senha'])) {
                    session_start();
                    setcookie('isLogged', true, time() + (30 * 24 * 60 * 60), "/");
                    $_SESSION['user'] = $_POST['email'];
                    $_SESSION['isAdmin'] = $fetch['admin'];
                    header('location: ./index.php');
                } else {
                    echo "<span class='error'> Senha incorreta!</span>";
                    setcookie('miss', $_COOKIE['miss'] + 1, time() + (60 * 60), "/");
                    if ($_COOKIE['miss'] == 3) {
                        $query = 'UPDATE users SET blocked = 1 WHERE email = "' . $_POST['email'] . '"';
                        if ($conn->query($query) === FALSE) {
                            echo "<span class='error'>Erro: " . $conn->error . "</span>";
                        }

                        $query =
                        "CREATE EVENT unblock_".time()."  
                        ON SCHEDULE
                            AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR
                        DO
                            UPDATE users SET blocked = 0 WHERE email = '".$_POST['email']."'";
                        
                        if ($conn->query($query) === FALSE) {
                            echo "<span class='error'>Erro: " . $conn->error . "</span>";
                        }
                    }
                }
            }
        } else {
            echo '<span class="error">Usuário não registrado</span>';
        };
        $result->free_result();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="login.js"></script>
    <title>AD2 - Programação de Aplicações Web</title>
</head>

<body>
    <h1>Bem-vindo ao sistema de login <br> por favor, preencha o campo com os seus dados</h1>
    <div>
        <form action="" method="post">
            <input type="hidden" value="0" name="isCadastro" id="isCadastro">
            <input placeholder="Nome" type="hidden" name="nome" id="nome" required>
            <input placeholder="E-mail" type="email" name='email' id='email' required>
            <input placeholder="Senha" type="password" name='senha' id='senha' required>
            <div>
                <input type="submit" value="Enviar">
                <button id="toggleCadastro" data-cadastro="0"> Fazer Cadastro</button>
            </div>
        </form>
    </div>
</body>

</html>
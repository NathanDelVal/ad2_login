<?php
include_once './conn.php';
session_start();

if ($_COOKIE['isLogged']) {
    if (!$_SESSION['isAdmin']) {
        header('location: ./index.php');
    }
} else {
    header('location: ./login.php');
}

if(!empty($_POST)) {
    var_dump($_POST);
    if($_POST['submit'] == 'Editar') {
        $query = "UPDATE users SET nome = '{$_POST['nome']}', email = '{$_POST['email']}', blocked = {$_POST['blocked']} WHERE email = '{$_POST['formName']}'";
        if($conn->query($query) === FALSE) {
            echo "<span class='error'>Erro: " . $conn->error . "</span>";
        };
    }
    else {
        $query = "DELETE FROM users WHERE email = '{$_POST['formName']}'";
        if($conn->query($query) === FALSE) {
            echo "<span class='error'>Erro: " . $conn->error . "</span>";
        };
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AD2 - Programação de Aplicações Web</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="adminTable.css">
    <script src="index.js"></script>
    <script src='gerencia.js'></script>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <th colspan="4">LISTA DE USUÁRIOS</th>
            </tr>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Bloqueado?</th>
            </tr>
            <?php
            $query = 'SELECT nome, email, blocked FROM users';
            $result = $conn->query($query);
            $fetch = $result->fetch_all(MYSQLI_ASSOC);
            if (!empty($fetch)) {
                foreach($fetch as $row) {
                    echo '<form id="'.$row['email'].'" action="" method="post"></form>
                    <input type="hidden" form="'.$row['email'].'" name="formName" value="'.$row['email'].'">';
                }
                foreach ($fetch as $row) {
                    echo "
                        <tr>
                        <td><input type='text' form='".$row['email']."' name='nome' value='" . $row['nome'] . "'></td>
                        <td><input type='text' form='".$row['email']."' name='email' value='" . $row['email'] . "'></td>
                        <td><select name='blocked' form='".$row['email']."' data-blocked='" . $row['blocked'] . "'><option value='1'>Sim <option value='0'>Não</td>
                        <td><input type='submit' name='submit' value='Editar' form='".$row['email']."'> &nbsp; <input type='submit' name='submit' value='Excluir' form='".$row['email']."'></td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>
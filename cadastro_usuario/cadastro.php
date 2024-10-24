<?php
include_once('../database/config.php');

function cadUsuarios($conexao)
{

    $nome = $_POST['nome'];
    $nomeOrgaoPublico = $_POST['nomeOrgaoPublico'];
    $email =  $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $result = mysqli_query($conexao, "INSERT INTO usuarios_orgao_publico(nome_orgao_publico, nome, email, senha)
            VALUES ('$nomeOrgaoPublico', '$nome','$email', '$senha')
            ");
};

if (isset($_POST['submit'])) {
    cadUsuarios($conexao);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="cadastro.css">
</head>

<body>
    <header class="top-bar">
        <div class="left-icons">
            <div class="logo">
                <img src="../imgs/minilogo.svg" alt="" srcset="">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="../imgs/Doorbell.svg" alt="" srcset="">
            </div>
            <div class="user-icon">
                <img src="../imgs/user.svg" alt="" srcset="">
            </div>
        </div>
    </header>

    <div class="login-container">
        <div class="login-image">
            <img src="../imgs/carro.svg" alt="" srcset="">
        </div>
        <div class="login-form">
            <div class="logo-login">
                <img src="../imgs/logo.svg" alt="" srcset="" class="foto">
            </div>
            <br><br><br> <br> <br><br>
            <h1>Cadastre-se agora</h1>
            <p class="txt">Entre com suas informações</p>

            <form action="" method="POST">
                <label for="nomeOrgaoPublico" class="txt2">Órgão Público</label>
                <input type="text" id="nomeOrgaoPublico" name="nomeOrgaoPublico" placeholder="Nome órgão público" required>

                <label for="nome" class="txt2">Nome</label>
                <input type="text" id="email" name="nome" placeholder="Seu nome" required>

                <label for="email" class="txt2">Email</label>
                <input type="email" id="email" name="email" placeholder="Seu email" required>


                <label for="senha" class="txt2">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Sua senha" required>

                <input class="btn1" type="submit" name="submit" id="submit"></input>
            </form>
            <br>
            <p class="txt">Já possui uma conta? <a href="../index.php">Sign in</a></p>
        </div>

        <script src="cadastro.js"></script>
</body>

</html>
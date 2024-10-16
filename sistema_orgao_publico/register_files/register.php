<?php 
    include_once('../database/config.php');

    if(isset($_POST['submit']))
    {
        //print_r('Nome: ' . $_POST['name']);
        //print_r('<br>');
        //print_r('Email:' . $_POST['email']);


        $nome = $_POST['nome'];
        $email =  $_POST['email'];
        $senha = $_POST['senha'];

        $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, email, senha)
        VALUES ('$nome', '$email', '$senha')
        ");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button id="closeBtn">&times;</button>
        </div>
        <div class="sidebar-content">
            <p>Faça Login em nosso sistema para habilitar todas funções UNICA.</p>
            <button class="b1">Fazer Login</button>
        </div>
    </div>
    
    

        <header class="top-bar">
            <div class="left-icons">
                <div class="menu-icon" id="menuBtn" >
                   <a> <img src="../imgs/menu.svg" alt="" srcset=""> </a>  
                </div>
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
    



        <div class="login-container" >

            <div class="login-image">
                <img src="../imgs/carro.svg" alt="" srcset="">
            </div>
            <div class="login-form">
                <div class="logo-login">
              <img src="../imgs/logo.svg" alt="" srcset="" class="foto">
                </div>
                <br><br><br> <br> <br><br>
                <h1>Cadastre-se agora!</h1>
                <p class="txt">Por favor, entre com suas informações</p>

                <form action="register.php" method="POST">
                    <label for="email" class="txt2">Nome</label>
                    <input type="text" id="email" name="nome" placeholder="Entre com seu nome" required>


                    <label for="email" class="txt2">Email</label>
                    <input type="email" id="email" name="email" placeholder="Entre com seu email" required>
    


                    <label for="password" class="txt2" >Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Entre com sua senha" required>

                    <label for="password" class="txt2" >Repita senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Reescreva a senha" required>
    
                    <input class="btn1" type="submit" name="submit" id="submit" ></input>
                </form>
                <br>
                <p class="txt">Já possui uma conta? <a href="../index.php">Login</a></p>
            </div>

    <script src="register.js"></script>
</body>
</html>
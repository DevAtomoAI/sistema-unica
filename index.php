<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- <div class="overlay" id="overlay"></div> -->

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar"> 
        <!-- <div class="sidebar-header">
            <button id="closeBtn">&times;</button>
        </div>
        <div class="sidebar-content">
            <p>Faça Login em nosso sistema para habilitar todas funções UNICA.</p>
            <button class="b1">Fazer Login</button>
        </div> -->
    </div>




    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a> <img src="./imgs/menu.svg" alt="" srcset=""> </a>
            </div>
            <div class="logo">
                <img src="./imgs/minilogo.svg" alt="" srcset="">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="./imgs/Doorbell.svg" alt="" srcset="">
            </div>
            <div class="user-icon">
                <img src="./imgs/user.svg" alt="" srcset="">
            </div>
        </div>
    </header>

    <div class="login-container">
        <div class="login-image">
            <img src="imgs/carro.svg" alt="" srcset="">
        </div>
        <div class="login-form">
            <div class="logo-login">
                <img src="./imgs/logo.svg" alt="" srcset="" class="foto">
            </div>
            <br><br><br> <br> <br><br>
            <h1>Bem-vindo de volta!</h1>
            <p class="txt">Entre com email e senha para acessar sua conta</p>
            <form action="verificacao_login/verificacao_usuario.php" method="POST">
                <label for="email" class="txt2">Email</label>
                <input type="email" id="email" name="email" placeholder="Insira seu email" required autocomplete="username">

                <label for="senha" class="txt2">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Insira sua senha" required autocomplete="current-password">

                <input class="btn1" type="submit" name="submit" value="Enviar"></input>

                <label id='label-remember-me'>
                    <input type="checkbox" id="remember" name="remember"> Lembre-se
                </label>
            </form>
            <br>
            <p class="txt">Não possui uma conta? <a href="cadastro_usuario/cadastro.php">Sign Up</a></p>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
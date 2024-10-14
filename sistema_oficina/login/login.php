<?php
$usuarioCookie = (isset($_COOKIE['cookieLoginUser'])) ? $_COOKIE['cookieLoginUser'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    
    <title>Login</title>
</head>
<body>
    <header class="top-bar">
        <div class="left-icons">
            <div class="logo">
                <img src="../assets/minilogo.svg" alt="">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="../assets/Doorbell.svg" alt="">
            </div>
            <div class="user-icon">
                <img src="../assets/user.svg" alt="">
            </div>
        </div>
    </header>

    <div class="login-container">
        <div class="login-image">
            <img id='img-car-login' src="../assets/carro.svg" alt="">
        </div>
        <div class="login-form">
            <div class="logo-login">
                <img src="../assets/logo.svg" alt="">
            </div>
            <div class="text-block-form">
                <h1>Login oficina</h1>
                <p class="txt">Entre com seu email e senha para acessar sua conta</p>
                <form action="verify_login.php" method="POST">
                    <label for="email" class="txt2" >Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="<?= $usuarioCookie ?>"required>

                    <label for="password" class="txt2">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Senha" required>

                    <div class="remember-forgot">
                        <label id='label-remember-me'>
                            <input type="checkbox" id="remember" name="remember"> Lembre-se
                        </label>
                        <!-- <a href="../forgot_password/forgot_password.php">Esqueceu a senha?</a> -->
                    </div>
                    <button type="submit" name="submitLogin" id="submitLogin">Sign In</button>
                </form>
                <br>
                <p class="txt">Não tem uma conta? <a href="../create_account/create_account.php"> Sign Up </a></p>
            </div>
        </div>
    </div>
</body>
</html>

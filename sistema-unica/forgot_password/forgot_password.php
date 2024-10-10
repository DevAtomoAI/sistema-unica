

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../login/login.css">
    
    <title>Esqueci a senha</title>
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
                <h1>Esqueceu a senha</h1>
                <p class="txt">Insira seu email já registrado e sua nova senha</p>
                <form action="verification_user.php" method="POST">
                    <label for="email" class="txt2" >Email</label>
                    <input type="email" id="email" name="email" placeholder="Email pré registrado" required>

                    <label for="password" class="txt2">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Nova senha" required>

                    <label for="retypePassword" class="txt2">Reescreva a senha</label>
                    <input type="password" id="retypePassword" name="retypePassword" placeholder="Senha" required>

                    <button type="submit" name="submitLogin" id="submitLogin">Verificar email</button>
                </form>
                <br>
                <p class="txt">Já possui uma conta? <a href="../login/login.php"> Sign In </a></p>

                <p class="txt">Um email será enviado para fazer a verificação da nova senha</p>
            </div>
        </div>
    </div>
</body>
</html>

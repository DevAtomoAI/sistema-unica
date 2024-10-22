<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create_account.css">
    
    <title>Criar conta</title>
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
                <h1>Criar conta</h1>
                <p class="txt">Entre com seu nome, sobrenome e senha para criar uma conta nova</p>
                <form action="insert_account.php" method="POST">

                    <label for="nameOficina" class="txt2">Nome oficina</label>
                    <input type="text" id="nameOficina" name="nameOficina" placeholder="Nome oficina" required>

                    <label for="name" class="txt2">Nome representante</label>
                    <input type="text" id="name" name="name" placeholder="Nome" required>

                    <label for="email" class="txt2" >Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>

                    <label for="password" class="txt2">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Senha" required>

                    <button type="submit" name="submitCreatedAccount" id="submitCreatedAccount"> Criar conta </button>
                    <br>
                    <br>
                    <p class="txt">Já possui uma conta?<a href="../index.php"> Sign In </a></p>
                </form> 
            </div>
        </div>
    </div>
</body>
</html>

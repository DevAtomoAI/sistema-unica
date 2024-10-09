<?php
session_start();
include_once('../database/config.php');

$emailUser = $_POST['email'];
$passwordUser = $_POST['password'];
$rememberUser = isset($_POST['remember']);

if (isset($_POST['submitLogin'])) {
    $selectTableVerifyPassword = "SELECT * FROM usuarios_oficina WHERE email='$emailUser'";
    $execConnectionVerifyPassword = $connectionDB->query($selectTableVerifyPassword);
    $valuesTable = $execConnectionVerifyPassword->fetch_assoc();
    $passwordInDB = $valuesTable['senha']; 

    if(password_verify($passwordUser, $passwordInDB)){
        
        if($rememberUser){
            $timeCookie = strtotime("+1 day");
            setcookie('cookieLoginUser', $emailUser, $timeCookie, '/', '', false, true);
        }

        $selectTable = "SELECT * FROM usuarios_oficina WHERE email='$emailUser'";
        $execConnection = $connectionDB->query($selectTable);
        $valuesTable = $execConnection->fetch_assoc();

        $nameUser = $valuesTable['nome'];
        $_SESSION['nameLoggedUser'] = $nameUser;
        $_SESSION['emailLoggedUser'] = $emailUser;
    

        header('Location: ../index.php'); // Redireciona para a página principal 

    } 
    else{
        echo "<script>
        alert('Email ou senha incorretos'); 
        window.location.href = 'login.php'; // Redireciona para a página de login
      </script>";
    }

    


}
?>

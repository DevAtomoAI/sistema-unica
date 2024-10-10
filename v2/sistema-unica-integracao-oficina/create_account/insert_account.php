<?php
include_once('../database/config.php');
session_start();


$nameNewAccount = $_POST['name'];
$emailNewAccount = $_POST['email'];
$passwordNewAccount = password_hash($_POST['password'], PASSWORD_DEFAULT);
$secondNameNewAccount = $_POST['secondName'];

$selectTable = "SELECT * FROM usuarios_oficina WHERE email='$emailNewAccount'";
$execConnection = $connectionDB->query($selectTable);
$valuesTable = $execConnection->fetch_assoc();

if(isset($_POST['submitCreatedAccount']) && $valuesTable == null){
    $insertValuesTable  = mysqli_query($connectionDB, "INSERT INTO usuarios_oficina (nome, sobrenome, email, senha)  
    VALUES ('$nameNewAccount', '$secondNameNewAccount' ,'$emailNewAccount', '$passwordNewAccount')");

    header('Location: ../login/login.php');
}
else{
    echo "<script>
    alert('Essa conta já está registrada'); 
    window.location.href = '../login/login.php'; // Redireciona para a página de login
  </script>";
}
?>
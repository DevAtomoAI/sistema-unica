<?php

include_once('../database/config.php');

$emailRegistered = $_POST['email'];
$newPassword = $_POST['password'];
$retypeNewPassword = $_POST['retypePassword'];

$selectTable = "SELECT * FROM usuarios_oficina WHERE email='$emailRegistered'";
$execConnection = $connectionDB->query($selectTable);
$valuesTable = $execConnection->fetch_assoc();


if($newPassword != $retypeNewPassword && $valuesTable >= 1){
    echo "<script>
    alert('Senhas diferentes'); 
    window.location.href = 'forgot_password.php'; // Redireciona para a página de login
  </script>";
}
else{

}
// Enviar email com php, via phpmailer
// - fazer uma página, nela
// colocar email do usuário já registrado
// colocar campo para senha nova
// colocar outro campo para confirmar senha nova

// após apertado o botão para enviar, será enviado um email para o email dito anteriormente, nisso, a pessoa ira acessar o site enviado por email para confirmar que é ela mesma



?>
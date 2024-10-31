<?php
session_start();
include_once('../database/config.php');

$emailUser = $_POST['email'];
$passwordUser = $_POST['password'];
$rememberUser = isset($_POST['remember']);

function verifyLogin($emailUser, $passwordUser, $rememberUser, $connectionDB) {
    // Usando prepared statement para evitar SQL Injection
    $stmt = $connectionDB->prepare("SELECT * FROM usuarios_oficina WHERE email = ? AND senha=?");
    $stmt->bind_param("ss", $emailUser, $passwordUser); // "s" para string
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->num_rows;

    if ($valuesTable > 0) {
        $_SESSION['nameLoggedUser'] = $valuesTable['nome'];
        $_SESSION['emailLoggedUser'] = $emailUser;
        $_SESSION['nomeOficina'] = $valuesTable['nome_oficina'];

        // Definir cookie se "Lembrar-me" estiver marcado
        if ($rememberUser) {
            setcookie('cookieLoginUser', $emailUser, time() + 86400, '/', '', false, true); // 1 dia
        }

        header('Location: ../cotacoes_andamento/andamento.php');
        exit;
    } else {
        echo "<script>alert('Email ou senha incorretos')";
        exit;
    }
}

// Verifica se o formulário foi enviado fora da função para maior modularidade
if (isset($_POST['submitLogin'])) {
    verifyLogin($emailUser, $passwordUser, $rememberUser, $connectionDB);
    

}

?>

<?php
session_start();
include_once('../database/config.php');

$emailUser = $_POST['email'];
$passwordUser = $_POST['password'];
$rememberUser = isset($_POST['remember']);

function verifyLogin($emailUser, $passwordUser, $rememberUser, $connectionDB) {
    // Usando prepared statement para evitar SQL Injection
    $stmt = $connectionDB->prepare("SELECT * FROM usuarios_oficina WHERE email = ?");
    $stmt->bind_param("s", $emailUser); // "s" para string
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->fetch_assoc();

    // Verifica se o usuário existe e se a senha está correta
    if ($valuesTable && password_verify($passwordUser, $valuesTable['senha'])) {
        // Definir variáveis de sessão
        $_SESSION['nameLoggedUser'] = $valuesTable['nome'];
        $_SESSION['emailLoggedUser'] = $emailUser;

        // Definir cookie se "Lembrar-me" estiver marcado
        if ($rememberUser) {
            setcookie('cookieLoginUser', $emailUser, time() + 86400, '/', '', false, true); // 1 dia
        }

        // Redireciona para a página principal
        header('Location: ../cotacoes_andamento/andamento.php');
        exit; // Para a execução do script após o redirecionamento
    } else {
        // Exibe uma mensagem de erro e redireciona para a página de login
        echo "<script>alert('Email ou senha incorretos'); window.location.href = '../index.php';</script>";
        exit;
    }
}

// Verifica se o formulário foi enviado fora da função para maior modularidade
if (isset($_POST['submitLogin'])) {
    verifyLogin($emailUser, $passwordUser, $rememberUser, $connectionDB);
}

?>

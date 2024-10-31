<?php
session_start();
include_once('../database/config.php');

$email = $_POST['email'];
$senha = $_POST['senha'];
$rememberUsuario = isset($_POST['remember']);
function verificaLogin($email, $senha, $rememberUsuario, $conexao) {
    // Usando prepared statement para evitar SQL Injection
    $stmt = $conexao->prepare("SELECT * FROM usuarios_orgao_publico WHERE email = ? AND senha=?");
    $stmt->bind_param("ss", $email, $senha); // "s" para string
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->num_rows;

    // Verifica se o usuário existe e se a senha está correta
    if ($valuesTable > 0) {
        // Definir variáveis de sessão
        $_SESSION['nameLoggedUser'] = $valuesTable['nome'];
        $_SESSION['emailLoggedUser'] = $email;
        $_SESSION['idOrgaoPublico'] = $valuesTable['id_usuarios_orgao_publico'];

        // Definir cookie se "Lembrar-me" estiver marcado
        if ($rememberUsuario) {
            setcookie('cookieLoginUser', $email, time() + 86400, '/', '', false, true); // 1 dia
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
if (isset($_POST['submit'])) {
    verificaLogin($email, $senha, $rememberUsuario, $conexao);
}
?>

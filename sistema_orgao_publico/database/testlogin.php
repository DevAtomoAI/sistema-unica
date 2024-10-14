<?php
session_start();

if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    include_once('config.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if(mysqli_num_rows($result) < 1) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: index.php');
    } else {
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $user_data['nome']; // Armazenando o nome na sessão
        $_SESSION['senha'] = $senha;
        header('Location: ../andamento_files/andamento.php');
    }
} else {
    header('Location: index.php');
}
?>

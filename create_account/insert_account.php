<?php

include_once('../database/config.php');

$nameNewAccount = $_POST['name'];
$emailNewAccount = $_POST['email'];
$passwordNewAccount = password_hash($_POST['password'], PASSWORD_DEFAULT);

function registerUser($connectionDB, $nameNewAccount, $emailNewAccount, $passwordNewAccount) {
    // Validate user input
    if (empty($nameNewAccount) || empty($emailNewAccount) || empty($passwordNewAccount)) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href = '../index.php';</script>";
        return;
    }

    // Validate email format
    if (!filter_var($emailNewAccount, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email inválido.'); window.location.href = '../index.php';</script>";
        return;
    }

    // Use prepared statement to avoid SQL Injection
    $stmt = $connectionDB->prepare("SELECT * FROM usuarios_oficina WHERE email = ?");
    $stmt->bind_param("s", $emailNewAccount); // 's' for string
    $stmt->execute();
    $result = $stmt->get_result();
    $valuesTable = $result->fetch_assoc();

    if ($valuesTable) {
        // If email already exists
        echo "<script>alert('Essa conta já está registrada.'); window.location.href = '../index.php';</script>";
        return;
    } else {
        // Insert user data into the database using prepared statements
        $stmtInsert = $connectionDB->prepare("INSERT INTO usuarios_oficina (nome, email, senha) VALUES ( ?, ?, ?)");
        $stmtInsert->bind_param("sss", $nameNewAccount, $emailNewAccount, $passwordNewAccount);

        if ($stmtInsert->execute()) {
            // Successful registration
            header('Location: ../index.php');
            exit; // Stop script after redirection
        } else {
            // Handle database errors
            echo "<script>alert('Ocorreu um erro ao criar a conta.'); window.location.href = '../index.php';</script>";
            error_log("Database Error: " . $stmtInsert->error); // Log the error
            exit;
        }
    }
}

// Check if form was submitted
if (isset($_POST['submitCreatedAccount'])) {
    registerUser($connectionDB, $nameNewAccount, $emailNewAccount, $passwordNewAccount);
}

?>
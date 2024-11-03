<?php

include_once("../database/config.php");
session_start();
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

$selectFornecedores = "SELECT * FROM dados_fornecedores WHERE id_orgao_publico='$idOrgaoPublicoLogado'";
$queryFornecedores = mysqli_query($conexao, $selectFornecedores);
// $valoresFornecedores = mysqli_fetch_assoc($queryFornecedores);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Fornecedores</h1>
    <br>
    <br>
    <form action="config_fornecedores.php" method="POST">

        <input type="text" name='nomeFornecedor' placeholder="Nome">
        <input type="text" name='tipoFornecedor' placeholder="Tipo">
        <input type="text" name='enderecoFornecedor' placeholder="Endereço">
        <input type="text" name='cidadeFornecedor' placeholder="Cidade">
        <input type="text" name='estadoFornecedor' placeholder="Estado">
        <input type="text" name='contatoFornecedor' placeholder="Contato">
        <br>
        <br>
        <button name="salvaValoresFornecedores">Enviar</button>
        <br>
        <br>
        <h3>Fornecedores já cadastrados</h3>
        <table>
            <thead>
                <tr>
                    Nome
                </tr>
                <tr>
                    Tipo
                </tr>
                <tr>
                    Endereço
                </tr>
                <tr>
                    Cidade
                </tr>
                <tr>
                    Estado
                </tr>
                <tr>
                    Contato
                </tr>
            </thead>

            <tbody>
                <?php
                    while($valoresFornecedores = mysqli_fetch_assoc($queryFornecedores)){
                        echo "<tr>";
                        echo "<td>" . $valoresFornecedores['nome']. "</td>";
                        echo "<td>" . $valoresFornecedores['tipo']. "</td>";
                        echo "<td>" . $valoresFornecedores['endereco']. "</td>";
                        echo "<td>" . $valoresFornecedores['cidade']. "</td>";
                        echo "<td>" . $valoresFornecedores['estado']. "</td>";
                        echo "<td>" . $valoresFornecedores['contato']. "</td>";
                        echo "</tr>";
                    }
                ?>
                </tr>
            </tbody>
        </table>

    </form>

</body>

</html>
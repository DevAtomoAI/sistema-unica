<?php
session_start();
include_once("../database/config.php");
function checkUserLoggedIn()
{
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
$nomeUsuario = $_SESSION["nameLoggedUser"];
$idVeiculosInclusosOrgaoPublico = $_SESSION["idVeiculosInclusosOrgaoPublico"];

$selectTable = "SELECT * FROM usuarios_orgao_publico WHERE nome='$nomeUsuario' AND id_usuarios_orgao_publico='$idOrgaoPublicoLogado'";
$execConnection = $conexao->query($selectTable);
$user_data = mysqli_fetch_assoc($execConnection);

if ($idVeiculosInclusosOrgaoPublico) {
    $selectTable2 = "SELECT * FROM infos_veiculos_aprovados_oficina 
                WHERE id_veiculo_incluso_orgao_publico = $idVeiculosInclusosOrgaoPublico AND id_orgao_publico='$idOrgaoPublicoLogado' AND orcamento_aprovado_reprovado!='Aprovada'
                AND orcamento_aprovado_reprovado!='Cancelada'";
    $numLinhasTotal2 = $conexao->query($selectTable2)->num_rows;

    $selectTable3 = "SELECT * FROM infos_veiculos_aprovados_oficina 
                     WHERE orcamento_aprovado_reprovado = '' AND
                     id_veiculo_incluso_orgao_publico = $idVeiculosInclusosOrgaoPublico 
                     AND id_orgao_publico = '$idOrgaoPublicoLogado'";
    $numLinhasTotal3 = $conexao->query($selectTable3)->num_rows;

    $selectTable4 = "SELECT veiculo FROM infos_veiculos_inclusos 
                     WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
                     AND id_infos_veiculos_inclusos = '$idVeiculosInclusosOrgaoPublico'";
    $nomeVeiculo = $conexao->query($selectTable4)->fetch_assoc()['veiculo'] ?? '';
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus dados</title>
    <link rel="stylesheet" href="dados.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a> <img src="../imgs/menu.svg"> </a>
            </div>
            <div class="logo">
                <img src="../imgs/minilogo.svg">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="../imgs/Doorbell.svg">
            </div>

            <div class="user-name">
                <p><?= $nomeUsuario; ?></p>
            </div>

            <div class="user-icon">
                <img src="../imgs/user.svg"> -
            </div>
        </div>
    </header>
    <br><br><br>
    <!-- Conteudo Principal -->

    <div class="main-content">
        <h1>Meus Dados</h1>

        <h2>Dados do Órgão:</h2>
        <form action="config_dados.php" method="POST">

            <div class="table-responsive">
                <table id="tabela-orgao">
                    <tr>
                        <th>Nº do Contrato</th>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Contato</th>
                        <th>E-mail</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="num_contrato" id="num_contrato" value="<?= $user_data['num_contrato'] ?>"></td>
                        <td><input type="text" name="razao_social" id="razao_social" value="<?= $user_data['razao_social'] ?>"></td>
                        <td><input type="text" name="cnpj" id="cnpj" value="<?= $user_data['identificacao_cnpj'] ?>"></td>
                        <td><input type="text" name="responsavel" id="responsavel" value="<?= $user_data['responsavel'] ?>"></td>
                        <td><input type="text" name="contato" id="contato" value="<?= $user_data['contato'] ?>"></td>
                        <td><input type="email" name= "email" id="email" value="<?= $user_data['email'] ?>"></td>
                    </tr>
                </table>
                <button class="button">Enviar Dados do Órgão</button>
            </div>

            <h2>Dados dos Centros de Custo:</h2>
            <div class="table-responsive">
                <table id="tabela-centro">
                    <tr>
                        <th>Nome</th>
                        <th>Valor do Contrato</th>
                        <th>Fonte de Recurso</th>
                        <th>Data do Crédito</th>
                        <th>Nº Ordem Bancária</th>
                        <th>Valor do Crédito</th>
                    </tr>
                    <tr>
                        <td><input type="text" id="nome_centro"></td>
                        <td><input type="text" id="valor_contrato"></td>
                        <td><input type="text" id="fonte_recurso"></td>
                        <td><input type="date" id="data_credito"></td>
                        <td><input type="text" id="ordem_bancaria"></td>
                        <td><input type="text" id="valor_credito"></td>
                    </tr>
                </table>

                <button class="button" onclick="salvarDadosOrgao()">Enviar Dados do Centro de Custo</button>
        </form>
    </div>
    <a href="../cotacoes_andamento/andamento.php">Voltar</a>

    </div>
    <script src="dados.js"></script>

</body>

</html>
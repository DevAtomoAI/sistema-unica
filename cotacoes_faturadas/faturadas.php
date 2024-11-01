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

$selectTableFaturadas = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Faturada Oficina'";

if (isset($_SESSION['filtrosPesquisaFaturadas']) && !empty($_SESSION['filtrosPesquisaFaturadas'])) {
    $selectTableFaturadas = $_SESSION['filtrosPesquisaFaturadas'];
}

$_SESSION['filtrosPesquisaFaturadas'] = null;

$execConnectionFaturadas = $conexao->query($selectTableFaturadas);
$numLinhasAprovadas = $execConnectionFaturadas->num_rows;

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
    <title>Em andamento</title>
    <link rel="stylesheet" href="faturado.css">
    <link rel="shortcut icon" href="icone.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">

        <ul class="nav-options">
            <!-- <li><a href="../dados/dados.php"><img src="../imgs/dados.svg"> Meus dados</a></li> -->
            <li><a href="../incluir_cotacao/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="../cotacoes_andamento/andamento.php"><img src="../imgs/clock.svg"> Em andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="#cotacoesFaturadas"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="../cotacoes_cancelado/cancelado.php"><img src="../imgs/cancel.svg"> Cancelado</a></li>

        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a> <img src="../imgs/menu.svg"> </a>
            </div>
            <div class="logo"><img src="../imgs/minilogo.svg"></div>
        </div>
        <div class="right-icons">
            <div class="notification-icon"><img src="../imgs/Doorbell.svg"></div>

            <div class="user-name">
                <p><?= $nomeUsuario; ?></p>
            </div>

            <div class="user-icon"><img src="../imgs/user.svg"></div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->
    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações Faturadas</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_faturadas.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
                    <?php
                    $selectTableOrgaosSolicitantes = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Faturado Oficina' ORDER BY id_infos_veiculos_inclusos ASC";
                    $execConnectionOrgaoSolicitante = $conexao->query($selectTableOrgaosSolicitantes);

                    while ($orgaoSolicitantes = mysqli_fetch_assoc($execConnectionOrgaoSolicitante)) {
                        echo "<option value='" . $orgaoSolicitantes['id_infos_veiculos_inclusos'] . "'>" . $orgaoSolicitantes['centro_custo'] . "</option>";
                    }
                    ?>
                </select>
                <input type="text" placeholder="Placa">
                <select name="ordenar-por">
                    <option value="">Ordenar</option>
                    <option name="numero_veiculo_decrescente" id="numero_veiculo_decrescente" value="numero_veiculo_decrescente">Por número (decrescente)</option>
                    <option name="numero_veiculo_crescente" id="numero_veiculo_crescente" value="numero_veiculo_crescente">Por número (crescente)</option>
                    <option name="placa_veiculo" id="placa_veiculo" value="placa">Por placa </option>
                </select>
                <button class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
                <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
            </form>
        </div>

        <!-- Tabela de cotações com ícones -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <!-- <th>Veiculo</th> -->
                        <th>Oficina</th>
                        <th>Fatura peças</th>
                        <th>Fatura serviços</th>
                        <!-- <th>Opção</th> -->
                    </tr>
                </thead>
                <tbody id="cotacoes-body">
                    <!-- Conteúdo da tabela será inserido dinamicamente -->
                    <?php

                        while ($userData = mysqli_fetch_assoc($execConnectionFaturadas)) {
                            $idVeiculoIncluso = $userData['id_infos_veiculos_inclusos'];

                            $selectTableFaturadas2 = "SELECT * FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico='$idVeiculoIncluso'";

                            $execConnectionFaturadas2 = $conexao->query($selectTableFaturadas2);

                            while($userData2 = mysqli_fetch_assoc($execConnectionFaturadas2)){
                                echo "<tr>";
                                echo "<td class='resultadosTabela'>" . $userData['id_infos_veiculos_inclusos'] . "</td>";
                                // echo "<td class='resultadosTabela'>" . $userData[] . "</td>";
                                echo "<td class='resultadosTabela'>" . $userData2['nome_oficina_aprovado'] . "</td>";
                                echo "<td class='resultadosTabela'><a href='faturasPecas.php?id=" . $userData2['id_veiculo_incluso_orgao_publico'] . "'> Fatura peças</a></td>";
                                echo "<td class='resultadosTabela'> <a href='faturasServicos.php?id=" . $userData2['id_veiculo_incluso_orgao_publico'] . "'> Fatura serviço </a></td>";
                                echo "</tr>";
                            }

                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
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
    <title>Fornecedores</title>
    <link rel="stylesheet" href="fornecedores.css">
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
            <li><a href="../cotacoes_andamento/andamento.php"><img src="../imgs/clock.svg">Andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="../cotacoes_faturadas/faturadas.php"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="../cotacoes_cancelado/cancelado.php"><img src="../imgs/cancel.svg"> Cancelado</a></li>
            <div class="logotype"> 
                <img src="../imgs/biglogo.svg">
            </div>
        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a><img src="../imgs/menu.svg"> </a>
            </div>
            <div id="menu-options" class="menu-options">
                <div class="option"><a href="../dados/dados.php">Meus dados</a></div>
                <div class="option"><a href="../gestao/gestao.php">Painel de Gestão</a></div>
                <div class="option"><a href="../frota/frota.php">Frota</a></div>
                <div class="option"><a href="../fornecedores/fornecedores.php">Fornecedores</a></div>
                <div class="option"><a href="../relatorio/relatório.php">Relatório</a>
            </div>
    <!-- Adicione mais opções conforme necessário -->
</div>
            <div class="logo"><img src="../imgs/minilogo.svg"></div>
        </div>
        <div class="right-icons">
            <div class="notification-icon"> <img src="../imgs/Doorbell.svg"></div>

            <div class="user-name">
                <!-- <p><?= $nomeUsuario; ?></p> -->
            </div>

            <div class="user-icon"><img src="../imgs/user.svg"></div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->
    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Fornecedores</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_andamento.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
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
                <a href="incluir_fornecedores.php">Incluir</a>
            </form>
        </div>

        <!-- Tabela de cotações com ícones -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nome fornecedor</th>
                        <th>Tipo</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Contato</th>
                    </tr>
                </thead>
                <tbody id="cotacoes-body">
                    <!-- Conteúdo da tabela será inserido dinamicamente -->
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
                </tbody>
            </table>
        </div>

       
    <script src="fornecedores.js"></script>
</body>

</html>
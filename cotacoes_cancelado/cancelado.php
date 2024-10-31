<?php
session_start();
include_once("../database/config.php");
function checkUserLoggedIn() {
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();

$nomeUsuario = $_SESSION["nameLoggedUser"];

// $selectTableAprovadas = "SELECT * FROM  infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Cancelada' ORDER BY id_infos_veiculos_inclusos ASC";
// $execConnectionAprovadas = $conexao->query($selectTableAprovadas);
// $numLinhasAprovadas = $execConnectionAprovadas->num_rows;

$selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Cancelada' ORDER BY id_infos_veiculos_inclusos ";

if(isset($_SESSION['filtrosPesquisaAprovada']) && !empty($_SESSION['filtrosPesquisaAprovada'])) {
    $selectTable = $_SESSION['filtrosPesquisaCancelado'];
}

$_SESSION['filtrosPesquisaCancelado'] = null;

$execConnection = $conexao->query($selectTable);
$numLinhasTotal = $execConnection->num_rows;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelado</title>
    <link rel="stylesheet" href="cancelado.css">
    <link rel="shortcut icon" href="icone.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
        </div>
        <ul class="nav-options">

            <!-- <li>
                <a href="../dados/dados.php">
                    <img src="../imgs/dados.svg"> Meus dados
                </a>
            </li> -->

            <li>
                <a href="../incluir_cotacao/incluir.php">
                    <img src="../imgs/time.svg"> Incluir
                </a>
            </li>
            <li>
                <a href="../cotacoes_andamento/andamento.php">
                    <img src="../imgs/clock.svg"> Em andamento
                </a>
            </li>
            <li>
                <a href="../cotacoes_aprovado/aprovado.php">
                    <img src="../imgs/check.svg"> Aprovado
                </a>
            </li>
            <li>
                <a href="../cotacoes_faturadas/faturadas.php">
                    <img src="../imgs/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a href="">
                    <img src="../imgs/cancel.svg"> Cancelado
                </a>
            </li>
        </ul>
    </div>

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
                <p><?php echo $nomeUsuario; ?></p>
            </div>


            <div class="user-icon">
                <img src="../imgs/user.svg">
            </div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->

    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações Canceladas</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_cancelado.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
                    <?php
                    $selectTableOrgaosSolicitantes = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Cancelada' ORDER BY id_infos_veiculos_inclusos ASC";
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
                <button id='search-btn' class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
                <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
            </form>
        </div>

        <!-- Tabela de cotações aprovadas -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Centro de Custo</th>
                        <th>Vencedor</th>
                        <th>Data de Abertura</th>
                        <th>Valor Fechamento</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Tabela dinâmica -->
                    <?php
                    while ($user_data = mysqli_fetch_assoc($execConnection)) {
                        echo "<tr>";
                        echo "<td class='resultadosTabela'>" . $user_data['id_infos_veiculos_inclusos'] . "</td>";
                        echo "<td class='resultadosTabela' >" . $user_data['placa'] . "</td>";
                        echo "<td class='resultadosTabela' ></td>";
                        echo "<td class='resultadosTabela' >" . $user_data['centro_custo'] . "</td>";
                        echo "<td class='resultadosTabela' >" . $user_data['propostas'] . "</td>";
                        echo "<td class='resultadosTabela' >" . $user_data['data_abertura'] . "</td>";
                        echo "<td class='resultadosTabela' >" . $user_data['data_final'] . "</td>";
                        // echo "<td class='resultadosTabela' > <button name='button-option-aproved' class='btn-action btn-green' value='" . $user_data['id'] . "'><i class='fas fa-check'></i></button> <button name='button-option-rejected' class='btn-action btn-red' value='" . $user_data['id'] . "'><i class='fas fa-times'></i></button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="rejeitado.js"></script>
</body>

</html>
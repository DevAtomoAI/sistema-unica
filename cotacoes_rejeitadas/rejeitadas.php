<?php
session_start();
include_once('../database/config.php') ;

function checkUserLoggedIn() {
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();
$nameUser = $_SESSION['nameLoggedUser'];

function executeQuery($connectionDB, $query) {
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

$selectTableRejeitadas = "SELECT * FROM orcamentos_oficinas WHERE orcamento_aprovado_reprovado='Rejeitado'";

if (isset($_SESSION['filtrosPesquisa']) || !empty($_SESSION['filtrosPesquisa'])) {
    $selectTableRejeitadas = $_SESSION['filtrosPesquisa'];
} 
$_SESSION['filtrosPesquisa'] = null;
$execConnection = executeQuery($connectionDB, $selectTableRejeitadas);
$row = $execConnection->fetch_assoc();
$idVeiculoGerenciado = $row['id_veiculo_gerenciado'];

$selectInfosVeiculoRejeitado = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos='$idVeiculoGerenciado'";
$execConnectionInfosVeiculosRejeitados = executeQuery($connectionDB, $selectInfosVeiculoRejeitado);

$numLinhasTotal = $execConnection->num_rows;
$execCentroCusto = executeQuery($connectionDB, $selectTableRejeitadas);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rejeitadas.css">
    <title>Página principal</title>
</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button id="closeBtn"></button>
        </div>
        <ul class="nav-options">
            <h1 class="side-bar-title">COTAÇÕES</h1>
            <li>
                <a id='opcaoEmAndamento' href="../cotacoes_andamento/andamento.php" >
                    <img src="../assets/clock.svg"> Em andamento
                </a>
            </li>

            <li>
                <a id='opcaoRejeitado' href="#rejeitadas">
                    <img src="../assets/triangle-exclamation.svg"> Rejeitado
                </a>
            </li>

            <li>
                <a id="opcaoParaResponder" href="../cotacoes_respondidas/respondidas.php">
                    <img src="../assets/check.svg"> Respondido
                </a>
            </li>
            <li>
                <a id='opcaoAprovado' href="#aprovado" data-target="cotacoesAprovadas">
                    <img src="../assets/thumbs-up.svg"> Aprovado
                </a>
            </li>
            <li>
                <a id='opcaoReprovado' href="#reprovado" data-target='cotacoesReprovadas'>
                    <img src="../assets/thumbs-down.svg"> Reprovado
                </a>
            </li>
            <li>
                <a id='opcaoFaturado' href="#faturado" data-target="cotacoesFaturadas">
                    <img src="../assets/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a id='opcaoCancelado' href="#cancelado" data-target="cotacoesCanceladas">
                    <img src="../assets/cancel.svg"> Cancelado
                </a>
            </li>

            <div class="logotype"> 
                <img src="../assets/biglogo.svg">
            </div>

        </ul>
        <img id='logo-side-bar' src="../assets/logo.svg" alt="">
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a id="menuText"> Menu <img src="../assets/menu.svg"></a>
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
            <?= $_SESSION['numLinhasTotalNotificacao'] ?> <img src="../assets/Doorbell.svg">
            </div>
            <div id='userId' class="user-icon">
                <a id="nameLoggedUser"><?= $nameUser ?></a>
                <img src="../assets/user.svg">
            </div>
        </div>
    </header>

    <!-- Corpo da página -->
    <div id="cotacoesEmAndamento" class="styleCotacoesOpcoes">
        <h1 class='actualPageTitle'><img src="../assets/dark-clock.svg">Cotações Rejeitadas</h3>

            <div class="searchItens">
                <form action="configs_rejeitadas.php" method="POST">
                    <div class="search-container">
                        <div class="groupsSearchItens">
                            <label class='filtrosPesquisa' id="searchKeyWord" for="searchKeyWordInput">Busca</label>
                            <input type="text" name="searchKeyWordInput" id="searchKeyWordInput" placeholder="Palavra-chave">
                        </div>

                        <div class="groupsSearchItens">
                            <label class='filtrosPesquisa' id="searchOpen" for="searchOpenInput">Abertura</label>
                            <input type="date" name="searchOpenInput" id="searchOpenInput">
                        </div>

                        <div class="groupsSearchItens">
                            <label class='filtrosPesquisa' id="searchClose" for="searchCloseInput">Fechamento</label>
                            <input type="date" name='searchCloseInput' id='searchCloseInput'>
                        </div>

                        <div class="groupsSearchItens">
                            <label class='filtrosPesquisa' id="searchInstitution" for="searchInstitutionInput">Órgão</label>
                            <select name="searchInstitutionInput" id="searchInstitutionInput">
                                <option value="">Todos</option>
                                <?php
                                while ($centroCusto = mysqli_fetch_assoc($execCentroCusto)) {
                                    echo "<option value='" . $centroCusto['id_infos_veiculos_inclusos'] . "'>" . $centroCusto['centro_custo'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        <div class="groupsSearchItens">
                            <form action="configs_andamento.php" method="POST">
                                <label class='filtrosPesquisa' id="orderBy" for="orderByInput">Ordenar</label>
                                <select name="orderByInput" id="orderByInput">
                                    <option name="numero_veiculo_decrescente" id="numero_veiculo_decrescente" value="numero_veiculo_decrescente">Por número (decrescente)</option>
                                    <option name="numero_veiculo_crescente" id="numero_veiculo_crescente" value="numero_veiculo_crescente">Por número (crescente)</option>
                                    <option name="marca_veiculo" id="marca_veiculo" value="marca_veiculo">Por marca </option>
                                </select>
                            </form>
                        </div>

                        <button class='filtrosPesquisa' id="btn"idtype="submit" name="searchValuesOnGoing" id="searchValuesOnGoing"><img src="assets/lupa.svg" alt=""> Pesquisar</button>
                    </div>
                </form>
            </div>

            <div class="resultSearch">
                <?php echo "<p id='resultsFound'>Foram encontrado(s) " . $numLinhasTotal . " serviço(s)</p>" ?>
                <br>
                <form action="configs_andamento.php" method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th class='titulosTabela'>Nº</th>
                                <th class='titulosTabela'>Marca</th>
                                <th class='titulosTabela'>Centro custo</th>
                                <th class='titulosTabela'>Tipo Solicitação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($execConnectionInfosVeiculosRejeitados)) {
                                echo "<tr>";
                                echo "<td class='resultadosTabela'>" . $user_data['id_infos_veiculos_inclusos'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['centro_custo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['tipo_solicitacao'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
    </div>

    <script src="../script.js"></script>

</body>

</html>
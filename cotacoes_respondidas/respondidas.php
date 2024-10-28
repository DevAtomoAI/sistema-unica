<?php
session_start();
include_once('../database/config.php');

function checkUserLoggedIn()
{
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();
$nameUser = $_SESSION['nameLoggedUser'];

function executeQuery($connectionDB, $query)
{
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

$selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='Respondida' ORDER BY id_infos_veiculos_inclusos ASC";

if (isset($_SESSION['filtrosPesquisaRespondidas']) || !empty($_SESSION['filtrosPesquisaRespondidas'])) {
    $selectTable = $_SESSION['filtrosPesquisaRespondidas'];
}

$_SESSION['filtrosPesquisaRespondidas'] = null;

$execConnection = executeQuery($connectionDB, $selectTable);
$numLinhasTotal = $execConnection->num_rows;
$execCentroCusto = executeQuery($connectionDB, $selectTable);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="respondidas.css">
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
                <a id="opcaoAndamento" href="../cotacoes_andamento/andamento.php">
                    <img src="../assets/clock.svg"> Em andamento
                </a>
            </li>

            <li>
                <a opcao="opcaoRejeitadas" href="../cotacoes_rejeitadas/rejeitadas.php">
                    <img src="../assets/triangle-exclamation.svg"> Rejeitado
                </a>
            </li>

            <li>
                <a id="opcaoParaResponder" href="#respondido">
                    <img src="../assets/check.svg"> Respondido
                </a>
            </li>
            <li>
                <a id='opcaoAprovado' href="../cotacoes_aprovadas/aprovadas.php">
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
                <a id='opcaoCancelado' href="../cotacoes_canceladas/canceladas.php">
                    <img src="../assets/cancel.svg"> Cancelado
                </a>
            </li>
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
                <img src="../assets/Doorbell.svg">
            </div>
            <div id='userId' class="user-icon">
                <a id="nameLoggedUser"><?= $nameUser ?></a>
                <img src="../assets/user.svg">
            </div>
        </div>
    </header>

    <!-- Corpo da página -->
    <div id="cotacoesEmAndamento" class="styleCotacoesOpcoes">
        <h1 class='actualPageTitle'><img src="../assets/dark-clock.svg">Cotações Respondidas</h3>

            <div class="searchItens">
                <form action="configs_respondidas.php" method="POST">
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
                                    <option name="placa_veiculo" id="placa_veiculo" value="placa">Por placa </option>
                                    <option name="marca_veiculo" id="marca_veiculo" value="marca_veiculo">Por marca </option>
                                    <option name="modelo_veiculo" id="modelo_veiculo" value="modelo_veiculo">Por modelo </option>
                                </select>
                            </form>
                        </div>

                        <button class='filtrosPesquisa' id="btn" idtype="submit" name="procuraValoresRespondidas" id="procuraValoresRespondidas"><img src="assets/lupa.svg" alt=""> Pesquisar</button>
                    </div>
                </form>
            </div>

            <div class="resultSearch">
                <?php echo "<p id='resultsFound'>Foram encontrado(s) " . $numLinhasTotal . " serviço(s)</p>" ?>
                <br>
                <form action="configs_respondidas.php" method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th class='titulosTabela'>Nº</th>
                                <th class='titulosTabela'>Placa</th>
                                <th class='titulosTabela'>Marca</th>
                                <th class='titulosTabela'>Modelo</th>
                                <th class='titulosTabela'>Ano</th>
                                <th class='titulosTabela'>Centro custo</th>
                                <th class='titulosTabela'>Tipo Solicitação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($execConnection)) {
                                echo "<tr>";
                                echo "<td class='resultadosTabela'>" . $user_data['id_infos_veiculos_inclusos'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['placa'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['veiculo'] . "</td>";
                                echo "<td class='resultadosTabela'>" . $user_data['modelo_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['ano_veiculo'] . "</td>";
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

    <!-- <script src="../script.js"></script> -->

</body>

</html>
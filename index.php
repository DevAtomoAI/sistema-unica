<?php
session_start();
include_once('database/config.php');

// Função para verificar se o usuário está logado
function checkUserLoggedIn() {
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: login/login.php');
        exit;
    }
}

// Função para encerrar a sessão (logout)
function logoutIfRequested() {
    if (isset($_POST['pagina_fechada'])) {
        session_unset();
        session_destroy();
        header('Location: login/login.php');
        exit;
    }
}

// Função para executar uma query e retornar os resultados
function executeQuery($connectionDB, $query) {
    $stmt = $connectionDB->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

// Verifica se o usuário está logado
checkUserLoggedIn();
$nameUser = $_SESSION['nameLoggedUser'];

// Verifica se o logout foi solicitado
logoutIfRequested();

// Define a query principal de acordo com os filtros
if (isset($_SESSION['filtrosPesquisa']) && !empty($_SESSION['filtrosPesquisa'])) {
    $selectTable = $_SESSION['filtrosPesquisa'];
} else {
    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='' ORDER BY id_cotacoes_veiculos";
}

// Executa a query principal
$execConnection = executeQuery($connectionDB, $selectTable);
$numLinhasTotal = $execConnection->num_rows;

// Query para registros com "Rejeitar"
$selectTableWhereRejeitar = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='Rejeitar' ORDER BY id_cotacoes_veiculos ASC";
$execConnectionRejeitar = executeQuery($connectionDB, $selectTableWhereRejeitar);
$numLinhasRejeitar = $execConnectionRejeitar->num_rows;

// Query para registros com "Orçar"
$selectTableWhereOrcar = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='Orçar' ORDER BY id_cotacoes_veiculos ASC";
$execConnectionOrcar = executeQuery($connectionDB, $selectTableWhereOrcar);
$numLinhasOrcar = $execConnectionOrcar->num_rows;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
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
                <a id='opcaoEmAndamento' href="#emAndamento" data-target="cotacoesEmAndamento">
                    <img src="assets/clock.svg"> Em andamento
                </a>
            </li>

            <li>
                <a id="opcaoRespondido" href="#paraResponder" data-target="cotacoesParaResponder">
                    <img src="assets/answer.svg"> Responder
                </a>
            </li>

            <li>
                <a id='opcaoRejeitado' href="#rejeitado" data-target="cotacoesRejeitadas">
                    <img src="assets/triangle-exclamation.svg"> Rejeitado
                </a>
            </li>

            <li>
                <a id="opcaoParaResponder" href="#respondido" data-target="cotacoesRespondidas">
                    <img src="assets/check.svg"> Respondido
                </a>
            </li>
            <li>
                <a id='opcaoAprovado' href="#aprovado" data-target="cotacoesAprovadas">
                    <img src="assets/thumbs-up.svg"> Aprovado
                </a>
            </li>
            <li>
                <a id='opcaoReprovado' href="#reprovado" data-target='cotacoesReprovadas'>
                    <img src="assets/thumbs-down.svg"> Reprovado
                </a>
            </li>
            <li>
                <a id='opcaoFaturado' href="#faturado" data-target="cotacoesFaturadas">
                    <img src="assets/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a id='opcaoCancelado' href="#cancelado" data-target="cotacoesCanceladas">
                    <img src="assets/cancel.svg"> Cancelado
                </a>
            </li>
        </ul>
        <img id='logo-side-bar' src="assets/logo.svg" alt="">
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a id="menuText"> Menu <img src="assets/menu.svg"></a>
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="assets/Doorbell.svg">
            </div>
            <div id='userId' class="user-icon">
                <a id="nameLoggedUser"><?= $nameUser ?></a>
                <img src="assets/user.svg">
            </div>
        </div>
    </header>

    <!-- Corpo da página -->
    <div id="cotacoesEmAndamento" class="styleCotacoesOpcoes">
        <h1 class='actualPageTitle'><img src="assets/dark-clock.svg">Cotações em Andamento</h3>

            <div class="searchItens">
                <form action="verifications_index/configs_index.php" method="POST">
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
                                $selectTableOrgaosSolicitantes = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar=' ' ORDER BY id_cotacoes_veiculos ASC";
                                $execConnectionOrgaoSolicitante = $connectionDB->query($selectTableOrgaosSolicitantes);

                                while ($orgaoSolicitantes = mysqli_fetch_assoc($execConnectionOrgaoSolicitante)) {
                                    echo "<option value='" . $orgaoSolicitantes['id_cotacoes_veiculos'] . "'>" . $orgaoSolicitantes['orgao_solicitante_veiculo'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>

                        <div class="groupsSearchItens">
                            <form action="verifications_index/configs_index.php" method="POST">
                                <label class='filtrosPesquisa' id="orderBy" for="orderByInput">Ordenar</label>
                                <select name="orderByInput" id="orderByInput">
                                    <option name="numero_veiculo_decrescente" id="numero_veiculo_decrescente" value="numero_veiculo_decrescente">Por número (decrescente)</option>
                                    <option name="numero_veiculo_crescente" id="numero_veiculo_crescente" value="numero_veiculo_crescente">Por número (crescente)</option>
                                    <option name="placa_veiculo" id="placa_veiculo" value="placa_veiculo">Por placa </option>
                                    <option name="marca_veiculo" id="marca_veiculo" value="marca_veiculo">Por marca </option>
                                    <option name="modelo_veiculo" id="modelo_veiculo" value="modelo_veiculo">Por modelo </option>
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
                <form action="verifications_index/configs_index.php" method="POST">
                    <table>
                        <thead>
                            <tr>
                                <th class='titulosTabela'>Nº</th>
                                <th class='titulosTabela'>Placa</th>
                                <th class='titulosTabela'>Marca</th>
                                <th class='titulosTabela'>Modelo</th>
                                <th class='titulosTabela'>Ano</th>
                                <th class='titulosTabela'>Orgão solicitante</th>
                                <th class='titulosTabela'>Tipo Solicitação</th>
                                <th class='titulosTabela'>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($execConnection)) {
                                echo "<tr>";
                                echo "<td class='resultadosTabela'>" . $user_data['numero_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['placa_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['marca_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela'>" . $user_data['modelo_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['ano_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['orgao_solicitante_veiculo'] . "</td>";
                                echo "<td class='resultadosTabela' >" . $user_data['tipo_solicitacao'] . "</td>";
                                echo "<td class='resultadosTabela' ><button value='" . $user_data['id_cotacoes_veiculos'] . "' id='botaoOrcar' name='botaoOrcar' class='btn orcar'>Orçar</button> <button value='" . $user_data['id_cotacoes_veiculos'] . "' id='botaoRejeitar' name='botaoRejeitar' class='btn rejeitar'>Rejeitar</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
    </div>

    <div id="cotacoesParaResponder" class='hidden styleCotacoesOpcoes'>
        <h1 class='actualPageTitle'><img src="assets/answer-dark.svg">Cotações para Responder</h3>
            <?php echo "<p id='resultsFound'>Foram encontrado(s) " . $numLinhasOrcar . " serviço(s)</p>" ?>
            <br>
            <form action="verifications_index/configs_index.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th class='titulosTabela'>Nº</th>
                            <th class='titulosTabela'>Placa</th>
                            <th class='titulosTabela'>Marca</th>
                            <th class='titulosTabela'>Modelo</th>
                            <th class='titulosTabela'>Ano</th>
                            <th class='titulosTabela'>Orgão solicitante</th>
                            <th class='titulosTabela'>Tipo Solicitação</th>
                            <th class='titulosTabela'>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($user_data = mysqli_fetch_assoc($execConnectionOrcar)) {
                            echo "<tr>";
                            echo "<td class='resultadosTabela'>" . $user_data['numero_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['placa_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['marca_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela'>" . $user_data['modelo_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['ano_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['orgao_solicitante_veiculo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['tipo_solicitacao'] . "</td>";
                            echo "<td class='resultadosTabela' >Orçar</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>

    </div>


    <div id='cotacoesRespondidas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/check-dark.svg" alt="">Cotações Respondidas</h1>
    </div>

    <div id='cotacoesRejeitadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/triangle-exclamation-dark.svg" alt="">Cotações Rejeitadas</h1>
        <br>
        <?php echo "<p id='resultsFound'>Foram encontrado(s) " . $numLinhasRejeitar . " serviço(s)</p>" ?>
        <br>
        <table>
            <thead>
                <tr>
                    <th class='titulosTabela'>Nº</th>
                    <th class='titulosTabela'>Placa</th>
                    <th class='titulosTabela'>Marca</th>
                    <th class='titulosTabela'>Modelo</th>
                    <th class='titulosTabela'>Ano</th>
                    <th class='titulosTabela'>Orgão solicitante</th>
                    <th class='titulosTabela'>Tipo Solicitação</th>
                    <th class='titulosTabela'>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($user_data = mysqli_fetch_assoc($execConnectionRejeitar)) {
                    echo "<tr>";
                    echo "<td class='resultadosTabela'>" . $user_data['numero_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['placa_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['marca_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela'>" .  $user_data['modelo_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['ano_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['orgao_solicitante_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['tipo_solicitacao'] . "</td>";
                    echo "<td class='resultadosTabela'>Rejeitado</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id='cotacoesAprovadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/thumbs-up-dark.svg" alt="">Cotações Aprovadas</h1>
    </div>

    <div id='cotacoesReprovadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/thumbs-down-dark.svg" alt="">Cotações Reprovadas</h1>
    </div>

    <div id='cotacoesFaturadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/paper-black.svg" alt="">Cotações Faturadas</h1>
    </div>

    <div id='cotacoesCanceladas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/cancel-dark.svg" alt="">Cotações Canceladas</h1>
    </div>

    <script src="script.js"></script>

</body>

</html>
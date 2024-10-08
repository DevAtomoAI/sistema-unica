<?php
session_start();
include_once('database/config.php');

$nameUser = $_SESSION['nameLoggedUser'];

if ($_SESSION['emailSession'] == null && isset($_COOKIE['cookieLoginUser']) == false) {
    header('Location: login/login.php');
}

if (isset($_POST['pagina_fechada']) && isset($_COOKIE['cookieLoginUser']) == false) {
    $_SESSION['emailSession'] = null;
    header('Location: login/login.php');
}

$selectTable = $_SESSION['filtrosPesquisa'];

if(!$_SESSION['filtrosPesquisa']){
    $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar=''ORDER BY id_cotacoes_veiculos ";
}
// $selectTable = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar=''ORDER BY id_cotacoes_veiculos ";
$execConnection = $connectionDB->query($selectTable);
$numLinhasTotal = $execConnection->num_rows;

$selectTableWhereRejeitar = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='Rejeitar' ORDER BY id_cotacoes_veiculos ASC";
$execConnectionRejeitar = $connectionDB->query($selectTableWhereRejeitar);
$numLinhasRejeitar = $execConnectionRejeitar->num_rows;

$selectTableWhereOrcar = "SELECT * FROM cotacoes_veiculos WHERE opcao_orcar_rejeitar='Orçar' ORDER BY id_cotacoes_veiculos ASC";
$execConnectionOrcar = $connectionDB->query($selectTableWhereOrcar);
$numLinhasOrcar = $execConnectionOrcar->num_rows;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Main page</title>
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
                <a id='opcaoEmAndamento' href="#emAndamento">
                    <img src="assets/clock.svg"> Em andamento
                </a>
            </li>

            <li>
                <a id="opcaoRespondido" href="#respondido">
                    <img src="assets/check.svg"> Respondido
                </a>
            </li>
            <li>
                <a id='opcaoRejeitado' href="#rejeitado">
                    <img src="assets/triangle-exclamation.svg"> Rejeitado
                </a>
            </li>
            <li>
                <a id='opcaoAprovado' href="#aprovado">
                    <img src="assets/thumbs-up.svg"> Aprovado
                </a>
            </li>
            <li>
                <a id='opcaoReprovado' href="#reprovado">
                    <img src="assets/thumbs-down.svg"> Reprovado
                </a>
            </li>
            <li>
                <a id='opcaoFaturado' href="#faturado">
                    <img src="assets/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a id='opcaoCancelado' href="#cancelado">
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
            <div class="user-icon">
                <a id='nameLoggedUser'><?= $nameUser ?></a>
                <img src="assets/user.svg">
            </div>
        </div>
    </header>

    <!-- Corpo da página -->
    <div id="cotacoesEmAndamento" class='styleCotacoesOpcoes'>
        <h1 class='actualPageTitle'><img src="assets/dark-clock.svg">Cotações em Andamento</h3>

            <div class="searchItens">
                <form action="verifications_index/filtros_valores_em_andamento.php" method="POST">
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
                                        echo "<option value='".$orgaoSolicitantes['id_cotacoes_veiculos'] ."'>".$orgaoSolicitantes['orgao_solicitante_veiculo']."</option>";
                                    }
                                ?> 
                                
                            </select>
                        </div>

                        <div class="groupsSearchItens">
                            <form action="verifications_index/filtros_valores_em_andamento.php" method="POST"> 
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

                        <button class='filtrosPesquisa' type="submit" name="searchValuesOnGoing" id="searchValuesOnGoing"><img src="assets/lupa.svg" alt=""> Pesquisar</button>
                    </div>
                </form>
            </div>

            <div class="resultSearch">
                <?php echo "<p id='resultsFound'>Foram encontrado(s) ". $numLinhasTotal ." serviço(s)</p>"?>
                <br>
                <form action="verifications_index/botao_orcar_rejeitar.php" method="POST">
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

    <div id='cotacoesRespondidas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/check-dark.svg" alt="">Cotações Respondidas</h1>
        <br>
        <?php echo "<p id='resultsFound'>Foram encontrado(s) ". $numLinhasOrcar ." serviço(s)</p>"?>
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
                while ($user_data = mysqli_fetch_assoc($execConnectionOrcar)) {
                    echo "<tr>";
                    echo "<td class='resultadosTabela'>" . $user_data['numero_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['placa_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['marca_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela'>" . $user_data['modelo_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['ano_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['orgao_solicitante_veiculo'] . "</td>";
                    echo "<td class='resultadosTabela' >" . $user_data['tipo_solicitacao'] . "</td>";
                    echo "<td class='resultadosTabela'>Orçar</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id='cotacoesRejeitadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/triangle-exclamation-dark.svg" alt="">Rejeitado</h1>
        <br>
        <?php echo "<p id='resultsFound'>Foram encontrado(s) ". $numLinhasRejeitar ." serviço(s)</p>"?>
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
        <h1><img src="assets/thumbs-up-dark.svg" alt="">Aprovado</h1>
    </div>

    <div id='cotacoesReprovadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/thumbs-down-dark.svg" alt="">Reprovado</h1>
    </div>

    <div id='cotacoesFaturadas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/paper-black.svg" alt="">Faturado</h1>
    </div>

    <div id='cotacoesCanceladas' class="hidden styleCotacoesOpcoes">
        <h1><img src="assets/cancel-dark.svg" alt="">Cancelado</h1>
    </div>

    <script src="script.js"></script>

</body>

</html>
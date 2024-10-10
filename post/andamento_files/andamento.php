<?php
session_start();
include_once("../database/config.php");

if (isset($_SESSION['nome'])) {
    $nomeUsuario = $_SESSION['nome'];
} else {
    $nomeUsuario = "Convidado"; // Se não estiver logado, exibe "Convidado"
}

$selectTableEmAndamento = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY id ASC";
$execConnectionEmAndamento = $conexao->query($selectTableEmAndamento);
$numLinhasEmAndamento = $execConnectionEmAndamento->num_rows;
 
if(!empty($_SESSION['filtrosPesquisa'])) {
    $selectTable = $_SESSION['filtrosPesquisa'];
}

else{
    $selectTable = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY id ";
}

$execConnection = $conexao->query($selectTable);
$numLinhasTotal = $execConnection->num_rows;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em andamento</title>
    <link rel="stylesheet" href="andamento.css">
    <link rel="shortcut icon" href="icone.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button id="closeBtn">&times;</button>
        </div>
        <ul class="nav-options">
            <li><a href="../dados_files/dados.php"><img src="../imgs/dados.svg"> Meus dados</a></li>
            <li><a href="../incluir_files/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="andamento.php"><img src="../imgs/clock.svg"> Em andamento</a></li>
            <li><a href="../aprovado_files/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="#faturado"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="#cancelado"><img src="../imgs/cancel.svg"> Cancelado</a></li>
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
                <p><?php echo $nomeUsuario; ?></p>
            </div>

            <div class="user-icon"><img src="../imgs/user.svg"></div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->
    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações em Andamento</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_andamento.php" method="POST">
                <input name='palavra-chave'type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
                    <?php
                    $selectTableOrgaosSolicitantes = "SELECT * FROM cotacoes_em_andamento WHERE opcao_aprovada_rejeitada='' ORDER BY id ASC";
                    $execConnectionOrgaoSolicitante = $conexao->query($selectTableOrgaosSolicitantes);

                    while ($orgaoSolicitantes = mysqli_fetch_assoc($execConnectionOrgaoSolicitante)) {
                        echo "<option value='" . $orgaoSolicitantes['id'] . "'>" . $orgaoSolicitantes['centro_custo'] . "</option>";
                    }

                    ?>
                </select>
                <input type="text" placeholder="Placa">
                <select name="ordenar-por">
                    <option value="">Ordenar</option>
                    <option name="numero_veiculo_decrescente" id="numero_veiculo_decrescente" value="numero_veiculo_decrescente">Por número (decrescente)</option>
                    <option name="numero_veiculo_crescente" id="numero_veiculo_crescente" value="numero_veiculo_crescente">Por número (crescente)</option>
                    <option name="placa_veiculo" id="placa_veiculo" value="placa">Por placa </option>
                    <!-- <option name="marca_veiculo" id="marca_veiculo" value="marca_veiculo">Por marca </option> -->
                    <!-- <option name="modelo_veiculo" id="modelo_veiculo" value="modelo_veiculo">Por modelo </option> -->
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
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Centro de Custo</th>
                        <th>Propostas</th>
                        <th>Data de Abertura</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <!-- <form action="configs_andamento.php" method="POST"> -->
                    <tbody id="cotacoes-body">
                        <!-- Conteúdo da tabela será inserido dinamicamente -->
                        <?php
                        while ($user_data = mysqli_fetch_assoc($execConnection)) {
                            echo "<tr>";
                            echo "<td class='resultadosTabela'>" . $user_data['id'] . "<button class='info-btn' onclick='abrirPopUp()'><i class='fas fa-info-circle'></i></button></td>";
                            echo "<td class='resultadosTabela' >" . $user_data['placa'] . "</td>";
                            echo "<td class='resultadosTabela' >".$user_data['modelo_contratacao']."</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['centro_custo'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['propostas'] . "</td>";
                            echo "<td class='resultadosTabela' >" . $user_data['data_abertura'] . "</td>";
                            echo "<td class='resultadosTabela' > <button name='button-option-aproved' class='btn-action btn-green' value='" . $user_data['id'] . "'><i class='fas fa-check'></i></button> <button name='button-option-rejected' class='btn-action btn-red' value='" . $user_data['id'] . "'><i class='fas fa-times'></i></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                <!-- </form> -->
            </table>
        </div>

        <!-- Estrutura do Pop-up -->
        <div id="popup" class="popup" style="display: none;">
            <div class="popup-content">
                <span class="close-btn" onclick="fecharPopUp()">&times;</span>
                <h3 class="popup-title">Informações</h3>
                <div class="popup-details">
                    <div class="popup-column">
                        <p><strong>Veículo:</strong> <span id="veiculo"></span></p>
                        <p><strong>Km Atual:</strong> <span id="kmAtual"></span></p>
                        <p><strong>Plano de Manutenção:</strong> <span id="planoManutencao"></span></p>
                        <p><strong>Modelo de Contratação:</strong> <span id="modeloContratacao"></span></p>
                        <p><strong>Data de Abertura:</strong> <span id="dataAbertura"></span></p>
                        <p><strong>Data Final de Recebimento:</strong> <span id="dataRecebimento"></span></p>
                    </div>
                    <div class="popup-column">
                        <p><strong>Centro de Custo:</strong> <span id="centroCusto"></span></p>
                        <p><strong>Tipo de Solicitação:</strong> <span id="tipoSolicitacao"></span></p>
                        <p><strong>Fornecedor:</strong> <span id="fornecedor"></span></p>
                        <p><strong>Responsável:</strong> <span id="responsavel"></span></p>
                        <p><strong>Propostas:</strong> <span id="propostas"></span></p>
                        <p><strong>Anexo:</strong> <i class="fas fa-file-alt"></i></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay para escurecer o fundo -->
        <div id="popup-overlay" class="popup-overlay" style="display: none;" onclick="fecharPopUp()"></div>

    </div>

    <script src="andamento.js">

    </script>

</body>

</html>
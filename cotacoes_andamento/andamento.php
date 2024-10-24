<?php
session_start();
include_once("../database/config.php");

$nomeUsuario = $_SESSION["nameLoggedUser"];
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

if (!empty($_SESSION['filtrosPesquisa'])) {
    $selectTable = $_SESSION['filtrosPesquisa'];
} else {
    $selectTable = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='' AND id_orgao_publico ='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos ASC ";
}

$execConnection = $conexao->query($selectTable);
$numLinhasTotal = $execConnection->num_rows;

// Criar o array de cotações
$cotacoes = [];
while ($user_data = mysqli_fetch_assoc($execConnection)) {
    $cotacoes[] = [
        'id' => $user_data['id_infos_veiculos_inclusos'],
        'veiculo' => $user_data['veiculo'],
        'kmAtual' => $user_data['km_atual'],
        'planoManutencao' => $user_data['plano_manutencao'],
        'modeloContratacao' => $user_data['modelo_contratacao'],
        'modeloVeiculo' => $user_data['modelo_veiculo'],
        'dataAbertura' => $user_data['data_abertura'],
        'dataRecebimento' => $user_data['data_final'],
        'centroCusto' => $user_data['centro_custo'],
        'tipoSolicitacao' => $user_data['tipo_solicitacao'],
        'fornecedor' => $user_data['fornecedor'],
        'responsavel' => $user_data['responsavel'],
        'placa' => $user_data['placa'],
        'propostas' => $user_data['propostas'],
        'anoVeiculo' => $user_data['ano_veiculo']
    ];
}

// Passar as cotações para o JavaScript
echo "<script>var cotacoes = " . json_encode($cotacoes) . ";</script>";
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

        <ul class="nav-options">
            <li><a href="../dados/dados.php"><img src="../imgs/dados.svg"> Meus dados</a></li>
            <li><a href="../incluir_cotacao/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="andamento.php"><img src="../imgs/clock.svg"> Em andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="../cotacoes_faturadas/faturadas.php"><img src="../imgs/paper.svg"> Faturado</a></li>
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
        <h1 class="text-cotand">Cotações em Andamento</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_andamento.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
                    <?php
                    $selectTableOrgaosSolicitantes = "SELECT * FROM infos_veiculos_inclusos WHERE opcao_aprovada_reprovada_oficina='' ORDER BY id_infos_veiculos_inclusos ASC";
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
                        <th>Veiculo</th>
                        <th>Modelo</th>
                        <th>Centro de Custo</th>
                        <th>Justificativa</th>
                        <th>Data de Abertura</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody id="cotacoes-body">
                    <!-- Conteúdo da tabela será inserido dinamicamente -->
                    <?php
                        foreach ($cotacoes as $cotacao) {

                            echo "<tr>";
                            echo "<td class='resultadosTabela'>" . $cotacao['id'] . 
                                "<button class='info-btn' onclick='abrirPopUp(" . $cotacao['id'] . ")'><i class='fas fa-info-circle'></i></button></td>";
                            echo "<td class='resultadosTabela'>" . $cotacao['veiculo'] . "</td>";
                            echo "<td class='resultadosTabela'>" . $cotacao['modeloContratacao'] . "</td>";
                            echo "<td class='resultadosTabela'>" . $cotacao['centroCusto'] . "</td>";
                            echo "<td class='resultadosTabela'>" . $cotacao['propostas'] . "</td>";
                            echo "<td class='resultadosTabela'>" . $cotacao['dataAbertura'] . "</td>";
                            echo "<td class='resultadosTabela'>
                                  <form method='POST' action='configs_andamento.php'>
                                    <button name='button-option-aproved' class='btn-action btn-green' value='" . $cotacao['id'] . "'>
                                        Gerenciar<i class='fas fa-check'></i>
                                    </button>
                                    <button name='button-option-rejected' class='btn-action btn-red' value='" . $cotacao['id'] . "'>
                                        <i class='fas fa-times'></i>
                                    </button>
                                    </form>
                            </td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
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
                        <p><strong>Placa:</strong> <span id="placa"></span></p>
                        <p><strong>Ano veículo:</strong> <span id="anoVeiculo"></span></p>

                    </div>
                    <div class="popup-column">
                        <p><strong>Modelo de Contratação:</strong> <span id="modeloContratacao"></span></p>
                        <p><strong>Data de Abertura:</strong> <span id="dataAbertura"></span></p>
                        <p><strong>Data de Recebimento:</strong> <span id="dataRecebimento"></span></p>
                    </div>
                    <div class="popup-column">
                        <p><strong>Centro de Custo:</strong> <span id="centroCusto"></span></p>
                        <p><strong>Tipo de Solicitação:</strong> <span id="tipoSolicitacao"></span></p>
                        <p><strong>Fornecedor:</strong> <span id="fornecedor"></span></p>
                        <p><strong>Responsável:</strong> <span id="responsavel"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay para o pop-up -->
        <div id="popup-overlay" class="popup-overlay" style="display: none;" onclick="fecharPopUp()"></div>
    </div>

    <script src="andamento.js"></script>
</body>

</html>
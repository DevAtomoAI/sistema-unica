<?php
session_start();
include_once("../database/config.php");

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
$nomeUsuario = $_SESSION["nameLoggedUser"];
$idVeiculosInclusosOrgaoPublico = $_SESSION["idVeiculosInclusosOrgaoPublico"];

function checkUserLoggedIn() {
    if (!isset($_SESSION['emailLoggedUser']) || $_SESSION['emailLoggedUser'] == null) {
        header('Location: ../index.php');
        exit;
    }
}
checkUserLoggedIn();

$selectTableAprovadas = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Aprovada' AND id_orgao_publico='$idOrgaoPublicoLogado' ";
if(isset($_SESSION['filtrosPesquisaAprovada']) && !empty($_SESSION['filtrosPesquisaAprovada'])) {
    $selectTableAprovadas = $_SESSION['filtrosPesquisaAprovada'];
}

$_SESSION['filtrosPesquisaAprovada'] = null;

$execConnectionAprovadas = $conexao->query($selectTableAprovadas);
$numLinhasAprovadas = $execConnectionAprovadas->num_rows;

$idVeiculosInclusosOrgaoPublico = $cotacoes[0]['id'] ?? null;
$_SESSION['idVeiculosInclusosOrgaoPublico'] = $idVeiculosInclusosOrgaoPublico;


// if ($idVeiculosInclusosOrgaoPublico) {
//     $selectTable2 = "SELECT * FROM infos_veiculos_inclusos 
//                 WHERE id_veiculo_incluso_orgao_publico = $idVeiculosInclusosOrgaoPublico AND id_orgao_publico='$idOrgaoPublicoLogado' AND orcamento_aprovada_reprovada_oficina!='Aprovada'
//                 AND orcamento_aprovado_reprovado!='Cancelada'";
//     $numLinhasTotal2 = $conexao->query($selectTable2)->num_rows;

//     $selectTable3 = "SELECT * FROM infos_veiculos_inclusos 
//                      WHERE orcamento_aprovada_reprovada_oficina = '' AND
//                      id_veiculo_incluso_orgao_publico = $idVeiculosInclusosOrgaoPublico 
//                      AND id_orgao_publico = '$idOrgaoPublicoLogado'";
//     $numLinhasTotal3 = $conexao->query($selectTable3)->num_rows;

//     $selectTable4 = "SELECT veiculo FROM infos_veiculos_inclusos 
//                      WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
//                      AND id_infos_veiculos_inclusos = '$idVeiculosInclusosOrgaoPublico'";
//     $nomeVeiculo = $conexao->query($selectTable4)->fetch_assoc()['veiculo'] ?? '';
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovado</title>
    <link rel="stylesheet" href="aprovado.css">
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
                <a href="aprovado.php">
                    <img src="../imgs/check.svg"> Aprovado
                </a>
            </li>
            <li>
                <a href="../cotacoes_faturadas/faturadas.php">
                    <img src="../imgs/paper.svg"> Faturado
                </a>
            </li>
            <li>
                <a href="../cotacoes_cancelado/cancelado.php">
                    <img src="../imgs/cancel.svg"> Cancelado
                </a>
            </li>

            
<div class="logotype"> 
<img src="../imgs/biglogo.svg">
</div>

        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a> <img src="../imgs/menu.svg"> </a>
            </div>

            <div id="menu-options" class="menu-options">
                <div class="option"><a href="../dados/dados.php">Meus dados</a></div>
                <div class="option"><a href="#">Painel de Gestão</a></div>
                <div class="option"><a href="../frota/frota.php">Frota</a></div>
                <div class="option"><a href="../fornecedores/fornecedores.php">Fornecedores</a></div>
                <div class="option"><a href="#opcao3">Relatório</a></div>
            </div>

            <div class="logo">
                <img src="../imgs/minilogo.svg">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <?= $_SESSION['notificacao']  ?><img src="../imgs/Doorbell.svg">
            </div>

            <div class="user-name">
                <p><?= $nomeUsuario ?></p>
            </div>


            <div class="user-icon">
                <img src="../imgs/user.svg">
            </div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->

    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações aprovadas</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_aprovado.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
                    <?php
                    $selectTableOrgaosSolicitantes = "SELECT * FROM infos_veiculos_inclusos WHERE orcamento_aprovada_reprovada_oficina='Aprovada' AND id_orgao_publico='$idOrgaoPublicoLogado' ORDER BY id_infos_veiculos_inclusos ASC";
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
                </select>
                <button id='search-btn' class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
                <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
            </form>
        </div>

        <!-- Tabela de cotações aprovadas -->
        <div class="table-responsive">
            <p>Foram encontrados <?=$numLinhasAprovadas ?> registros </p>
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Fatura serviços</th>
                        <th>Fatura peças</th>
                        <th>Centro de Custo</th>
                        <th>Opção</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Tabela dinâmica -->
                    <?php
                    while ($user_data = mysqli_fetch_assoc($execConnectionAprovadas)) {
                        echo "<tr>";
                        echo "<td class='resultadosTabela'>" . $user_data['id_infos_veiculos_inclusos'] . "</td>";
                        echo "<td class='resultadosTabela' >FATURA SERVICO ADD INFOS VEICULOS INCLUSOS";
                        echo "<td class='resultadosTabela' > FATURA PECAS ADD INFOS VEICULOS INCLUSOS</td>";
                        echo "<td class='resultadosTabela' >" . $user_data['centro_custo'] ."</td>";
                        echo "<td class='resultadosTabela' > <button name='button-option-aproved' class='btn-action btn-green' value='" . $user_data['id_infos_veiculos_inclusos'] . "'>Faturar<i class='fas fa-check'></i></button>
                         <button name='button-option-rejected' class='btn-action btn-red' value='" . $user_data['id_infos_veiculos_inclusos'] . "'>Cancelar<i class='fas fa-times'></i></button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <script src="aprovado.js"></script>
</body>

</html>
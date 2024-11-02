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

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
$nomeUsuario = $_SESSION["nameLoggedUser"];

// Consulta para obter os dados do usuário
$selectTable = "SELECT * FROM usuarios_orgao_publico WHERE nome='$nomeUsuario' AND id_usuarios_orgao_publico='$idOrgaoPublicoLogado'";
$execConnection = $conexao->query($selectTable);
$user_data = mysqli_fetch_assoc($execConnection);

// Inicialize a variável $centrosCustos
$centrosCustos = [];

// Aqui você deve fazer a consulta para obter os centros de custo
$queryCentrosCustos = "SELECT * FROM centros_custos WHERE id_orgao_publico='$idOrgaoPublicoLogado'";
$resultCentros = $conexao->query($queryCentrosCustos);

// Verifica se a consulta retornou resultados
if ($resultCentros->num_rows > 0) {
    while ($row = $resultCentros->fetch_assoc()) {
        $centrosCustos[] = $row; // Adiciona cada centro de custo ao array
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus dados</title>
    <link rel="stylesheet" href="dados.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="dados.js"></script>
</head>

<body>
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
            <div class="user-name">
                <p><?= $nomeUsuario; ?></p>
            </div>
            <div class="user-icon">
                <img src="../imgs/user.svg">
            </div>
        </div>
    </header>

    <div class="main-content">
        <h1>Meus Dados</h1>

        <h2>Dados do Órgão:</h2>
        <form action="config_dados.php" method="POST">
            <div class="table-responsive">
                <table id="tabela-orgao">
                    <tr>
                        <th>Nº do Contrato</th>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Contato</th>
                        <th>E-mail</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="num_contrato" value="<?= $user_data['num_contrato'] ?>" required></td>
                        <td><input type="text" name="razao_social" value="<?= $user_data['razao_social'] ?>" required></td>
                        <td><input type="text" name="cnpj" value="<?= $user_data['identificacao_cnpj'] ?>" required></td>
                        <td><input type="text" name="responsavel" value="<?= $user_data['responsavel'] ?>" required></td>
                        <td><input type="text" name="contato" value="<?= $user_data['contato'] ?>" required></td>
                        <td><input type="email" name="email" value="<?= $user_data['email'] ?>" required></td>
                    </tr>
                </table>
                <button class="button" name="enviaDadosOrgao">Enviar Dados do Órgão</button>
            </div>
        </form>

        <h2>Dados dos Centros de Custo:</h2>
        <form action="config_dados.php" method="POST">
            <div class="table-responsive">
                <table id="tabela-centro">
                    <tr>
                        <th>Nome</th>
                        <th>Valor do Contrato</th>
                        <th>Fonte de Recurso</th>
                        <th>Data do Crédito</th>
                        <th>Nº Ordem Bancária</th>
                        <th>Valor do Crédito</th>
                    </tr>
                    <?php foreach ($centrosCustos as $centro): ?>
                        <tr>
                            <td><input type="text" name="nomeCentro[]" value="<?= htmlspecialchars($centro['nome']) ?>" required></td>
                            <td><input type="text" name="valorContrato[]" value="<?= htmlspecialchars($centro['valor_contrato']) ?>" required></td>
                            <td><input type="text" name="fonteRecurso[]" value="<?= htmlspecialchars($centro['fonte_recurso']) ?>" required></td>
                            <td><input type="date" name="dataCredito[]" value="<?= htmlspecialchars($centro['data_credito']) ?>" required></td>
                            <td><input type="text" name="ordemBancaria[]" value="<?= htmlspecialchars($centro['num_ordem_bancaria']) ?>" required></td>
                            <td><input type="text" name="valorCredito[]" value="<?= htmlspecialchars($centro['valor_credito']) ?>" required></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <button type="button" onclick="novosCentros(event)">Adicionar novo centro</button>

            <button class="button" name="salvaValoresCentroCustos">Enviar Dados do Centro de Custo</button>
        </form>
    </div>

    <a href="../cotacoes_andamento/andamento.php">Voltar</a>

</body>
</html>

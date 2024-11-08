<?php
include_once('../database/config.php');
session_start();

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];
$nomeCentrosCustoGeral = []; //pega todos os centros, geral
$valorCreditoCentroCustos = [];
$centroCustoGastou = []; //é 'proporcional' ao array de valores gastos totais por centro, para poder fazer comparacao caso seja necessário
$valorTotalGasto = [];



$selectCentrosCustos = "SELECT nome, valor_credito FROM centros_custos WHERE id_orgao_publico = '$idOrgaoPublicoLogado'";
$resultCentrosCustos = $conexao->query($selectCentrosCustos);
while ($valoresCentrosCusto = $resultCentrosCustos->fetch_assoc()) {
    array_push($nomeCentrosCustoGeral, $valoresCentrosCusto['nome']);
    array_push($valorCreditoCentroCustos, $valoresCentrosCusto['valor_credito']);
}

$selectIdVeiculoInclusoFaturadoOP = "SELECT id_infos_veiculos_inclusos, centro_custo FROM infos_veiculos_inclusos 
WHERE id_orgao_publico = '$idOrgaoPublicoLogado' AND orcamento_aprovada_reprovada_oficina = 'Faturado Órgão Público'";
$resultIdVeiculoInclusoFaturadoOP = $conexao->query($selectIdVeiculoInclusoFaturadoOP);

while ($valoresIdVeiculoInclusoFaturadoOP = $resultIdVeiculoInclusoFaturadoOP->fetch_assoc()) {
    $idVeiculoInclusoOrgao = $valoresIdVeiculoInclusoFaturadoOP['id_infos_veiculos_inclusos'];
    array_push($centroCustoGastou, $valoresIdVeiculoInclusoFaturadoOP['centro_custo']);
    $selectSumValorGastoCentroCusto = "SELECT SUM(valor_total_final) AS total_gasto_centro_custo FROM infos_cotacao_orgao 
    WHERE id_veiculo_incluso_orgao_publico='$idVeiculoInclusoOrgao' AND id_orgao_publico='$idOrgaoPublicoLogado'";
    $resultSumValorGastoCentroCusto = $conexao->query($selectSumValorGastoCentroCusto);

    while ($valoresSumValorGastoCentroCusto = $resultSumValorGastoCentroCusto->fetch_assoc()) {
        array_push($valorTotalGasto, $valoresSumValorGastoCentroCusto['total_gasto_centro_custo']);
    }
}

print_r($nomeCentrosCustoGeral);
echo "<br>";
print_r($valorCreditoCentroCustos);
echo "<br>";
print_r($valorTotalGasto);
echo "<br>";
print_r($centroCustoGastou);
echo "<br>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico Atualizado em Tempo Real</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-container {
            width: 80%;
            margin: 20px auto;
        }

        .form-container {
            width: 80%;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }
    </style>
    <link rel="stylesheet" href="gestao.css">
</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <ul class="nav-options">
            <li><a href="../incluir_cotacao/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="../cotacoes_andamento/andamento.php"><img src="../imgs/clock.svg">Andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="../cotacoes_faturadas/faturadas.php"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="../cotacoes_cancelado/cancelado.php"><img src="../imgs/cancel.svg"> Cancelado</a></li>
            <div class="logotype"> <img src="../imgs/biglogo.svg"></div>
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
                <div class="option"><a href="#">Painel de Gestão</a></div>
                <div class="option"><a href="../frota/frota.php">Frota</a></div>
                <div class="option"><a href="../fornecedores/fornecedores.php">Fornecedores</a></div>
                <div class="option"><a href="#opcao3">Relatório</a></div>
            </div>

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
        <h1 class="text-cotand">Painel de gestão</h1>

        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>

        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const nomeCentrosCustoGeral = <?php echo json_encode($nomeCentrosCustoGeral); ?>;
            const valorCreditoCentroCustos = <?php echo json_encode($valorCreditoCentroCustos); ?>;
            const valorTotalGasto = <?php echo json_encode($valorTotalGasto); ?>;
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nomeCentrosCustoGeral,
                    datasets: [{
                            label: 'Valor Total',
                            data: valorCreditoCentroCustos,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Valor Gasto',
                            data: valorTotalGasto,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Função para atualizar os dados
            function atualizarDados() {
                const total = valorCreditoCentroCustos;
                const gasto = valorTotalGasto;

                myChart.data.datasets[0].data = total;
                myChart.data.datasets[1].data = gasto;
                myChart.update();
            }

            document.addEventListener("DOMContentLoaded", () => {
                const cards = document.querySelectorAll(".card");
                setTimeout(() => {
                    cards.forEach(card => {
                        card.classList.add("fade-in");
                    });
                }, 300);
            });
        </script>

        <!-- Estrutura do Pop-up -->

    </div>
    <!-- 
    <div class="card-container">
        <div class="card fade-in">
            <h3>Gastos Totais</h3>
            <p>R$ 354.930</p>
        </div>
        <div class="card fade-in">
            <h3>Manutenção Preventiva</h3>
            <p>R$ 5.793</p>
            <span>1,6%</span>
        </div>
        <div class="card fade-in">
            <h3>Peças de Reposição</h3>
            <p>R$ 31.736</p>
            <span>8,9%</span>
        </div>
    </div> -->

</body>
<script src="gestao.js"></script>

</html>
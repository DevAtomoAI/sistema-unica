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
    
        <div class="form-container">
            <h3>Insira os valores para cada secretaria:</h3>
            <label>SECRETARIA DE DESENVOLVIMENTO</label>
            <input type="number" id="devTotal" placeholder="Valor Total">
            <input type="number" id="devGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE EDUCAÇÃO</label>
            <input type="number" id="eduTotal" placeholder="Valor Total">
            <input type="number" id="eduGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE OBRAS</label>
            <input type="number" id="obrasTotal" placeholder="Valor Total">
            <input type="number" id="obrasGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE ASSISTÊNCIA SOCIAL</label>
            <input type="number" id="assistenciaTotal" placeholder="Valor Total">
            <input type="number" id="assistenciaGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE MEIO AMBIENTE</label>
            <input type="number" id="meioAmbienteTotal" placeholder="Valor Total">
            <input type="number" id="meioAmbienteGasto" placeholder="Valor Gasto">
    
            <label>GABINETE DO PREFEITO</label>
            <input type="number" id="gabineteTotal" placeholder="Valor Total">
            <input type="number" id="gabineteGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE ADMINISTRAÇÃO</label>
            <input type="number" id="admTotal" placeholder="Valor Total">
            <input type="number" id="admGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE ESPORTES</label>
            <input type="number" id="esportesTotal" placeholder="Valor Total">
            <input type="number" id="esportesGasto" placeholder="Valor Gasto">
    
            <label>SECRETARIA DE FINANÇAS</label>
            <input type="number" id="financasTotal" placeholder="Valor Total">
            <input type="number" id="financasGasto" placeholder="Valor Gasto">
    
            <button onclick="atualizarDados()">Atualizar Gráfico</button>
        </div>
        
         <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    // centros vindos do banco
                ],
                datasets: [
                    {
                        label: 'Valor Total',
                        data: [400000, 145000, 80000, 21000, 20000, 14000, 10000, 5000, 5000],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Valor Gasto',
                        data: [350000, 95000, 75000, 19105.5, 20000, 8000, 9000, 5000, 3100],
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: { stacked: true },
                    y: { beginAtZero: true }
                }
            }
        });

        // Função para atualizar os dados
        function atualizarDados() {
            const total = [
                parseFloat(document.getElementById('devTotal').value) || 0,
                parseFloat(document.getElementById('eduTotal').value) || 0,
                parseFloat(document.getElementById('obrasTotal').value) || 0,
                parseFloat(document.getElementById('assistenciaTotal').value) || 0,
                parseFloat(document.getElementById('meioAmbienteTotal').value) || 0,
                parseFloat(document.getElementById('gabineteTotal').value) || 0,
                parseFloat(document.getElementById('admTotal').value) || 0,
                parseFloat(document.getElementById('esportesTotal').value) || 0,
                parseFloat(document.getElementById('financasTotal').value) || 0
            ];

            const gasto = [
                parseFloat(document.getElementById('devGasto').value) || 0,
                parseFloat(document.getElementById('eduGasto').value) || 0,
                parseFloat(document.getElementById('obrasGasto').value) || 0,
                parseFloat(document.getElementById('assistenciaGasto').value) || 0,
                parseFloat(document.getElementById('meioAmbienteGasto').value) || 0,
                parseFloat(document.getElementById('gabineteGasto').value) || 0,
                parseFloat(document.getElementById('admGasto').value) || 0,
                parseFloat(document.getElementById('esportesGasto').value) || 0,
                parseFloat(document.getElementById('financasGasto').value) || 0
            ];

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
    </div>

</body>
<script src="gestao.js"></script>
</html>
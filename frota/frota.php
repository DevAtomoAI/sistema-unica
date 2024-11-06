<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frota</title>
    <link rel="stylesheet" href="frota.css">
    <link rel="shortcut icon" href="icone.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">

        <ul class="nav-options">
            <!-- <li><a href="../dados/dados.php"><img src="../imgs/dados.svg"> Meus dados</a></li> -->
            <li><a href="../incluir_cotacao/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="../cotacoes_andamento/andamento.php"><img src="../imgs/clock.svg">Andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="../cotacoes_faturadas/faturadas.php"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="../cotacoes_cancelado/cancelado.php"><img src="../imgs/cancel.svg"> Cancelado</a></li>
            <div class="logotype"> 
                <img src="../imgs/biglogo.svg">
            </div>
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
                <div class="option"><a href="../gestao/gestao.php">Painel de Gestão</a></div>
                <div class="option"><a href="../frota/frota.php">Frota</a></div>
                <div class="option"><a href="../fornecedores/fornecedores.php">Fornecedores</a>
            </div>
    <div class="option"><a href="#opcao3">Relatório</a></div>
    <!-- Adicione mais opções conforme necessário -->
</div>
            <div class="logo"><img src="../imgs/minilogo.svg"></div>
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
        <h1 class="text-cotand">Frota</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <form action="configs_andamento.php" method="POST">
                <input name='palavra-chave' type="text" placeholder="Busca">
                <select name="centro-custo">
                    <option value="">Centro de Custo</option>
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
                <!-- Arrumar aqui -->
                <a class="incluir-frota" href="../frota/incluir_frota/incluirfrota.php"> Incluir </a>
            </form>
        </div>

        <!-- Tabela de cotações com ícones -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Id/Carro</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Proprietário</th>
                        <th>Cor</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody id="cotacoes-body">
                    <!-- Conteúdo da tabela será inserido dinamicamente -->
              
                </tbody>
            </table>
        </div>

       

    <script src="frota.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="relatorio.css">
</head>
<body>

    <div class="overlay" id="overlay"></div>

    <!-- Barra lateral -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header"></div>
        <ul class="nav-options">
            <li><a href="../incluir_cotacao/incluir.php"><img src="../imgs/time.svg"> Incluir</a></li>
            <li><a href="../cotacoes_andamento/andamento.php"><img src="../imgs/clock.svg"> Em andamento</a></li>
            <li><a href="../cotacoes_aprovado/aprovado.php"><img src="../imgs/check.svg"> Aprovado</a></li>
            <li><a href="../cotacoes_faturadas/faturadas.php"><img src="../imgs/paper.svg"> Faturado</a></li>
            <li><a href="../cotacoes_cancelado/cancelado.php"><img src="../imgs/cancel.svg"> Cancelado</a></li>
            <div class="logotype"><img src="../imgs/biglogo.svg"></div>
        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
                <a><img src="../imgs/menu.svg"></a>
            </div>
            <div id="menu-options" class="menu-options">
                <div class="option"><a href="../dados/dados.php">Meus dados</a></div>
                <div class="option"><a href="../gestao/gestao.php">Painel de Gestão</a></div>
                <div class="option"><a href="../frota/frota.php">Frota</a></div>
                <div class="option"><a href="../fornecedores/fornecedores.php">Fornecedores</a></div>
                <div class="option"><a href="../relatorio/relatorio.php">Relatório</a></div>
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon"></div>
            <div class="user-name"></div>
            <div class="user-icon"><img src="../imgs/user.svg"></div>
        </div>
    </header>

    <!-- CONTEUDO PRINCIPAL -->
    <div class="main-content" id="main-content">
        <h1 class="text-cotand">Relatório</h1>

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
                    <option name="placa_veiculo" id="placa_veiculo" value="placa">Por placa</option>
                </select>
                <button id='search-btn' class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
                <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
            </form>
        </div>

        <!-- Tabela de cotações aprovadas -->
        <div class="table-responsive">
            <?php
            // Consulta SQL para buscar dados do relatório
            $sqlRelatorio = "SELECT 
                                data_abertura AS data_compra,
                                descricao_pecas AS pecas,
                                fornecedor,
                                valor_total_final AS valor_gasto
                             FROM 
                                infos_cotacao_orgao
                             WHERE 
                                orcamento_aprovada_reprovada_oficina = 'Aprovada'
                             ORDER BY 
                                data_abertura DESC";
            $resultRelatorio = $conexao->query($sqlRelatorio);

            if ($resultRelatorio && $resultRelatorio->num_rows > 0) {
                echo "<p>Foram encontrados {$resultRelatorio->num_rows} registros</p>";
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>Data de compra</th>
                            <th>Peças</th>
                            <th>Fornecedor</th>
                            <th>Valor gasto</th>
                        </tr>
                      </thead>
                      <tbody>";

                // Exibindo os dados na tabela
                while ($row = $resultRelatorio->fetch_assoc()) {
                    echo "<tr>
                            <td>" . date("d/m/Y", strtotime($row['data_compra'])) . "</td>
                            <td>" . htmlspecialchars($row['pecas']) . "</td>
                            <td>" . htmlspecialchars($row['fornecedor']) . "</td>
                            <td>R$ " . number_format($row['valor_gasto'], 2, ',', '.') . "</td>
                          </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p>Nenhum registro encontrado.</p>";
            }
            ?>
        </div>
    </div>
    <script src="relatorio.js"></script>

</body>
</html>

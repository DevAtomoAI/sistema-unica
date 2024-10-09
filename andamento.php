
<?php
session_start();
if(isset($_SESSION['nome'])) {
    $nomeUsuario = $_SESSION['nome'];
} else {
    $nomeUsuario = "Convidado"; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Em andamento</title>
    <link rel="stylesheet" href="andamento.css?v=<?php echo time(); ?>">
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
            <li><a href="dados.php"><img src="./imgs/dados.svg"> Meus dados</a></li>
            <li><a href="incluir.php"><img src="./imgs/time.svg"> Incluir</a></li>
            <li><a href="andamento.php"><img src="./imgs/clock.svg"> Em andamento</a></li>
            <li><a href="aprovado.php"><img src="./imgs/check.svg"> Aprovado</a></li>
            <li><a href="#faturado"><img src="./imgs/paper.svg"> Faturado</a></li>
            <li><a href="#cancelado"><img src="./imgs/cancel.svg"> Cancelado</a></li>
        </ul>
    </div>

    <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn">
               <a> <img src="imgs/menu.svg"> </a>  
            </div>
            <div class="logo"><img src="imgs/minilogo.svg"></div>
        </div>
        <div class="right-icons">
            <div class="notification-icon"><img src="imgs/Doorbell.svg"></div>

            <div class="user-name"> 
    <p><?php echo $nomeUsuario; ?></p>
</div>

            <div class="user-icon"><img src="imgs/user.svg"></div>
        </div>
    </header>

     <!-- CONTEUDO PRINCIPAL -->
     <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações em Andamento</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <input type="text" placeholder="Busca">
            <select><option value="">Centro de Custo</option></select>
            <input type="text" placeholder="Placa">
            <select><option value="">Ordenar</option></select>
            <button class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
            <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
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
                <tbody id="cotacoes-body">
                    <!-- Conteúdo da tabela será inserido dinamicamente -->
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

    <script src="andamento.js?v=<?php echo time(); ?>"></script>


</body>
</html>

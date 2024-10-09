
<?php
session_start();
if(isset($_SESSION['nome'])) {
    $nomeUsuario = $_SESSION['nome'];
} else {
    $nomeUsuario = "Convidado"; 
}

include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $veiculo = $data['veiculo'];
    $kmAtual = $data['kmAtual'];
    $centroCusto = $data['centroCusto'];
    $tipoSolicitacao = $data['tipoSolicitacao'];
    $planoManutencao = $data['planoManutencao'];
    $modeloContratacao = $data['modeloContratacao'];
    $fornecedor = $data['fornecedor'];
    $responsavel = $data['responsavel'];
    $dataAbertura = $data['dataAbertura'];
    $dataRecebimento = $data['dataRecebimento'];
    $modelo = $data['modelo'];
    $propostas = $data['propostas'];
    $placa = $data['placa'];

    $sql = "INSERT INTO cotacoes_em_andamento (veiculo, km_atual, centro_custo, tipo_solicitacao, plano_manutencao, modelo_contratacao, fornecedor, responsavel, data_abertura, data_final, modelo, propostas, placa)
            VALUES ('$veiculo', '$kmAtual', '$centroCusto', '$tipoSolicitacao', '$planoManutencao', '$modeloContratacao', '$fornecedor', '$responsavel', '$dataAbertura', '$dataRecebimento', '$modelo', '$propostas', '$placa')";

    if ($conexao->query($sql) === TRUE) {
        echo json_encode(['message' => 'Cotação inserida com sucesso!']);
    } else {
        echo json_encode(['error' => 'Erro ao inserir cotação: ' . $conexao->error]);
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir</title>
    <link rel="stylesheet" href="incluir.css?v=<?php echo time(); ?>">

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
 
     <!-- Conteudo Principal -->
    <div class="main-content" id="main-content">
        <h1 class="text-incco">Incluir Cotações</h1>
        <div class="form-container">
            <!-- Formulário com os campos -->
            <div class="form-group">
                <label for="veiculo">Veículo</label>
                <input type="text" id="veiculo" placeholder="Informe o veiculo">

                <label for="km-atual">Km Atual</label>
                <input type="text" id="km-atual" placeholder="Informe o Km Atual">
            </div>

            <div class="form-group">
                <label for="centro-custo">Centro de Custo</label>
                <input type="text" id="centro-custo" placeholder="Informe o centro de custo">
 
                

                <label for="tipo-solicitacao">Tipo de Solicitação</label>
                <select id="tipo-solicitacao">
                    <option value="">Selecione o tipo de Solicitação</option>
                    <option>Aquisição de Peças</option>
                    <option>Aquisição de Pneus</option>
                    <option value="">Aquisição de Óleos Lubrificantes e Filtros </option>
                    <option value=""> Aquisição de Peças</option>
                    <option value=""> Aquisição de Peças + Serviços </option>
                    <option value=""> Aquisição de Pneus </option>
                    <option value=""> Serviço de Borracharia </option>
                    <option value=""> Serviço de Diagnóstico </option>
                    <option value=""> Serviço de Elétrica </option>
                    <option value=""> Serviço de Funilaria e Pintura </option>
                    <option value=""> Serviço de Guincho </option>
                    <option value=""> Serviço de Para-brisas </option>
                    <option value=""> Serviço de Portas</option>
                    <option value=""> Serviço de Radiador </option>
                    <option value=""> Serviço de Reforma de Pneus </option>
                    <option value=""> Serviço de Solda em Geral </option>
                    <option value=""> Serviço de Tapeçaria </option>
                    <option value=""> Serviço de Tornearia </option>
                    <option value=""> Serviço Geral </option>
                    <option value=""> Inspeção Veícular </option>
                    <option value=""> Vistoria Veícular </option>

                </select>
            </div>

            <div class="form-group">
                <label for="plano-manutencao">Plano de Manutenção</label>
                <select id="plano-manutencao">
                    <option value="">Selecione o Plano de Manutenção</option>
                    <option>Garantia</option>
                    <option>Corretiva</option>
                </select>

                <label for="modelo-contratacao">Modelo de Contratação</label>
                <input type="text" id="modelo-contratacao" placeholder="Digite o modelo de Contratação">

            
            </div>

            <div class="form-group">
                <label for="fornecedor">Fornecedor</label>
                <input type="text" id="fornecedor" placeholder="Nome do fornecedor">


                <label for="responsavel">Responsável</label>
                <input type="text" id="responsavel" placeholder="Nome do Responsável">
            </div>

            <div class="form-group">
                <label for="data-abertura">Data de Abertura</label>
                <input type="date" id="data-abertura">

                <label for="data-fim">Data Final de Recebimento</label>
                <input type="date" id="data-fim">
            </div>

            <div class="form-group">
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" placeholder="Informe o modelo">

                <label for="propostas">Propostas</label>
                <textarea id="propostas" placeholder="Descreva as propostas"></textarea>
            </div>

            <div class="form-group">
                <label for="Placa">Placa</label>
                <input type="text" id="placa" placeholder="Informe a placa">
            </div>

            <button id="incluir-btn">Incluir</button>
        </div>
    </div>

    <script src="incluir.js"></script>

</body>
</html>

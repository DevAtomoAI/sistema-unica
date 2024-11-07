<?php
include_once('../database/config.php');
session_start();

function filters() {
    global $conexao; // Assegure-se de que a conexão com o banco de dados esteja disponível
    $selectTable = "";

    // Capturar os valores das entradas
    $searchKeyWordInput = isset($_POST["palavra-chave"]) ? mysqli_real_escape_string($conexao, $_POST["palavra-chave"]) : null;
    $orderByInput = isset($_POST["ordenar-por"]) ? mysqli_real_escape_string($conexao, $_POST["ordenar-por"]) : null;
    $idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

    switch (true) {
        case !empty($searchKeyWordInput):
            $selectTable = "SELECT * FROM dados_fornecedores  
                WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
                AND (nome LIKE '%$searchKeyWordInput%' OR
                tipo LIKE '%$searchKeyWordInput%' OR 
                endereco LIKE '%$searchKeyWordInput%' OR 
                cidade LIKE '%$searchKeyWordInput%' OR
                estado LIKE '%$searchKeyWordInput%' OR
                contato LIKE '%$searchKeyWordInput%')";
            break;

        case !empty($orderByInput):
            switch ($orderByInput) {
                case "numero_veiculo_decrescente":
                    $selectTable = "SELECT * FROM dados_fornecedores  
                        WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY id_dados_fornecedores DESC";
                    break;

                case "numero_veiculo_crescente":
                    $selectTable = "SELECT * FROM dados_fornecedores  
                        WHERE id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY id_dados_fornecedores ASC";
                    break;

                default:
                    $selectTable = "SELECT * FROM dados_fornecedores WHERE 
                        id_orgao_publico = '$idOrgaoPublicoLogado' 
                        ORDER BY $orderByInput ASC";
                    break;
            }
            break;

        default:
            $selectTable = "SELECT * FROM dados_fornecedores  
                WHERE id_orgao_publico = '$idOrgaoPublicoLogado'";
            break;
    }

    $_SESSION['filtrosPesquisa'] = $selectTable;

    return $selectTable;
}

function salvaValoresFornecedores($conexao){
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];
    $nomeFornecedor = $_POST['nomeFornecedor'];
    $tipoFornecedor = $_POST['tipoFornecedor'];
    $enderecoFornecedor = $_POST['enderecoFornecedor'];
    $cidadeFornecedor = $_POST['cidadeFornecedor'];
    $estadoFornecedor = $_POST['estadoFornecedor'];
    $contatoFornecedor = $_POST['contatoFornecedor'];

    $stmt = $conexao->prepare("INSERT INTO dados_fornecedores 
    (id_orgao_publico, nome, tipo, endereco, cidade, estado, contato)  
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Vincula os parâmetros
    $stmt->bind_param("issssss", $idOrgaoPublico, $nomeFornecedor, $tipoFornecedor, $enderecoFornecedor, $cidadeFornecedor, $estadoFornecedor, $contatoFornecedor);

    $stmt->execute();
    $stmt->close();
}

if(isset($_POST['salvaValoresFornecedores'])){
    salvaValoresFornecedores($conexao);
    header('Location: fornecedores.php');
}
if(isset($_POST['pesquisaFornecedores'])){
    filters();
    header('Location: fornecedores.php');
}
<?php
session_start();
include_once("../database/config.php");

$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

function atualizaValoresOrgao($conexao, $idOrgaoPublicoLogado)
{
    $numContrato = $_POST['num_contrato'];
    $razaoSocial = $_POST['razao_social'];
    $identificacaoCNPJ = $_POST['cnpj'];
    $responsavel = $_POST['responsavel'];
    $contato = $_POST['contato'];
    $email = $_POST['email'];

    // Preparando a declaração para atualização
    $updateValoresTable = "
        UPDATE usuarios_orgao_publico 
        SET num_contrato = ?, 
            razao_social = ?, 
            identificacao_cnpj = ?, 
            responsavel = ?, 
            contato = ?, 
            email = ? 
        WHERE id_usuarios_orgao_publico = ?";

    // Preparando a declaração
    $stmt = $conexao->prepare($updateValoresTable);

    // Substitua as variáveis com os valores que deseja atualizar
    $stmt->bind_param("ssssssi", $numContrato, $razaoSocial, $identificacaoCNPJ, $responsavel, $contato, $email, $idOrgaoPublicoLogado);

    // Executa o UPDATE
    if (!$stmt->execute()) {
        echo "Erro na atualização: " . $stmt->error;
    }

    $stmt->close();
}
function salvaValoresCentroCustos($conexao, $idOrgaoPublicoLogado)
{
    $count = 0;
    // Debug: Verificando os dados recebidos
    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    $nomes = $_POST['nomeCentro'] ?? [];
    $valoresContratos = $_POST['valorContrato'] ?? [];
    $fontesRecurso = $_POST['fonteRecurso'] ?? [];
    $datasCredito = $_POST['dataCredito'] ?? [];
    $ordensBancarias = $_POST['ordemBancaria'] ?? [];
    $valoresCredito = $_POST['valorCredito'] ?? [];

    // Checando se todos os arrays têm o mesmo tamanho
    if (count($nomes) > 0 && count($nomes) == count($valoresContratos) && count($nomes) == count($fontesRecurso) && count($nomes) == count($datasCredito) && count($nomes) == count($ordensBancarias) && count($nomes) == count($valoresCredito)) {
        for ($i = 0; $i < count($nomes); $i++) {
            // Verifique se o centro de custo já existe
            $stmtVerificacao = $conexao->prepare("SELECT COUNT(*) FROM centros_custos WHERE nome = ? AND id_orgao_publico = ?");
            $stmtVerificacao->bind_param("si", $nomes[$i], $idOrgaoPublicoLogado);
            $stmtVerificacao->execute();
            $stmtVerificacao->bind_result($count);
            $stmtVerificacao->fetch();
            $stmtVerificacao->close();

            if ($count > 0) {
                echo "Centro de custo '{$nomes[$i]}' já existe e não será inserido.<br>";
                continue; // Pula para a próxima iteração se já existir
            }

            // Se não existe, insira o novo centro de custo
            $stmt = $conexao->prepare("INSERT INTO centros_custos (nome, id_orgao_publico, valor_contrato, fonte_recurso, data_credito, num_ordem_bancaria, valor_credito) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissssi", $nomes[$i], $idOrgaoPublicoLogado, $valoresContratos[$i], $fontesRecurso[$i], $datasCredito[$i], $ordensBancarias[$i], $valoresCredito[$i]);

            if (!$stmt->execute()) {
                echo "Erro ao inserir dados para '{$nomes[$i]}': " . $stmt->error . "<br>";
            } else {
                echo "Dados inseridos com sucesso para: '{$nomes[$i]}'<br>";
            }
        }
    } else {
        echo "Dados inconsistentes ou vazios.";
    }
}

// Chama as funções para atualizar e salvar os dados
if (isset($_POST['enviaDadosOrgao'])) {
    atualizaValoresOrgao($conexao, $idOrgaoPublicoLogado);
}

if (isset($_POST['salvaValoresCentroCustos'])) {
    salvaValoresCentroCustos($conexao, $idOrgaoPublicoLogado);
}
// Redireciona de volta para a página de dados após o processamento
header('Location: dados.php');
exit;

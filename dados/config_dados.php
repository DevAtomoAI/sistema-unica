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
    $nomes = $_POST['nomeCentro'] ?? [];
    $valoresContratos = $_POST['valorContrato'] ?? [];
    $fontesRecurso = $_POST['fonteRecurso'] ?? [];
    $datasCredito = $_POST['dataCredito'] ?? [];
    $ordensBancarias = $_POST['ordemBancaria'] ?? [];
    $valoresCredito = $_POST['valorCredito'] ?? [];

    // Checando se todos os arrays têm o mesmo tamanho
    if (count($nomes) > 0 && count($nomes) == count($valoresContratos) && count($nomes) == count($fontesRecurso) && count($nomes) == count($datasCredito) && count($nomes) == count($ordensBancarias) && count($nomes) == count($valoresCredito)) {
        for ($i = 0; $i < count($nomes); $i++) {
            // Converter para float
            $valoresContratos[$i] = (float) $valoresContratos[$i];
            $valoresCredito[$i] = (float) $valoresCredito[$i];

            // Verifique se o centro de custo já existe e obtenha os dados atuais
            $stmtVerificacao = $conexao->prepare("SELECT valor_contrato, fonte_recurso, data_credito, num_ordem_bancaria, valor_credito FROM centros_custos WHERE nome = ? AND id_orgao_publico = ?");
            $stmtVerificacao->bind_param("si", $nomes[$i], $idOrgaoPublicoLogado);
            $stmtVerificacao->execute();
            $stmtVerificacao->store_result();

            $valorContratoExistente = $fonteRecursoExistente = $dataCreditoExistente = $ordemBancariaExistente = $valorCreditoExistente = null;

            if ($stmtVerificacao->num_rows > 0) {
                $stmtVerificacao->bind_result($valorContratoExistente, $fonteRecursoExistente, $dataCreditoExistente, $ordemBancariaExistente, $valorCreditoExistente);
                $stmtVerificacao->fetch();

                if ($valoresContratos[$i] != $valorContratoExistente || $fontesRecurso[$i] != $fonteRecursoExistente || $datasCredito[$i] != $dataCreditoExistente || $ordensBancarias[$i] != $ordemBancariaExistente || $valoresCredito[$i] != $valorCreditoExistente) {
                    $stmtAtualizacao = $conexao->prepare("UPDATE centros_custos SET valor_contrato = ?, fonte_recurso = ?, data_credito = ?, num_ordem_bancaria = ?, valor_credito = ? WHERE nome = ? AND id_orgao_publico = ?");
                    $stmtAtualizacao->bind_param("dssidsi", $valoresContratos[$i], $fontesRecurso[$i], $datasCredito[$i], $ordensBancarias[$i], $valoresCredito[$i], $nomes[$i], $idOrgaoPublicoLogado);

                    if (!$stmtAtualizacao->execute()) {
                        echo "Erro ao atualizar dados para '{$nomes[$i]}': " . $stmtAtualizacao->error . "<br>";
                    } else {
                        echo "Dados atualizados com sucesso para: '{$nomes[$i]}'<br>";
                    }
                    $stmtAtualizacao->close();
                } else {
                    echo "Nenhuma alteração necessária para: '{$nomes[$i]}'<br>";
                }
            } else {
                $stmt = $conexao->prepare("INSERT INTO centros_custos (nome, id_orgao_publico, valor_contrato, fonte_recurso, data_credito, num_ordem_bancaria, valor_credito) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sisssds", $nomes[$i], $idOrgaoPublicoLogado, $valoresContratos[$i], $fontesRecurso[$i], $datasCredito[$i], $ordensBancarias[$i], $valoresCredito[$i]);

                if (!$stmt->execute()) {
                    echo "Erro ao inserir dados para '{$nomes[$i]}': " . $stmt->error . "<br>";
                } else {
                    echo "Dados inseridos com sucesso para: '{$nomes[$i]}'<br>";
                }
                $stmt->close();
            }
            $stmtVerificacao->close();
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

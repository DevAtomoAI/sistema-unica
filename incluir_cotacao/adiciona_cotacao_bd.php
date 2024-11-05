<?php
include_once("../database/config.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function adicionarValoresBD($conexao) {

    // Lê o conteúdo do arquivo
    $veiculo = $_POST['veiculo'];
    $kmAtual = $_POST['km-atual'];
    $fornecedor = $_POST['fornecedor'];
    $centroCusto = $_POST['centro-custo'];
    $tipoSolicitacao = $_POST['tipo-solicitacao'];
    $planoManutencao = $_POST['plano-manutencao'];
    $responsavel = $_POST['responsavel'];
    $dataAbertura = $_POST['data-abertura'];
    $dataFinal = $_POST['data-fim'];
    $modeloContratacao = $_POST['modelo-contratacao'];
    $justificativa = $_POST['justificativa'];
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];

    // Prepara a consulta
    $stmt = $conexao->prepare("INSERT INTO infos_veiculos_inclusos 
    (id_orgao_publico, veiculo, km_atual, fornecedor, plano_manutencao, modelo_contratacao, data_abertura, data_final, centro_custo, tipo_solicitacao, responsavel, justificativa)  
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        echo "Erro na preparação da consulta: " . $conexao->error;
        return;
    }

    // Vincula os parâmetros
    $stmt->bind_param("isisssssssss", $idOrgaoPublico, $veiculo, $kmAtual, $fornecedor, $planoManutencao, $modeloContratacao, $dataAbertura, $dataFinal, $centroCusto, $tipoSolicitacao, 
    $responsavel, $justificativa);

    // Executa a consulta
    if ($stmt->execute()) {
        // header('Location: incluir.php');
        exit; // Para garantir que o script pare após o redirecionamento
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

function analisaXML($conexao)
{
    $idOrgaoPublico = $_SESSION['idOrgaoPublico'];
    $idVeiculoEscolhido = $_SESSION['idVeiculoEscolhido'];

    echo $idVeiculoEscolhido;
    if (isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
        $caminhoTemporario = $_FILES['anexo']['tmp_name'];

        // Carregar o arquivo XML usando SimpleXML
        $xml = simplexml_load_file($caminhoTemporario);
        if ($xml === false) {
            echo "Erro ao carregar o XML.";
        } else {
            $numOrcamento = $xml->numero_orcamento;

            // Inicializar o array de valores para inserção
            $valoresParaInserir = [];

            // Laço para coletar itens do orçamento
            $contadorItens = 0;
            while (count($xml->itens_orcamento->item) > $contadorItens) {
                // Extraindo os dados
                $tipoItem = $xml->itens_orcamento->item[$contadorItens]->tipo_item;
                $descricao = $xml->itens_orcamento->item[$contadorItens]->nome;
                $quantidade = $xml->itens_orcamento->item[$contadorItens]->quantidade;
                $preco = $xml->itens_orcamento->item[$contadorItens]->preco;
                $codigo = $xml->itens_orcamento->item[$contadorItens]->codigo;

                // Valores da mão de obra e totais
                $maoDeObra = $xml->padrao_mao_de_obra[$contadorItens];
                $valorHoraMaoObra = $maoDeObra->valor_hora_mao_de_obra;

                $valoresTotais = $xml->total_do_orcamento[$contadorItens];
                $valorLiquidoFinalPecas = $valoresTotais->valor_liquido_pecas[$contadorItens];
                $valorLiquidoMaoObra = $valoresTotais->valor_liquido_mao_de_obra[$contadorItens];
                $valorTotalLiquidoGeral = $valoresTotais->valor_total_liquido_geral[$contadorItens];

                if ($tipoItem == 'Peça') {
                    // Para peças
                    $valoresParaInserir[] = "('$idVeiculoEscolhido', '$idOrgaoPublico', '$numOrcamento', '$codigo', '$descricao', '$quantidade', '$preco', '$valorLiquidoFinalPecas', NULL, NULL, NULL, '$valorTotalLiquidoGeral')";
                } else {
                    // Para serviços
                    $valoresParaInserir[] = "('$idVeiculoEscolhido', '$idOrgaoPublico', '$numOrcamento', NULL, NULL, NULL, NULL, NULL, '$descricao', '$valorHoraMaoObra', '$valorLiquidoMaoObra', '$valorTotalLiquidoGeral')";
                }

                $contadorItens++;
            }

            // Executar a inserção se houver valores
            if (count($valoresParaInserir) > 0) {
                $sql = "INSERT INTO infos_cotacao_orgao (id_veiculo_incluso_orgao_publico, id_orgao_publico, numero_orcamento, codigo_pecas, descricao_pecas, quantidade_pecas, 
                        valor_orcado_pecas, valor_total_final_pecas, descricao_servicos, valor_mao_obra, valor_total_servicos, valor_total_final) 
                        VALUES " . implode(',', $valoresParaInserir);

                // Executar a consulta
                if ($conexao->query($sql) === TRUE) {
                    echo "Itens inseridos com sucesso.";
                } else {
                    echo "Erro ao inserir itens: " . $conexao->error;
                }
            } else {
                echo "Nenhum item para inserir.";
            }
        }
    } else {
        echo "Erro no upload do arquivo.";
    }
}

// Chama a função ao clicar no botão de incluir
if (isset($_POST["incluir-btn"])) {
    analisaXML($conexao);
    adicionarValoresBD($conexao);
    // header('Location: ../cotacoes_andamento/andamento.php');
}

// Fecha a conexão
$conexao->close();

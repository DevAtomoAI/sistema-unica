<?php

include_once('../database/config.php');
session_start();

// Verifica se as variáveis de sessão estão definidas

$idVeiculoEscolhido = $_SESSION['idVeiculoEscolhido'];
$usuarioLogado = $_SESSION['nameLoggedUser'];
$idOrgaoPublicoLogado = $_SESSION['idOrgaoPublico'];

function acessaValoresBD($conexao, $idVeiculoEscolhido)
{
    $idVeiculoEscolhido = mysqli_real_escape_string($conexao, $idVeiculoEscolhido);
    $selectTabelaInfos = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'";
    $execConnectionInfos = $conexao->query($selectTabelaInfos);

    if ($execConnectionInfos && mysqli_num_rows($execConnectionInfos) > 0) {
        while ($user_data = mysqli_fetch_assoc($execConnectionInfos)) {
            $_SESSION['responsavelAtual'] = htmlspecialchars($user_data['responsavel']);
            $_SESSION['fornecedor'] = htmlspecialchars($user_data['fornecedor']);
            $_SESSION['veiculo'] = htmlspecialchars($user_data['veiculo']);
            $_SESSION['placa'] = htmlspecialchars($user_data['placa']);
            $_SESSION['centroCusto'] = htmlspecialchars($user_data['centro_custo']);
            $_SESSION['kmAtual'] = intval($user_data['km_atual']);
            $_SESSION['modelo'] = htmlspecialchars($user_data['modelo_contratacao']);
            $_SESSION['tipoSolicitacao'] = htmlspecialchars($user_data['tipo_solicitacao']);
            $_SESSION['planoManutencao'] = htmlspecialchars($user_data['plano_manutencao']);
            $_SESSION['modeloContratacao'] = htmlspecialchars($user_data['modelo_contratacao']);
            $_SESSION['dataAbertura'] = htmlspecialchars($user_data['data_abertura']);
            $_SESSION['dataFinal'] = htmlspecialchars($user_data['data_final']);
        }

        header('Location: gerenciar.php');
        exit();
    } else {
        // Tratar o caso onde não há resultados ou a consulta falhou
        echo "Erro ao acessar dados do veículo.";
    }
}

function atualizaValoresBD($conexao, $idVeiculoEscolhido, $usuarioLogado)
{
    $responsavelAtual = mysqli_real_escape_string($conexao, $_POST['responsavelAtual']);
    $fornecedor = mysqli_real_escape_string($conexao, $_POST['fornecedor']);
    $veiculo = mysqli_real_escape_string($conexao, $_POST['veiculo']);
    $placa = mysqli_real_escape_string($conexao, $_POST['placa']);
    $centroCusto = mysqli_real_escape_string($conexao, $_POST['centroCusto']);
    $kmAtual = intval($_POST['kmAtual']);
    $tipoSolicitacao = mysqli_real_escape_string($conexao, $_POST['tipoSolicitacao']);
    $planoManutencao = mysqli_real_escape_string($conexao, $_POST['planoManutencao']);
    $modeloContratacao = mysqli_real_escape_string($conexao, $_POST['modelo']);
    $dataAbertura = mysqli_real_escape_string($conexao, $_POST['dataAbertura']);
    $dataFinal = mysqli_real_escape_string($conexao, $_POST['dataFinal']);

    $atualizaInfosVeiculos = mysqli_query($conexao, "UPDATE infos_veiculos_inclusos SET 
                    veiculo = '$veiculo', 
                    km_atual = '$kmAtual', 
                    plano_manutencao = '$planoManutencao', 
                    modelo_contratacao = '$modeloContratacao', 
                    data_abertura = '$dataAbertura', 
                    data_final = '$dataFinal', 
                    centro_custo = '$centroCusto', 
                    tipo_solicitacao = '$tipoSolicitacao', 
                    fornecedor = '$fornecedor', 
                    responsavel = '$responsavelAtual', 
                    placa = '$placa' 
                    WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'");

    if (!$atualizaInfosVeiculos) {
        echo "Erro ao atualizar os dados: " . mysqli_error($conexao);
    }
}

function mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, $condicao, $idOrcamentoEscolhido)
{
    $idOrgaoPublicoLogado = mysqli_real_escape_string($conexao, $idOrgaoPublicoLogado);
    $mudaEstadoCotacaoOficina = mysqli_query($conexao, "UPDATE infos_veiculos_inclusos SET 
    opcao_aprovada_reprovada_oficina = '$condicao'
    WHERE id_orgao_publico = '$idOrgaoPublicoLogado' AND opcao_aprovada_reprovada_oficina='Respondida'");

    $mudaEstadoCotacaoOficina2 = mysqli_query($conexao, "UPDATE infos_veiculos_aprovados_oficina 
SET orcamento_aprovado_reprovado = '$condicao' 
WHERE id_veiculo_aprovado_oficina = '$idOrcamentoEscolhido' 
AND id_orgao_publico = '$idOrgaoPublicoLogado'");

    if (!$mudaEstadoCotacaoOficina) {
        echo "Erro ao mudar o estado da cotação: " . mysqli_error($conexao);
    }
}

if (isset($_POST['atualizaValoresBD'])) {
    atualizaValoresBD($conexao, $idVeiculoEscolhido, $usuarioLogado);
    header('Location:../cotacoes_andamento/andamento.php');
    exit();
}

if (isset($_POST['naoAtualizaValoresBD'])) {
    header('Location:../cotacoes_andamento/andamento.php');
    exit();
}

if (isset($_POST["aprovaCotacaoOficina"])) {
    $idOrcamentoEscolhido = $_POST["aprovaCotacaoOficina"];
    mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, 'Aprovada', $idOrcamentoEscolhido);
    header('Location: ../cotacoes_aprovado/aprovado.php');
    exit();
}

if (isset($_POST["cancelaCotacaoOficina"])) {
    $idOrcamentoEscolhido = $_POST["cancelaCotacaoOficina"];
    mudaEstadoCotacaoOficina($conexao, $idOrgaoPublicoLogado, 'Cancelada', $idOrcamentoEscolhido);
    header('Location: ../cotacoes_cancelado/cancelado.php');
    exit();
}

// Acessa valores do banco de dados
acessaValoresBD($conexao, $idVeiculoEscolhido);

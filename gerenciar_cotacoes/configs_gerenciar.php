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
            echo $user_data['tipo_solicitacao'];
            $_SESSION['responsavelAtual'] = htmlspecialchars($user_data['responsavel']);
            $_SESSION['fornecedor'] = htmlspecialchars($user_data['fornecedor']);
            $_SESSION['veiculo'] = htmlspecialchars($user_data['veiculo']);
            $_SESSION['centroCusto'] = htmlspecialchars($user_data['centro_custo']);
            $_SESSION['kmAtual'] = intval($user_data['km_atual']);
            $_SESSION['modelo'] = htmlspecialchars($user_data['modelo_contratacao']);
            $_SESSION['tipoSolicitacao'] = ($user_data['tipo_solicitacao']);
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

function atualizaValoresBD($conexao, $idVeiculoEscolhido)
{
    $responsavelAtual = mysqli_real_escape_string($conexao, $_POST['responsavelAtual']);
    $fornecedor = mysqli_real_escape_string($conexao, $_POST['fornecedor']);
    $veiculo = mysqli_real_escape_string($conexao, $_POST['veiculo']);
    $centroCusto = mysqli_real_escape_string($conexao, $_POST['centroCusto']);
    $kmAtual = intval($_POST['kmAtual']);
    $tipoSolicitacao = mysqli_real_escape_string($conexao, $_POST['tipoSolicitacao']);
    $planoManutencao = mysqli_real_escape_string($conexao, $_POST['planoManutencao']);
    $modeloContratacao = mysqli_real_escape_string($conexao, $_POST['modeloContratacao']);
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
                    responsavel = '$responsavelAtual'
                    WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'");

    if (!$atualizaInfosVeiculos) {
        echo "Erro ao atualizar os dados: " . mysqli_error($conexao);
    }
}

function aprovaReprovaOrcamento($conexao, $estado, $idOrgaoPublicoLogado, $idVeiculoEscolhido, $idOficina){

    if($estado == 'Aprovado'){
        $updateOrcamentoOP = mysqli_query($conexao,  "UPDATE infos_veiculos_inclusos SET orcamento_aprovada_reprovada_oficina = '$estado' WHERE id_orgao_publico='$idOrgaoPublicoLogado' 
        AND id_infos_veiculos_inclusos='$idVeiculoEscolhido'");    
    }

    $updateOrcamentoOficina = mysqli_query($conexao,  "UPDATE orcamentos_oficinas SET orcamento_aprovado_reprovado = '$estado' WHERE id_orgao_publico='$idOrgaoPublicoLogado' 
    AND id_veiculo_gerenciado='$idVeiculoEscolhido' AND id_oficina='$idOficina'");

    if(!$updateOrcamentoOP || !$updateOrcamentoOficina) {
        echo "erro ao executar update aprovar ou reprovar orçamento";
    }
}

if (isset($_POST['atualizaValoresBD'])) {
    atualizaValoresBD($conexao, $idVeiculoEscolhido);
    header('Location:../cotacoes_andamento/andamento.php');
    exit();
}

if (isset($_POST['naoAtualizaValoresBD'])) {
    header('Location:../cotacoes_andamento/andamento.php');
    exit();
}

if (isset($_POST['aprovaOrcamentoOficina']) || isset($_POST['reprovaOrcamentoOficina'])) {
    if (isset($_POST['aprovaOrcamentoOficina'])) {
        $idOficina = $_POST['aprovaOrcamentoOficina'];
        aprovaReprovaOrcamento($conexao, 'Aprovado', $idOrgaoPublicoLogado, $idVeiculoEscolhido, $idOficina);
    } elseif (isset($_POST['reprovaOrcamentoOficina'])) {
        $idOficina = $_POST['reprovaOrcamentoOficina'];
        aprovaReprovaOrcamento($conexao, 'Reprovado', $idOrgaoPublicoLogado, $idVeiculoEscolhido, $idOficina);
    }
}


// Acessa valores do banco de dados
acessaValoresBD($conexao, $idVeiculoEscolhido);

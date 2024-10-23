<?php

include_once('../database/config.php');
session_start();

$idVeiculoEscolhido = $_SESSION['idVeiculoEscolhido'];
$usuarioLogado = $_SESSION['nameLoggedUser'];
function acessaValoresBD($conexao, $idVeiculoEscolhido)
{
    $selectTabelaInfos = "SELECT * FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'";
    $execConnectionInfos = $conexao->query($selectTabelaInfos);

    if (mysqli_num_rows($execConnectionInfos) > 0) {
        // Caso existam resultados, salvar os valores na sessão
        while ($user_data = mysqli_fetch_assoc($execConnectionInfos)) {
            $_SESSION['responsavelAtual'] = $user_data['responsavel'];
            $_SESSION['fornecedor'] = $user_data['fornecedor'];
            $_SESSION['veiculo'] = $user_data['veiculo'];
            $_SESSION['placa'] = $user_data['placa'];
            $_SESSION['centroCusto'] = $user_data['centro_custo'];
            $_SESSION['kmAtual'] = intval($user_data['km_atual']);
            $_SESSION['modelo'] = $user_data['modelo_contratacao'];
            $_SESSION['tipoSolicitacao'] = $user_data['tipo_solicitacao'];
            $_SESSION['planoManutencao'] = $user_data['plano_manutencao'];
            $_SESSION['modeloContratacao'] = $user_data['modelo_contratacao'];
            $_SESSION['dataAbertura'] = $user_data['data_abertura'];
            $_SESSION['dataFinal'] = $user_data['data_final'];
        }

        // Redirecionar para 'gerenciar.php' se dados foram encontrados
        header('Location: gerenciar.php');
    } else {
        // Caso contrário, redirecionar para uma outra página, como 'erro.php'
        header('Location: erro.php');
    }
    exit();
}



function atualizaValoresBD($conexao, $idVeiculoEscolhido, $usuarioLogado)
{
    $responsavelAtual = $_POST['responsavelAtual'];
    $fornecedor = $_POST['fornecedor'];
    $veiculo = $_POST['veiculo'];
    $placa = $_POST['placa'];
    $centroCusto = $_POST['centroCusto'];
    $kmAtual = $_POST['kmAtual'];
    $tipoSolicitacao = $_POST['tipoSolicitacao'];
    $planoManutencao = $_POST['planoManutencao'];
    $modeloContratacao = $_POST['modelo'];
    $dataAbertura = $_POST['dataAbertura'];
    $dataFinal = $_POST['dataFinal'];

    $identificacaoCPF_CNPJ = $_POST['identificacaoCPF_CNPJ'];
    $arrendatario = $_POST['arrendatario'];
    $inscricaoEstadual = $_POST['inscricaoEstadual'];
    $subunidade = $_POST['subunidade'];

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
                     quantidade_propostas_oficinas = '', 
                     placa = '$placa'
                     WHERE id_infos_veiculos_inclusos = '$idVeiculoEscolhido'");

    $atualizaInfosUsuario = mysqli_query($conexao, "UPDATE usuarios_orgao_publico SET 
                            identificacao_cpf_cnpj = '$identificacaoCPF_CNPJ', 
                            arrendatario = '$arrendatario', 
                            inscricao_estadual = '$inscricaoEstadual', 
                            subunidade = '$subunidade'
                            WHERE nome = '$usuarioLogado'");
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


acessaValoresBD($conexao, $idVeiculoEscolhido);

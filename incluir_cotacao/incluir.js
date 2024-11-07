
document.getElementById('incluir-btn').addEventListener('click', function() {
    const veiculo = document.getElementById('veiculo').value;
    const kmAtual = document.getElementById('km-atual').value;
    const centroCusto = document.getElementById('centro-custo').value;
    const tipoSolicitacao = document.getElementById('tipo-solicitacao').value;
    const planoManutencao = document.getElementById('plano-manutencao').value;
    const modeloContratacao = document.getElementById('modelo-contratacao').value;
    const fornecedor = document.getElementById('fornecedor').value;
    const responsavel = document.getElementById('responsavel').value;
    const dataAbertura = document.getElementById('data-abertura').value;
    const dataRecebimento = document.getElementById('data-fim').value;
    const modelo = document.getElementById('modelo').value;
    const propostas = document.getElementById('propostas').value;
    const placa = document.getElementById('placa').value;

    const cotacao = {
        veiculo,
        kmAtual,
        centroCusto,
        tipoSolicitacao,
        planoManutencao,
        modeloContratacao,
        fornecedor,
        responsavel,
        dataAbertura,
        dataRecebimento,
        modelo,
        propostas,
        placa
    };

    // Salvar cotação na sessionStorage
    const cotacoes = JSON.parse(sessionStorage.getItem('cotacoes')) || [];
    cotacoes.push(cotacao);
    sessionStorage.setItem('cotacoes', JSON.stringify(cotacoes));

});

 // Seleciona o botão do menu e o menu em si
 const menuBtn = document.getElementById('menuBtn');
 const menuOptions = document.getElementById('menu-options');

 // Adiciona o evento de clique para alternar a classe active
 menuBtn.addEventListener('click', () => {
     menuOptions.classList.toggle('active');
 });




const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById('closeBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

// Função para abrir a barra lateral
menuBtn.addEventListener('click', () => {
    sidebar.classList.add('open');
    overlay.classList.add('active');
});

// Função para fechar a barra lateral
closeBtn.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
});

// Fechar a barra lateral ao clicar fora dela (overlay)
overlay.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
});

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

    // Redirecionar para a página "Em Andamento"
    window.location.href = 'andamento.php';
});
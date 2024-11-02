
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
    // window.location.href = 'andamento.php';
});

// Alternar o menu ao clicar no botão
document.getElementById("menuBtn").addEventListener("click", function(event) {
    event.stopPropagation();  // Impede que o clique no botão feche o menu
    toggleMenu();
});

function toggleMenu() {
    const menuOptions = document.getElementById("menu-options");
    menuOptions.style.display = (menuOptions.style.display === "" || menuOptions.style.display === "")
        ? "block"
        : "";
}

// Ocultar o menu ao clicar fora dele
document.addEventListener("click", function(event) {
    const menuBtn = document.getElementById("menuBtn");
    const menuOptions = document.getElementById("menu-options");

    if (!menuBtn.contains(event.target) && !menuOptions.contains(event.target)) {
        menuOptions.style.display = "none";
    }
});


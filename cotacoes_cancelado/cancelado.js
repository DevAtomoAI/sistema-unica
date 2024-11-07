// Carregar as cotações aprovadas
window.onload = function () {
    carregarCotacoesAprovadas();
};

function carregarCotacoesAprovadas() {
    const aprovadasBody = document.getElementById("aprovadas-body");
    aprovadasBody.innerHTML = '';

    let aprovadas = JSON.parse(localStorage.getItem('aprovadas')) || [];

    aprovadas.forEach((cotacao, index) => {
        let row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${cotacao.placa}</td>
            <td>${cotacao.modelo}</td>
            <td>${cotacao.centroCusto}</td>
            <td>${cotacao.propostas}</td>
            <td>${cotacao.dataAbertura}</td>
            <td>
                <button class="btn-action btn-red" onclick="rejeitarCotacao(${index})"><i class="fas fa-times"></i></button>
            </td>
        `;
        aprovadasBody.appendChild(row);
    });
}

function imprimirTabela() {
    // Seleciona o conteúdo da tabela que deseja imprimir
    var conteudoTabela = document.querySelector('.table-responsive').innerHTML;

    // Cria uma nova janela para impressão
    var janelaImpressao = window.open('', '', 'width=800,height=600');

    // Adiciona o conteúdo HTML da tabela na nova janela
    janelaImpressao.document.write('<html><head><title>Impressão de Cotações em andamento</title>');
    janelaImpressao.document.write('<style>');
    janelaImpressao.document.write('table { width: 100%; border-collapse: collapse; margin: 20px 0; }');
    janelaImpressao.document.write('table, th, td { border: 1px solid black; padding: 10px; text-align: left; }');
    janelaImpressao.document.write('th { background-color: #003150; color: white; }');
    janelaImpressao.document.write('</style></head><body>');
    janelaImpressao.document.write(conteudoTabela);
    janelaImpressao.document.write('</body></html>');

    // Aguarda o carregamento do conteúdo antes de imprimir
    janelaImpressao.document.close();
    janelaImpressao.focus();

    // Espera um pouco para a janela estar pronta e inicia a impressão
    janelaImpressao.onload = function () {
        janelaImpressao.print();
    };
}

// Adiciona o evento de clique ao botão imprimir
document.querySelector('.btn-print').addEventListener('click', imprimirTabela);

const menuBtn = document.getElementById('menuBtn');
const menuOptions = document.getElementById('menu-options');

// Adiciona o evento de clique para alternar a classe active
menuBtn.addEventListener('click', () => {
    menuOptions.classList.toggle('active');
});
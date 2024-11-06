

function abrirPopUp(cotacaoId) {
    // Ajuste para a comparação de ID
    const cotacao = cotacoes.find(c => c.id == (cotacaoId)); // Ajuste conforme necessário


    if (cotacao) {
        
        // Preencher os detalhes no pop-up
        document.getElementById("veiculo").innerText = cotacao.veiculo;
        document.getElementById("planoManutencao").innerText = cotacao.planoManutencao;
        document.getElementById("modeloContratacao").innerText = cotacao.modeloContratacao;
        document.getElementById("dataAbertura").innerText = cotacao.dataAbertura;
        // document.getElementById("dataRecebimento").innerText = cotacao.dataRecebimento;
        document.getElementById("centroCusto").innerText = cotacao.centroCusto;
        document.getElementById("tipoSolicitacao").innerText = cotacao.tipoSolicitacao;
        document.getElementById("fornecedor").innerText = cotacao.fornecedor;
        document.getElementById("responsavel").innerText = cotacao.responsavel;
        // document.getElementById("modeloVeiculo").innerText = cotacao.modelo;

        // Exibir o pop-up
        document.getElementById("popup").style.display = "block";
        document.getElementById("popup-overlay").style.display = "block";
    } else {
        alert("Cotação não encontrada.");
    }
}


function fecharPopUp() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("popup-overlay").style.display = "none";
}

// Função para imprimir a tabela de cotações
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


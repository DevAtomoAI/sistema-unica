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

// Carregar cotações da sessionStorage
// const cotacoes = JSON.parse(sessionStorage.getItem('cotacoes')) || [];
// Função para abrir o pop-up
// Abre o pop-up com as informações da cotação
function abrirPopUp(cotacaoId) {

    // Ajuste para a comparação de ID
    const cotacao = cotacoes.find(c => c.id == (cotacaoId)); // Ajuste conforme necessário


    if (cotacao) {
        // Preencher os detalhes no pop-up
        document.getElementById("veiculo").innerText = cotacao.veiculo;
        document.getElementById("kmAtual").innerText = cotacao.kmAtual;
        document.getElementById("planoManutencao").innerText = cotacao.planoManutencao;
        document.getElementById("modeloContratacao").innerText = cotacao.modeloContratacao;
        document.getElementById("dataAbertura").innerText = cotacao.dataAbertura;
        document.getElementById("dataRecebimento").innerText = cotacao.dataRecebimento;
        document.getElementById("centroCusto").innerText = cotacao.centroCusto;
        document.getElementById("tipoSolicitacao").innerText = cotacao.tipoSolicitacao;
        document.getElementById("fornecedor").innerText = cotacao.fornecedor;
        document.getElementById("responsavel").innerText = cotacao.responsavel;
        document.getElementById("propostas").innerText = cotacao.propostas;

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





// Função para aprovar uma cotação e movê-la para a página "Aprovado"
// function carregarCotacoesAndamento() {
//     const cotacoesBody = document.getElementById("cotacoes-body");
//     cotacoesBody.innerHTML = '';

//     // Simulando carregamento do localStorage ou backend
//     let cotacoes = JSON.parse(localStorage.getItem('cotacoes')) || [];

//     cotacoes.forEach((cotacao, index) => {
//         let row = document.createElement('tr');

//         row.innerHTML = `
//             <td>${index + 1}</td>
//             <td>${cotacao.placa}</td>
//             <td>${cotacao.modelo}</td>
//             <td>${cotacao.centroCusto}</td>
//             <td>${cotacao.propostas}</td>
//             <td>${cotacao.dataAbertura}</td>
//             <td>
//                 <button class="btn-action btn-green" onclick="aprovarCotacao(${index})"><i class="fas fa-check"></i></button>
//                 <button class="btn-action btn-red" onclick="rejeitarCotacao(${index})"><i class="fas fa-times"></i></button>
//             </td>
//         `;
//         cotacoesBody.appendChild(row);
//     });
// }

// function aprovarCotacao(index) {
//     let cotacoes = JSON.parse(localStorage.getItem('cotacoes')) || [];
//     let aprovadas = JSON.parse(localStorage.getItem('aprovadas')) || [];

//     // Mova a cotação selecionada de "Em andamento" para "Aprovado"
//     let cotacaoAprovada = cotacoes.splice(index, 1)[0];
//     aprovadas.push(cotacaoAprovada);

//     // Atualize o localStorage
//     localStorage.setItem('cotacoes', JSON.stringify(cotacoes));
//     localStorage.setItem('aprovadas', JSON.stringify(aprovadas));

//     // Atualize a tabela "Em andamento"
//     carregarCotacoesAndamento();
// }





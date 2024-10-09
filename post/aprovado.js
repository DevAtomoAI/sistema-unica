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

// Obtém os elementos do DOM
const mobileMenuToggle = document.getElementById('mobile-menu-toggle');

// Adiciona um listener de evento para o clique no ícone do menu
mobileMenuToggle.addEventListener('click', () => {
    // Alterna a classe 'active' no menu lateral
    sidebar.classList.toggle('active');
});



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


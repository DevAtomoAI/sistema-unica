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
        const cotacoes = JSON.parse(sessionStorage.getItem('cotacoes')) || [];
        const tabelaBody = document.getElementById('cotacoes-body');

        cotacoes.forEach((cotacao, index) => {
            const row = `
                <tr>
                    <td>${index + 1} <button class="info-btn" onclick="abrirPopUp(${index})"><i class="fas fa-info-circle"></i></button></td>
                    <td>${cotacao.placa}</td>
                    <td>${cotacao.modelo}</td>
                    <td>${cotacao.centroCusto}</td>
                    <td>${cotacao.propostas}</td>
                    <td>${cotacao.dataAbertura}</td>
                    <td><button class="btn-action btn-green"><i class="fas fa-check"></i></button>
                        <button class="btn-action btn-red"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            `;
            tabelaBody.innerHTML += row;
        });

        // Mostrar informações no Pop-up
        function abrirPopUp(index) {
            const cotacao = cotacoes[index];

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

            document.getElementById("popup").style.display = "block";
            document.getElementById("popup-overlay").style.display = "block";
        }

        // Fechar o Pop-up
        function fecharPopUp() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("popup-overlay").style.display = "none";
        }

        window.onload = function () {
            carregarCotacoesAndamento();
        };
        
        function carregarCotacoesAndamento() {
            fetch('get_cotacoes_andamento.php')
                .then(response => response.json())
                .then(cotacoes => {
                    const cotacoesBody = document.getElementById("cotacoes-body");
                    cotacoesBody.innerHTML = '';
        
                    cotacoes.forEach((cotacao, index) => {
                        let row = document.createElement('tr');
        
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${cotacao.placa}</td>
                            <td>${cotacao.modelo}</td>
                            <td>${cotacao.centro_custo}</td>
                            <td>${cotacao.propostas}</td>
                            <td>${cotacao.data_abertura}</td>
                            <td>
                                <button class="btn-action btn-green" onclick="aprovarCotacao(${cotacao.id})"><i class="fas fa-check"></i></button>
                                <button class="btn-action btn-red" onclick="rejeitarCotacao(${cotacao.id})"><i class="fas fa-times"></i></button>
                            </td>
                        `;
                        cotacoesBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Erro ao carregar cotações:', error));
        }
        
        function aprovarCotacao(id) {
            fetch('aprovar_cotacao.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                carregarCotacoesAndamento();
            })
            .catch(error => console.error('Erro ao aprovar cotação:', error));
        }
        
        function rejeitarCotacao(id) {
            // Implementar a lógica para rejeitar cotação, se necessário
        }
        



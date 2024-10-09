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

    const data = {
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

    // fetch('incluir.php', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json'
    //     },
    //     body: JSON.stringify(data)
    // })
    // .then(response => response.json())
    // .then(result => {
    //     alert('Cotação incluída com sucesso!');
    //     window.location.href = 'andamento.php';
    // })
    // .catch(error => console.error('Erro:', error));

    document.getElementById('incluir-btn').addEventListener('click', function() {

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'andamento.php', true); // Assíncrona
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        // Enviar a requisição ao PHP
        xhr.send(JSON.stringify(data));

    })
  

});


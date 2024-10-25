let contadorPecas = 1
let contadorServicos = 1;

let contadorLacoServicos = 1; 
let contadorLacoPecas = 1; 

// let maiorValor;

let codigoPecas;
var descricaoPecas;
let valorUNPecas;
let quantidadePecas;
var marcaPecas;
let valorTotalPecas;

var descricaoServico;
let valorUNServicos;
let quantidadeServicos;
let valorTotalServicos;

function abrirPopUp() {
    // Abrir uma nova janela pop-up com as especificações desejadas
    window.open("popup.php", "popupWindow", "width=600,height=400,scrollbars=yes");
}

function fechaPopUp(){
    window.close("popup.php");
    // window.open("gerenciar.php");

}

function adicionarLinhaPeças() {
    contadorPecas++;

    // Seleciona a tabela de peças e adiciona uma nova linha
    const tabelaPeças = document.getElementById("tabelaPecas").getElementsByTagName('tbody')[0];
    const novaLinha = tabelaPeças.insertRow();

    // Cria as células com os inputs
    novaLinha.insertCell(0).innerHTML = '<input type="text" id="codigo' + contadorPecas + '" required>';
    novaLinha.insertCell(1).innerHTML = '<input type="text" id="descricao' + contadorPecas + '" required>';
    novaLinha.insertCell(2).innerHTML = '<input type="text" id="valor_un' + contadorPecas + '" required>';
    novaLinha.insertCell(3).innerHTML = '<input type="text" id="quantidade' + contadorPecas + '" required>';
    novaLinha.insertCell(4).innerHTML = '<input type="text" id="marca' + contadorPecas + '" required>';
    novaLinha.insertCell(5).innerHTML = '36.6'; // Desconto fixo
    novaLinha.insertCell(6).innerHTML = '<button onclick="adicionarLinhaPeças()">+</button>';
    novaLinha.insertCell(7).innerHTML = '<button onclick="removerLinhaPecas(this)">Excluir</button>';
}

function adicionarLinhaServicos() {
    contadorServicos++;

    // Seleciona a tabela de serviços e adiciona uma nova linha
    const tabelaServicos = document.getElementById("tabelaServicos").getElementsByTagName('tbody')[0];
    const novaLinha = tabelaServicos.insertRow();

    // Cria as células com os inputs
    novaLinha.insertCell(0).innerHTML = '<input type="text" id="descricao_servico' + contadorServicos + '" required>';
    novaLinha.insertCell(1).innerHTML = '<input type="text" id="valor_unitario' + contadorServicos + '" required>';
    novaLinha.insertCell(2).innerHTML = '<input type="text" id="quantidade_servico' + contadorServicos + '" required>';
    novaLinha.insertCell(3).innerHTML = '36.6'; // Desconto fixo
    novaLinha.insertCell(4).innerHTML = '<button onclick="adicionarLinhaServicos()">+</button>';
    novaLinha.insertCell(5).innerHTML = '<button onclick="removerLinhaServico(this)">Excluir</button>';
}

function removerLinhaServico(botao) {
    // Remove a linha do botão clicado
    console.log('botao pressionado')
    const linha = botao.parentNode.parentNode;
    const tabela = linha.parentNode;

    // Só permite excluir se a tabela tiver mais de uma linha
    if (tabela.rows.length > 1) {
        linha.parentNode.removeChild(linha);
    }

    contadorServicos = contadorServicos - 1;
}

function removerLinhaPecas(botao) {
    console.log('botao pressionado')
    // Remove a linha do botão clicado
    const linha = botao.parentNode.parentNode;
    const tabela = linha.parentNode;

    // Só permite excluir se a tabela tiver mais de uma linha
    if (tabela.rows.length > 1) {
        linha.parentNode.removeChild(linha);
    }

    contadorPecas = contadorPecas - 1;
}

function enviaValoresBD() {
    var pecas = [];
    var servicos = [];
    var contadorLaco = 1;
    var maxContador = Math.max(contadorPecas, contadorServicos);

    while (contadorLaco <= maxContador) {
        // Processamento de Peças
        if (contadorLaco <= contadorPecas) {
            var codigoPecas = document.getElementById('codigo' + contadorLaco)?.value || '';
            var descricaoPecas = document.getElementById('descricao' + contadorLaco)?.value || '';
            var valorUNPecas = parseFloat(document.getElementById('valor_un' + contadorLaco)?.value) || 0;
            var quantidadePecas = parseInt(document.getElementById('quantidade' + contadorLaco)?.value) || 0;
            var marcaPecas = document.getElementById('marca' + contadorLaco)?.value || '';
            var valorTotalPecas = (valorUNPecas * quantidadePecas) + (36.6 / 100);

            // Adiciona os dados das peças ao array
            pecas.push({
                codigoPecas: codigoPecas,
                descricaoPecas: descricaoPecas,
                valorUNPecas: valorUNPecas,
                quantidadePecas: quantidadePecas,
                marcaPecas: marcaPecas,
                valorTotalPecas: valorTotalPecas
            });
        }

        // Processamento de Serviços
        if (contadorLaco <= contadorServicos) {
            var descricaoServico = document.getElementById('descricao_servico' + contadorLaco)?.value || '';
            var valorUNServicos = parseFloat(document.getElementById('valor_unitario' + contadorLaco)?.value) || 0;
            var quantidadeServicos = parseInt(document.getElementById('quantidade_servico' + contadorLaco)?.value) || 0;
            var valorTotalServicos = (valorUNServicos * quantidadeServicos) + (36.6 / 100);

            // Adiciona os dados dos serviços ao array
            servicos.push({
                descricaoServico: descricaoServico,
                valorUNServicos: valorUNServicos,
                quantidadeServicos: quantidadeServicos,
                valorTotalServicos: valorTotalServicos
            });
        }

        contadorLaco++; // Incrementa o contador
    }

    // Verificar o conteúdo dos arrays antes de enviar
    console.log('Peças:', pecas);
    console.log('Serviços:', servicos);

    // Após o laço, faz uma única requisição AJAX enviando todos os dados
    $.ajax({
        url: 'configs_popup.php',
        type: 'POST',
        data: {
            pecas: pecas,
            servicos: servicos
        },
        beforeSend: function () {
            console.log('Enviando todos os dados...');
        },
        success: function (retorno) {
            alert('Valores salvos com sucesso');
            // window.location.reload();


        },
        error: function (a, b, c) {
            console.log('Erro: ' + a.status + ' ' + c);
        }
    });
}
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

function adicionarLinhaPeças() {
    contadorPecas++;

    // Seleciona a tabela de peças e adiciona uma nova linha
    const tabelaPeças = document.getElementById("tabelaPecas").getElementsByTagName('tbody')[0];
    const novaLinha = tabelaPeças.insertRow();

    // Cria as células com os inputs
    novaLinha.insertCell(0).innerHTML = '<input type="text" id="codigo' + contadorPecas + '">';
    novaLinha.insertCell(1).innerHTML = '<input type="text" id="descricao' + contadorPecas + '">';
    novaLinha.insertCell(2).innerHTML = '<input type="text" id="valor_un' + contadorPecas + '">';
    novaLinha.insertCell(3).innerHTML = '<input type="text" id="quantidade' + contadorPecas + '">';
    novaLinha.insertCell(4).innerHTML = '<input type="text" id="marca' + contadorPecas + '">';
    novaLinha.insertCell(5).innerHTML = '36.6'; // Desconto fixo
    novaLinha.insertCell(6).innerHTML = 'VALOR SOMA VINDO BANCO';
    novaLinha.insertCell(7).innerHTML = '<button onclick="adicionarLinhaPeças()">+</button>';
    novaLinha.insertCell(8).innerHTML = '<button onclick="removerLinhaPecas(this)">Excluir</button>';



}


function adicionarLinhaServicos() {
    contadorServicos++;

    // Seleciona a tabela de serviços e adiciona uma nova linha
    const tabelaServicos = document.getElementById("tabelaServicos").getElementsByTagName('tbody')[0];
    const novaLinha = tabelaServicos.insertRow();

    // Cria as células com os inputs
    novaLinha.insertCell(0).innerHTML = '<input type="text" id="descricao_servico' + contadorServicos + '">';
    novaLinha.insertCell(1).innerHTML = '<input type="text" id="valor_unitario' + contadorServicos + '">';
    novaLinha.insertCell(2).innerHTML = '<input type="text" id="quantidade_servico' + contadorServicos + '">';
    novaLinha.insertCell(3).innerHTML = '36.6'; // Desconto fixo
    novaLinha.insertCell(4).innerHTML = 'VALOR SOMA VINDO BANCO';
    novaLinha.insertCell(5).innerHTML = '<button onclick="adicionarLinhaServicos()">+</button>';
    novaLinha.insertCell(6).innerHTML = '<button onclick="removerLinhaServico(this)">Excluir</button>';


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

function enviaValoresBD(){
    while(contadorLacoPecas <= contadorPecas){

        codigoPecas = document.getElementById('codigo' + contadorLacoPecas).value;
        descricaoPecas = document.getElementById('descricao' + contadorLacoPecas).value;
        valorUNPecas = document.getElementById('valor_un' + contadorLacoPecas).value;
        quantidadePecas = document.getElementById('quantidade' + contadorLacoPecas).value;
        marcaPecas = document.getElementById('marca' + contadorLacoPecas).value;
        valorTotalPecas = (valorUNPecas * quantidadePecas) * (36.6 / 100);

        contadorLacoPecas++;
    }

    while(contadorLacoServicos <= contadorServicos)

    $.ajax({
        url: 'configs_popup.php',
        type: 'POST',
        data: {
        'codigoPecas': codigoPecas, 'descricaoPecas': descricaoPecas, 'valorUNPecas': valorUNPecas, 'quantidadePecas': quantidadePecas, 'marcaPecas': marcaPecas, 'valorTotalPecas': valorTotalPecas,
        // 'descricaoServico': descricaoServico, 'valorUNServicos': valorUNServicos, 'quantidadeServicos': quantidadeServicos, 'valorTotalServicos': valorTotalServicos
        },
        beforeSend: function () {
            console.log('Carregando...');
        },
        success: function (retorno) {
            // console.log(retorno);
            // window.location.href = 'configs_popup.php'
        },
        error: function (a, b, c) {
            console.log('Erro: '+a[status]+' '+c);
        }
    });
}

// function enviaValoresBD() {
//     if(contadorPecas < contadorServicos){
//         contador = contadorServicos
//     }
//     else{
//         contador = contadorPecas
//     }
//     // console.log(num, contador)
//     while (num <= contador) {
//         if(contador == contadorServicos && contadorServicos > contadorPecas){
            
//             var contador2 = num-1
//             console.log('primeiro caso ',contador2);
//             console.log(num)

//             codigoPecas = document.getElementById('codigo' + contador2).value;
//             descricaoPecas = document.getElementById('descricao' + contador2).value;
//             valorUNPecas = document.getElementById('valor_un' + contador2).value;
//             quantidadePecas = document.getElementById('quantidade' + contador2).value;
//             marcaPecas = document.getElementById('marca' + contador2).value;
//             valorTotalPecas = (valorUNPecas * quantidadePecas) * (36.6 / 100);

//             descricaoServico = document.getElementById('descricao_servico' + num).value;
//             valorUNServicos = document.getElementById('valor_unitario' + num).value;
//             quantidadeServicos = document.getElementById('quantidade_servico' + num).value;
//             valorTotalServicos = (valorUNServicos * quantidadeServicos) * (36.6 / 100);
//         }
//         if(contador == contadorPecas && contadorPecas > contadorServicos){
//             var contador2 = num-1

//             console.log('segundo caso ',contador2);
//             console.log(num)
//             codigoPecas = document.getElementById('codigo' + num).value;
//             descricaoPecas = document.getElementById('descricao' + num).value;
//             valorUNPecas = document.getElementById('valor_un' + num).value;
//             quantidadePecas = document.getElementById('quantidade' + num).value;
//             marcaPecas = document.getElementById('marca' + num).value;
//             valorTotalPecas = (valorUNPecas * quantidadePecas) * (36.6 / 100);

//             descricaoServico = document.getElementById('descricao_servico' + contador2).value;
//             valorUNServicos = document.getElementById('valor_unitario' + contador2).value;
//             quantidadeServicos = document.getElementById('quantidade_servico' + contador2).value;
//             valorTotalServicos = (valorUNServicos * quantidadeServicos) * (36.6 / 100);
//         }
//         if(contadorPecas == contadorServicos){
//             console.log('terceiro caso');
//             console.log(num)
//             codigoPecas = document.getElementById('codigo' + num).value;
//             descricaoPecas = document.getElementById('descricao' + num).value;
//             valorUNPecas = document.getElementById('valor_un' + num).value;
//             quantidadePecas = document.getElementById('quantidade' + num).value;
//             marcaPecas = document.getElementById('marca' + num).value;
//             valorTotalPecas = (valorUNPecas * quantidadePecas) * (36.6 / 100);
            
//             descricaoServico = document.getElementById('descricao_servico' + num).value;
//             valorUNServicos = document.getElementById('valor_unitario' + num).value;
//             quantidadeServicos = document.getElementById('quantidade_servico' + num).value;
//             valorTotalServicos = (valorUNServicos * quantidadeServicos) * (36.6 / 100);
//         }

//         $.ajax({
//             url: 'configs_popup.php',
//             type: 'POST',
//             data: {
//                 'codigoPecas': codigoPecas, 'descricaoPecas': descricaoPecas, 'valorUNPecas': valorUNPecas, 'quantidadePecas': quantidadePecas, 'marcaPecas': marcaPecas, 'valorTotalPecas': valorTotalPecas,
//                 'descricaoServico': descricaoServico, 'valorUNServicos': valorUNServicos, 'quantidadeServicos': quantidadeServicos, 'valorTotalServicos': valorTotalServicos
//             },
//             beforeSend: function () {
//                 console.log('Carregando...');
//             },
//             success: function (retorno) {
//                 // console.log(retorno);
//                 // window.location.href = 'configs_popup.php'
//             },
//             error: function (a, b, c) {
//                 // console.log('Erro: '+a[status]+' '+c);
//             }
//         });
//         num += 1;

//     }
// }


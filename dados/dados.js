// function enviarDadosOrgao() {
//     const contrato = document.getElementById('contrato_orgao').value;
//     const razaoSocial = document.getElementById('razao_social').value;
//     const cnpj = document.getElementById('cnpj').value;
//     const responsavel = document.getElementById('responsavel').value;
//     const contato = document.getElementById('contato').value;
//     const email = document.getElementById('email').value;

//     if (!contrato || !razaoSocial || !cnpj || !responsavel || !contato || !email) {
//         alert('Por favor, preencha todos os campos dos Dados do Órgão antes de enviar.');
//         return;  
//     }

//     const tabelaOrgao = document.getElementById('tabela-orgao');
//     const novaLinha = tabelaOrgao.insertRow(-1);

//     novaLinha.insertCell(0).innerText = contrato;
//     novaLinha.insertCell(1).innerText = razaoSocial;
//     novaLinha.insertCell(2).innerText = cnpj;
//     novaLinha.insertCell(3).innerText = responsavel;
//     novaLinha.insertCell(4).innerText = contato;
//     novaLinha.insertCell(5).innerText = email;

//     document.getElementById('contrato_orgao').value = '';
//     document.getElementById('razao_social').value = '';
//     document.getElementById('cnpj').value = '';
//     document.getElementById('responsavel').value = '';
//     document.getElementById('contato').value = '';
//     document.getElementById('email').value = '';
// }


// function enviarDadosCentro() {
   
//     const nome = document.getElementById('nome_centro').value;
//     const valorContrato = document.getElementById('valor_contrato').value;
//     const fonteRecurso = document.getElementById('fonte_recurso').value;
//     const dataCredito = document.getElementById('data_credito').value;
//     const ordemBancaria = document.getElementById('ordem_bancaria').value;
//     const valorCredito = document.getElementById('valor_credito').value;

//     if (!nome || !valorContrato || !fonteRecurso || !dataCredito || !ordemBancaria || !valorCredito) {
//         alert('Por favor, preencha todos os campos dos Dados dos Centros de Custo antes de enviar.');
//         return;  
//     }


//     const tabelaCentro = document.getElementById('tabela-centro');
//     const novaLinha = tabelaCentro.insertRow(-1);

//     novaLinha.insertCell(0).innerText = nome;
//     novaLinha.insertCell(1).innerText = valorContrato;
//     novaLinha.insertCell(2).innerText = fonteRecurso;
//     novaLinha.insertCell(3).innerText = dataCredito;
//     novaLinha.insertCell(4).innerText = ordemBancaria;
//     novaLinha.insertCell(5).innerText = valorCredito;

//     document.getElementById('nome_centro').value = '';
//     document.getElementById('valor_contrato').value = '';
//     document.getElementById('fonte_recurso').value = '';
//     document.getElementById('data_credito').value = '';
//     document.getElementById('ordem_bancaria').value = '';
//     document.getElementById('valor_credito').value = '';
// }

// const menuBtn = document.getElementById('menuBtn');
// const closeBtn = document.getElementById('closeBtn');
// const sidebar = document.getElementById('sidebar');
// const overlay = document.getElementById('overlay');

// // Função para abrir a barra lateral
// menuBtn.addEventListener('click', () => {
//     sidebar.classList.add('open');
//     overlay.classList.add('active');
// });

// // Função para fechar a barra lateral
// closeBtn.addEventListener('click', () => {
//     sidebar.classList.remove('open');
//     overlay.classList.remove('active');
// });

// // Fechar a barra lateral ao clicar fora dela (overlay)
// overlay.addEventListener('click', () => {
//     sidebar.classList.remove('open');
//     overlay.classList.remove('active');
// });


// // CHAT

// function salvarDadosOrgao() {
//     const dadosOrgao = JSON.parse(localStorage.getItem('dadosOrgao')) || [];
//     const contrato = document.getElementById('contrato_orgao').value;
//     const razaoSocial = document.getElementById('razao_social').value;
//     const cnpj = document.getElementById('cnpj').value;
//     const responsavel = document.getElementById('responsavel').value;
//     const contato = document.getElementById('contato').value;
//     const email = document.getElementById('email').value;

//     if (!contrato || !razaoSocial || !cnpj || !responsavel || !contato || !email) {
//         alert('Por favor, preencha todos os campos dos Dados do Órgão antes de enviar.');
//         return;
//     }

//     const novoDadoOrgao = { contrato, razaoSocial, cnpj, responsavel, contato, email };
//     dadosOrgao.push(novoDadoOrgao);
//     localStorage.setItem('dadosOrgao', JSON.stringify(dadosOrgao));

//     adicionarLinhaTabelaOrgao(novoDadoOrgao);
//     limparFormularioOrgao();
// }

// function salvarDadosCentro() {
//     const dadosCentro = JSON.parse(localStorage.getItem('dadosCentro')) || [];
//     const nome = document.getElementById('nome_centro').value;
//     const valorContrato = document.getElementById('valor_contrato').value;
//     const fonteRecurso = document.getElementById('fonte_recurso').value;
//     const dataCredito = document.getElementById('data_credito').value;
//     const ordemBancaria = document.getElementById('ordem_bancaria').value;
//     const valorCredito = document.getElementById('valor_credito').value;

//     if (!nome || !valorContrato || !fonteRecurso || !dataCredito || !ordemBancaria || !valorCredito) {
//         alert('Por favor, preencha todos os campos dos Dados dos Centros de Custo antes de enviar.');
//         return;
//     }

//     const novoDadoCentro = { nome, valorContrato, fonteRecurso, dataCredito, ordemBancaria, valorCredito };
//     dadosCentro.push(novoDadoCentro);
//     localStorage.setItem('dadosCentro', JSON.stringify(dadosCentro));

//     adicionarLinhaTabelaCentro(novoDadoCentro);
//     limparFormularioCentro();
// }

// function adicionarLinhaTabelaOrgao(dado) {
//     const tabelaOrgao = document.getElementById('tabela-orgao');
//     const novaLinha = tabelaOrgao.insertRow(-1);
//     novaLinha.insertCell(0).innerText = dado.contrato;
//     novaLinha.insertCell(1).innerText = dado.razaoSocial;
//     novaLinha.insertCell(2).innerText = dado.cnpj;
//     novaLinha.insertCell(3).innerText = dado.responsavel;
//     novaLinha.insertCell(4).innerText = dado.contato;
//     novaLinha.insertCell(5).innerText = dado.email;
// }

// function adicionarLinhaTabelaCentro(dado) {
//     const tabelaCentro = document.getElementById('tabela-centro');
//     const novaLinha = tabelaCentro.insertRow(-1);
//     novaLinha.insertCell(0).innerText = dado.nome;
//     novaLinha.insertCell(1).innerText = dado.valorContrato;
//     novaLinha.insertCell(2).innerText = dado.fonteRecurso;
//     novaLinha.insertCell(3).innerText = dado.dataCredito;
//     novaLinha.insertCell(4).innerText = dado.ordemBancaria;
//     novaLinha.insertCell(5).innerText = dado.valorCredito;
// }

// function carregarDadosOrgao() {
//     const dadosOrgao = JSON.parse(localStorage.getItem('dadosOrgao')) || [];
//     dadosOrgao.forEach(dado => adicionarLinhaTabelaOrgao(dado));
// }

// function carregarDadosCentro() {
//     const dadosCentro = JSON.parse(localStorage.getItem('dadosCentro')) || [];
//     dadosCentro.forEach(dado => adicionarLinhaTabelaCentro(dado));
// }

// function limparFormularioOrgao() {
//     document.getElementById('contrato_orgao').value = '';
//     document.getElementById('razao_social').value = '';
//     document.getElementById('cnpj').value = '';
//     document.getElementById('responsavel').value = '';
//     document.getElementById('contato').value = '';
//     document.getElementById('email').value = '';
// }

// function limparFormularioCentro() {
//     document.getElementById('nome_centro').value = '';
//     document.getElementById('valor_contrato').value = '';
//     document.getElementById('fonte_recurso').value = '';
//     document.getElementById('data_credito').value = '';
//     document.getElementById('ordem_bancaria').value = '';
//     document.getElementById('valor_credito').value = '';
// }

// // Carregar dados ao iniciar a página
// window.onload = function() {
//     carregarDadosOrgao();
//     carregarDadosCentro();
// };


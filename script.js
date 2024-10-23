// const menuBtn = document.getElementById('menuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

let contador = 0;

// Função para abrir a barra lateral
menuBtn.addEventListener('click', () => {
    contador+=1;
    if(contador % 2 == 1){
        sidebar.classList.add('open');
        overlay.classList.add('active');
    }else{
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }

});

// Fechar a barra lateral ao clicar fora dela (overlay)
overlay.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');

    contador+=1;
});

//Muda de opção e esconde as outras
// document.querySelectorAll('.nav-options a').forEach(link => {
//     link.addEventListener('click', function(event) {
//         event.preventDefault(); // Evita o comportamento padrão do link

//         // Obtém o ID da div a ser mostrada
//         const targetId = this.getAttribute('data-target');

//         // Esconde todas as divs
//         document.querySelectorAll('.styleCotacoesOpcoes').forEach(div => {
//             div.classList.add('hidden');
//         });

//         // Mostra a div correspondente
//         const targetDiv = document.getElementById(targetId);
//         if (targetDiv) {
//             targetDiv.classList.remove('hidden');
//         }
//     });
// });

// document.getElementById('userId').addEventListener('click', function() {
//     console.log('opa');
//     document.getElementById('opcoesUser').classList.remove('hidden');
// });

// document.getElementById('opcaoRespondido').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.remove('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.add('hidden');
//     document.getElementById('cotacoesAprovadas').classList.add('hidden');
//     document.getElementById('cotacoesReprovadas').classList.add('hidden');
//     document.getElementById('cotacoesFaturadas').classList.add('hidden');
//     document.getElementById('cotacoesCanceladas').classList.add('hidden');
// });

// document.getElementById('opcaoRejeitado').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.add('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.remove('hidden');
//     document.getElementById('cotacoesAprovadas').classList.add('hidden');
//     document.getElementById('cotacoesReprovadas').classList.add('hidden');
//     document.getElementById('cotacoesFaturadas').classList.add('hidden');
//     document.getElementById('cotacoesCanceladas').classList.add('hidden');
// });

// document.getElementById('opcaoAprovado').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.add('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.add('hidden');
//     document.getElementById('cotacoesAprovadas').classList.remove('hidden');
//     document.getElementById('cotacoesReprovadas').classList.add('hidden');
//     document.getElementById('cotacoesFaturadas').classList.add('hidden');
//     document.getElementById('cotacoesCanceladas').classList.add('hidden');
// });

// document.getElementById('opcaoReprovado').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.add('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.add('hidden');
//     document.getElementById('cotacoesAprovadas').classList.add('hidden');
//     document.getElementById('cotacoesReprovadas').classList.remove('hidden');
//     document.getElementById('cotacoesFaturadas').classList.add('hidden');
//     document.getElementById('cotacoesCanceladas').classList.add('hidden');
// });

// document.getElementById('opcaoFaturado').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.add('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.add('hidden');
//     document.getElementById('cotacoesAprovadas').classList.add('hidden');
//     document.getElementById('cotacoesReprovadas').classList.add('hidden');
//     document.getElementById('cotacoesFaturadas').classList.remove('hidden');
//     document.getElementById('cotacoesCanceladas').classList.add('hidden');
// });

// document.getElementById('opcaoCancelado').addEventListener('click', function() {
//     document.getElementById('cotacoesEmAndamento').classList.add('hidden');
//     document.getElementById('cotacoesRespondidas').classList.add('hidden');
//     document.getElementById('cotacoesRejeitadas').classList.add('hidden');
//     document.getElementById('cotacoesAprovadas').classList.add('hidden');
//     document.getElementById('cotacoesReprovadas').classList.add('hidden');
//     document.getElementById('cotacoesFaturadas').classList.add('hidden');
//     document.getElementById('cotacoesCanceladas').classList.remove('hidden');
// });

// Verifica se usuário fechou a página
// Define uma variável para verificar se a página foi carregada anteriormente
let isClosing = false;

// Listener para o evento beforeunload
window.addEventListener('beforeunload', function (e) {
    if (isClosing) {
        // Criação do XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php', true); // Assíncrona
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Enviar a requisição ao PHP
        xhr.send('pagina_fechada=true');
    }
});

// Listener para o evento visibilitychange
document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'hidden') {
        isClosing = true; // Define que a página pode estar sendo fechada
    } else {
        isClosing = false; // A página está visível, então não está fechada
    }
});



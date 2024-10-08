const menuBtn = document.getElementById('menuBtn');
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
document.getElementById('opcaoEmAndamento').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.remove('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoRespondido').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.remove('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoRejeitado').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.remove('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoAprovado').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.remove('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoReprovado').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.remove('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoFaturado').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.remove('hidden');
    document.getElementById('cotacoesCanceladas').classList.add('hidden');
});

document.getElementById('opcaoCancelado').addEventListener('click', function() {
    document.getElementById('cotacoesEmAndamento').classList.add('hidden');
    document.getElementById('cotacoesRespondidas').classList.add('hidden');
    document.getElementById('cotacoesRejeitadas').classList.add('hidden');
    document.getElementById('cotacoesAprovadas').classList.add('hidden');
    document.getElementById('cotacoesReprovadas').classList.add('hidden');
    document.getElementById('cotacoesFaturadas').classList.add('hidden');
    document.getElementById('cotacoesCanceladas').classList.remove('hidden');
});

// Verifica se usuário fechou a página
window.addEventListener('beforeunload', function (e) {
    // Criação do XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php', true); // Assíncrona
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Enviar a requisição ao PHP
    xhr.send('pagina_fechada=true');

});

// // const menuBtn = document.getElementById('menuBtn');
// const sidebar = document.getElementById('sidebar');
// const overlay = document.getElementById('overlay');

// let contador = 0;

// // Função para abrir a barra lateral
// menuBtn.addEventListener('click', () => {
//     contador+=1;
//     if(contador % 2 == 1){
//         sidebar.classList.add('open');
//         overlay.classList.add('active');
//     }else{
//         sidebar.classList.remove('open');
//         overlay.classList.remove('active');
//     }

// });

// // Fechar a barra lateral ao clicar fora dela (overlay)
// overlay.addEventListener('click', () => {
//     sidebar.classList.remove('open');
//     overlay.classList.remove('active');

//     contador+=1;
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



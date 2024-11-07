 // Seleciona o botão do menu e o menu em si
 const menuBtn = document.getElementById('menuBtn');
 const menuOptions = document.getElementById('menu-options');

 // Adiciona o evento de clique para alternar a classe active
 menuBtn.addEventListener('click', () => {
     menuOptions.classList.toggle('active');
 });



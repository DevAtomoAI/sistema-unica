
<?php
session_start();
if(isset($_SESSION['nome'])) {
    $nomeUsuario = $_SESSION['nome'];
} else {
    $nomeUsuario = "Convidado"; // Se não estiver logado, exibe "Convidado"
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovado</title>
    <link rel="stylesheet" href="aprovado.css">
    <link rel="shortcut icon" href="icone.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<body>

    <div class="overlay" id="overlay"></div>
 
        <!-- Barra lateral -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <button id="closeBtn">&times;</button>
    </div>
    <ul class="nav-options">

        <li>
            <a href="dados.php">
                <img src="imgs/dados.svg"> Meus dados
            </a>
        </li>

        <li>
            <a href="incluir.php">
                <img src="imgs/time.svg"> Incluir
            </a>
        </li>
        <li>
            <a href="andamento.php">
                <img src="imgs/clock.svg"> Em andamento
            </a>
        </li>
        <li>
            <a href="aprovado.php">
                <img src="imgs/check.svg"> Aprovado
            </a>
        </li>
        <li>
            <a href="#faturado">
                <img src="imgs/paper.svg"> Faturado
            </a>
        </li>
        <li>
            <a href="#cancelado">
                <img src="imgs/cancel.svg"> Cancelado
            </a>
        </li>
    </ul>
</div>

 <!-- Barra Superior -->
    <header class="top-bar">
        <div class="left-icons">
            <div class="menu-icon" id="menuBtn" >
               <a> <img src="imgs/menu.svg"> </a>  
            </div>
            <div class="logo">
                <img src="imgs/minilogo.svg">
            </div>
        </div>
        <div class="right-icons">
            <div class="notification-icon">
                <img src="imgs/Doorbell.svg">
            </div>

            <div class="user-name"> 
    <p><?php echo $nomeUsuario; ?></p>
</div>


            <div class="user-icon">
                <img src="imgs/user.svg">
            </div>
        </div>
    </header>

     <!-- CONTEUDO PRINCIPAL -->

     <div class="main-content" id="main-content">
        <h1 class="text-cotand">Cotações aprovadas</h1>

        <!-- Barra de busca -->
        <div class="search-bar">
            <input type="text" placeholder="Busca">
            <select>
                <option value="">Centro de Custo</option>
            </select>
            <input type="text" placeholder="Placa">
            <select>
                <option value="">Ordenar</option>
            </select>
            <button class="btn-search"><i class="fas fa-search"></i> Pesquisar</button>
            <button class="btn-print"><i class="fas fa-print"></i> Imprimir</button>
        </div>

        <!-- Tabela de cotações -->
        <!-- Tabela de cotações aprovadas -->
<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Centro de Custo</th>
                <th>Vencedor</th>
                <th>Data de Abertura</th>
                <th>Valor Fechamento</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aqui o JS irá inserir as cotações aprovadas dinamicamente -->
        </tbody>
    </table>
</div>

    </div>




    
    <script src="aprovado.js"></script>
</body>
</html>
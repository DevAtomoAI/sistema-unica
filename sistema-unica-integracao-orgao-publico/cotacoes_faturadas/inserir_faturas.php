<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body></body>

    <h3>fatura peças</h3>
    <input type="file" name="faturaPecas" id="faturaPecas">

    <h3>fatura serviços</h3>
    <input type="file" name="faturaServicos" id="faturaServicos">

    <button name="concluiFatura" id="concluiFatura" onclick="recebeFaturas()">Concluir</button>
    <a href="faturadas.php"><button >Voltar</button></a>

    <script src="faturada.js" ></script>
</body>
</html>
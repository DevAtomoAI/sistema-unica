<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="incluir_fornecedores.css">
</head>

<body>
    <form action="config_fornecedores.php" method="POST">
        <input type="text" name="nomeFornecedor" placeholder="Nome fornecedor">
        <input type="text" name="tipoFornecedor" placeholder="Tipo">
        <input type="text" name="enderecoFornecedor" placeholder="Endereco fornecedor">
        <input type="text" name="cidadeFornecedor" placeholder="Cidade fornecedor">
        <input type="text" name="estadoFornecedor" placeholder="Estado fornecedor">
        <input type="text" name="contatoFornecedor" placeholder="Contato fornecedor">
        <button name="salvaValoresFornecedores">Salvar novo fornecedor</button>
    </form>
</body>

</html>
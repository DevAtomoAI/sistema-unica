<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="configs_faturadas.php" method="POST" enctype="multipart/form-data">
        <input type="file" accept=".pdf" name="pdfPecas" required>
        <br>
        <br>
        <input type="file" accept=".pdf" name="pdfServicos" required>
        <br>
        <br>
        <button name="submitPdf">Enviar faturas</button>

    </form>
</body>
</html>
<?php

include_once("../database/config.php");
$id = $_GET["id"];

$stmt = $conexao->prepare("SELECT fatura_pecas FROM infos_veiculos_aprovados_oficina WHERE id_veiculo_incluso_orgao_publico = ?");
$stmt->bind_param("i", $id);  // Corrigido para usar bind_param para proteger contra SQL Injection
$stmt->execute();

// Como só há uma coluna, vinculamos apenas uma variável
$stmt->bind_result($pdf_content);
$stmt->fetch();
$stmt->close();

if ($pdf_content) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="faturaPecas.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($pdf_content));

    echo $pdf_content;
    exit;
}

$conexao->close();

?>

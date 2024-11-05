<?php

include_once("../database/config.php");
$id = $_GET["id"];

$stmt = $conexao->prepare("SELECT fatura_servicos FROM infos_veiculos_inclusos WHERE id_infos_veiculos_inclusos = ?");
$stmt->bind_param("i", $id);  // Corrigido para usar bind_param para proteger contra SQL Injection
$stmt->execute();

// Como só há uma coluna, vinculamos apenas uma variável
$stmt->bind_result($pdf_content);
$stmt->fetch();
$stmt->close();

if ($pdf_content) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="faturaServicos.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($pdf_content));

    echo $pdf_content;
    exit;
}

$conexao->close();

?>

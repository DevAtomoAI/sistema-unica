<?php
require_once('../inc/config.php');

// Função para lidar com erros do PHP e garantir resposta JSON
function handlePhpError($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(["mensagem" => "Erro: $errstr em $errfile na linha $errline"]);
    exit();
}

// Configura o manipulador de erros personalizado
set_error_handler('handlePhpError');

// Função para listar orçamentos
function listBudgets($authToken) {
    $url = 'https://qa.cilia.com.br/api/integration/budgets/list_budgets';
    return fetchFromApi($url, $authToken);
}

// Função genérica para buscar dados de um endpoint da API
function fetchFromApi($url, $authToken) {
    // Inicializa o cURL
    $ch = curl_init();
    
    // Configurações do cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'auth_token: ' . $authToken
    ]);
    
    // Executa a requisição
    $response = curl_exec($ch);
    
    // Verifica se houve erro
    if (curl_errno($ch)) {
        return ['erro' => curl_error($ch)];
    }
    
    // Verifica se a resposta é JSON
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode == 200) {
        $responseData = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $responseData;
        } else {
            return ['erro' => 'Resposta JSON inválida: ' . json_last_error_msg()];
        }
    } else {
        return ['erro' => 'Código HTTP ' . $httpCode . ': ' . htmlspecialchars($response)];
    }
}

// Adicione mais funções conforme necessário para outros endpoints
// Exemplo:
// function getUserDetails($authToken, $userId) {
//     $url = 'https://qa.cilia.com.br/api/integration/users/' . $userId;
//     return fetchFromApi($url, $authToken);
// }

?>

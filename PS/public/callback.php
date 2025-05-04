<?php
require_once __DIR__ . '/../auth/auth-config.php';

// 1. Obter o código de autorização
$code = $_GET['code'] ?? null;

if (!$code) {
    die("Código de autorização não encontrado!");
}

// 2. Trocar o código por um token
$token_url = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/token";

$data = [
    'grant_type' => 'authorization_code',
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
    'redirect_uri' => REDIRECT_URI,
    'code' => $code
];



$data = [
    'grant_type' => 'authorization_code',
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,  // Removido client_secret
    'code' => $code
];


$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);

if ($response === FALSE) {
    die("Falha ao obter token");
}

// 3. Decodificar a resposta
$token_data = json_decode($response, true);
$access_token = $token_data['access_token'] ?? null;

if (!$access_token) {
    die("Token de acesso não recebido");
}

// 4. Obter informações do usuário
$userinfo_url = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/userinfo";
$options = [
    'http' => [
        'header' => "Authorization: Bearer $access_token\r\n",
        'method' => 'GET'
    ]
];

$context = stream_context_create($options);
$userinfo = file_get_contents($userinfo_url, false, $context);
$user = json_decode($userinfo, true);

// 5. Verificar e exibir os dados
if (!$user) {
    die("Falha ao obter informações do usuário");
}

// Exemplo de uso:
echo "Bem-vindo, " . htmlspecialchars($user['preferred_username'] ?? 'Usuário');
?>
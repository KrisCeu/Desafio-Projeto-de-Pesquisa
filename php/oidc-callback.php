<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['code'])) {
    die("Código de autorização não encontrado.");
}

$code = $_GET['code'];

// Parâmetros para a troca do token
$token_url = "http://localhost:8080/realms/autentica_realm/protocol/openid-connect/token";
$client_id = "oidc-aplicacao";
$redirect_uri = "http://localhost:8000/oidc-callback.php";

// Montar os dados da requisição
$data = [
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirect_uri,
    'client_id' => $client_id
];

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

// Executar e capturar a resposta
$response = curl_exec($ch);
curl_close($ch);

// Converter resposta JSON
$token_response = json_decode($response, true);

// Exibir a resposta para debug
echo "<h2>Resposta do servidor:</h2><pre>";
print_r($token_response);
echo "</pre>";

// Verificar se o access_token foi recebido
if (!isset($token_response['access_token'])) {
    die("Access token não encontrado.");
}

$access_token = $token_response['access_token'];

// Decodificar o payload do JWT (segunda parte do token)
$parts = explode('.', $access_token);
if (count($parts) !== 3) {
    die("Token JWT inválido.");
}

$payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true); // Ajusta base64 para o padrão correto

echo "<h2>Payload do token:</h2><pre>";
print_r($payload);
echo "</pre>";

// Verificar o atributo personalizado 'nivel_acesso'
// Verificar se o nível de autenticação (acr) é alto (5)
if (isset($payload['acr']) && $payload['acr'] === '5') {
    echo "<h3>Acesso concedido: nível de acesso ALTO</h3>";
    echo "<p>Bem-vindo(a), " . htmlspecialchars($payload['preferred_username']) . "</p>";
} else {
    http_response_code(403); // Código de acesso proibido
    echo "<h3>Acesso negado: nível de acesso insuficiente</h3>";
    exit;
}
?>

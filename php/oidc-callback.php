<?php
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

echo "<h2>Resposta do servidor:</h2><pre>";
print_r($token_response);
echo "</pre>";
?>

<?php
// 1) Obter token via Client Credentials
$tokenUrl   = "http://localhost:8080/realms/autentica_realm/protocol/openid-connect/token";
$clientId   = "registrador";
$clientSecret = "secretKey";

$ch = curl_init($tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type'    => 'client_credentials',
    'client_id'     => $clientId,
    'client_secret' => $clientSecret,
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);
$tokenResp = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($tokenResp['access_token'])) {
    die("Falha ao obter token: " . print_r($tokenResp, true));
}
$accessToken = $tokenResp['access_token'];

// 2) Registrar um novo client (RFC 7591)
$regUrl = "http://localhost:8080/realms/autentica_realm/clients-registrations/default";

// Defina aqui o payload do novo client
$newClient = [
  // opcional: se quiser Keycloak gere o client_id, omita esta linha
  //'client_id'                   => 'ps_app_client',  
  'client_name'                 => 'Meu PS App',
  'redirect_uris'               => ['http://localhost:8000/oidc-callback.php'],
  'grant_types'                 => ['authorization_code'],
  'response_types'              => ['code'],
  'token_endpoint_auth_method'  => 'none'          // public client
];

$ch = curl_init($regUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newClient));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessToken",
    'Content-Type: application/json'
]);
$createResp = json_decode(curl_exec($ch), true);
curl_close($ch);

echo "<h2>Cliente registrado:</h2><pre>";
print_r($createResp);
echo "</pre>";
?>
<?php
// get-token.php — obtém um access token para o client 'registrador'

$clientId = 'registrador';
$clientSecret = 'secretKey';
$tokenUrl = 'http://localhost:8080/realms/autentica_realm/protocol/openid-connect/token';

$data = http_build_query([
    'grant_type' => 'client_credentials',
    'client_id' => $clientId,
    'client_secret' => $clientSecret
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);
$accessToken = $token['access_token'];

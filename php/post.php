<?php
// post.php — registra um novo client dinamicamente via RFC 7591

// Requer o token do client registrador
require 'get-token.php'; // Supondo que este arquivo define $accessToken

// Novo client que será registrado dinamicamente
$newClient = [
    'clientId' => 'cliente-dinamico-exemplo',              // ID desejado do novo client
    'client_name' => 'Cliente Dinâmico Exemplo',            // Nome amigável
    'redirect_uris' => ['http://localhost:3000/callback'],  // URIs de redirecionamento válidas
    'grant_types' => ['authorization_code'],                // Tipos de grant suportados
    'response_types' => ['code'],                           // Tipos de resposta
    'token_endpoint_auth_method' => 'client_secret_basic'   // Método de autenticação
];

// Inicializa cURL para fazer a requisição POST ao endpoint de registro
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/realms/autentica_realm/clients-registrations/default");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newClient));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken
]);

// Executa a requisição
$response = curl_exec($ch);

// Verifica por erros
if (curl_errno($ch)) {
    echo 'Erro: ' . curl_error($ch);
} else {
    echo "Resposta do Keycloak:\n";
    echo $response;
}

curl_close($ch);

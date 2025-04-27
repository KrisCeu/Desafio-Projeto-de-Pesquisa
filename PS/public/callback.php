<?php
require_once __DIR__ . '/../auth/auth-config.php';

if (!isset($_GET['code'])) {
    die("Código de autorização não encontrado.");
}
// verifica totp:
$userHasTOTP = isset($payload['acr']) && $payload['acr'] === '2'; // Nível 2 = TOTP configurado

if ($user['nivel_acesso'] === 'alto' && !$userHasTOTP) {
    $_SESSION['pending_totp_setup'] = true;
    header("Location: /totp-prompt.php"); // Página de escolha
    exit;
}

// Troca o código por token
$token_url = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/token";
$data = [
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'redirect_uri' => REDIRECT_URI,
    'client_id' => CLIENT_ID
];

$ch = curl_init($token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$token = json_decode($response, true);
if (!isset($token['access_token'])) {
    die("Falha ao obter token.");
}

// Decodifica o token JWT
$parts = explode('.', $token['access_token']);
$payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);

// Verifica nivel_acesso (do atributo do usuário ou grupo)
$nivel_acesso = $payload['nivel_acesso'] ?? 'baixo';

// Inicia sessão segura
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true // Habilitar se usar HTTPS
]);
$_SESSION['user'] = [
    'username' => $payload['preferred_username'],
    'nivel_acesso' => $nivel_acesso,
    'access_token' => $token['access_token'] // Opcional para chamadas API
];

// Redireciona para área protegida
header("Location: /dashboard.php");
?>
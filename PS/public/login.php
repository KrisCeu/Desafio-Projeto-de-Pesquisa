<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o arquivo de configuração existe
$config_file = __DIR__ . '/../auth/auth-config.php';
if (!file_exists($config_file)) {
    die("Erro: auth-config.php não encontrado em $config_file");
}

require_once $config_file;  // Use require_once para evitar inclusões múltiplas

// Verifica se as constantes estão definidas
if (!defined('KEYCLOAK_URL') || !defined('REALM') || !defined('CLIENT_ID') || !defined('REDIRECT_URI')) {
    die("Erro: Variáveis não definidas no auth-config.php");
}

// Constrói a URL de redirecionamento
$auth_url = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/auth";
$params = [
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid profile'
];

// Redireciona
header("Location: $auth_url?" . http_build_query($params));  // **Use a URL completa com parâmetros**
exit;
?>
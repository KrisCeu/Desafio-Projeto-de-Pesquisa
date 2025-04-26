<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Current dir: " . __DIR__;
echo "Trying to load: " . __DIR__ . '/../auth/auth-config.php';
require_once __DIR__ . '/../auth/auth-config.php';

$auth_url = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/auth";
$params = [
    'client_id' => CLIENT_ID,
    'redirect_uri' => REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid profile'
];

header("Location: $auth_url?" . http_build_query($params));
?>
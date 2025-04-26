<?php
require_once __DIR__ . '/../auth/auth-config.php';

// 1. Encerra a sessão local
session_start();
session_destroy();

// 2. Prepara URL de logout sem id_token_hint
$logoutUrl = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/logout";
$redirectUrl = 'http://localhost:8000/logout-success.php'; // Página de confirmação

// 3. Redirecionamento seguro (alternativo sem token)
header("Location: {$logoutUrl}?redirect_uri=" . urlencode($redirectUrl));
exit;
?>
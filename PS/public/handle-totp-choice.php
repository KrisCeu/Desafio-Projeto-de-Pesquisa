<?php
session_start();
require_once __DIR__ . '/../auth/auth-config.php';

if ($_POST['action'] === 'accept') {
    // Redireciona para configuração do TOTP no Keycloak
    header("Location: " . KEYCLOAK_URL . "/realms/" . REALM . "/account/totp");
    exit;
} else {
    // Logout e mensagem de explicação
    session_destroy();
    header("Location: /logout.php?reason=totp_required");
    exit;
}
?>
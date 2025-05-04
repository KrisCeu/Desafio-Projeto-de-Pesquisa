<?php
require_once __DIR__ . '/../auth/auth-config.php';

session_start();
$reason = $_SESSION['logout_reason'] ?? null;
session_destroy();

// Logout no Keycloak
$logoutUrl = KEYCLOAK_URL . "/realms/" . REALM . "/protocol/openid-connect/logout";
$redirectUrl = $reason 
    ? 'http://localhost:8000/logout.php?reason=' . urlencode($reason) 
    : 'http://localhost:8000/logout-success.php';

header("Location: {$logoutUrl}?redirect_uri=" . urlencode($redirectUrl));
exit;
?>
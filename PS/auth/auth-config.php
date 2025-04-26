<?php
// Configurações do Keycloak
define('KEYCLOAK_URL', 'http://localhost:8080');
define('REALM', 'autentica_realm');
define('CLIENT_ID', 'oidc-aplicacao');
define('CLIENT_SECRET', ''); // Seu client é PUBLIC
define('REDIRECT_URI', 'http://localhost:8000/callback.php');
?>
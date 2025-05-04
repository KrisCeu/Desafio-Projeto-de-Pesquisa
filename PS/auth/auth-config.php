<?php
// Configurações padrão que correspondem ao Terraform
define('KEYCLOAK_URL', 'http://keycloak:8080');
define('REALM', 'autentica_realm');
define('CLIENT_ID', 'oidc-aplicacao');
define('CLIENT_SECRET', ''); // Vazio para client público
define('REDIRECT_URI', 'http://localhost:8000/callback.php');
?>
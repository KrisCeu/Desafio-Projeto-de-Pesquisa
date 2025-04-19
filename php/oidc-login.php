<?php
$client_id = "oidc-aplicacao";
$redirect_uri = "http://localhost:8000/oidc-callback.php";
$realm = "autentica_realm";
$keycloak_base_url = "http://localhost:8080";

$auth_url = "$keycloak_base_url/realms/$realm/protocol/openid-connect/auth?"
    . http_build_query([
        "client_id" => $client_id,
        "response_type" => "code",
        "redirect_uri" => $redirect_uri,
    ]);

header("Location: $auth_url");
exit;
?>
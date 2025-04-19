//arquivo para fazer a "oidc" (OpenID Connect)
resource "keycloak_openid_client" "cliente_web" {
  realm_id = keycloak_realm.autentica_realm.id
  client_id = "oidc-aplicacao"
  name = "oidc Aplicação"
  enabled = true
  access_type = "PUBLIC"
  standard_flow_enabled = true
  direct_access_grants_enabled = true
  root_url = "http://localhost:3000"
 valid_redirect_uris = [
  "http://localhost:8000/oidc-callback.php",
  "http://localhost:8000/*"        # opcional, para permitir qualquer rota sob /8000
]

  web_origins = ["+"]
 
}

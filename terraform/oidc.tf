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
  "http://localhost:8000/callback.php",
  "http://localhost:8000/*"        # opcional, para permitir qualquer rota sob /8000
]

  web_origins = ["+"]
 
  valid_post_logout_redirect_uris = [
    "http://localhost:8000/logout-success.php"
  ]

}

#mapper para incluir o atributo 'nivel_acesso' no token
resource "keycloak_openid_user_attribute_protocol_mapper" "nivel_acesso_mapper" {
  realm_id  = keycloak_realm.autentica_realm.id
  client_id = keycloak_openid_client.cliente_web.id
  name      = "nivel_acesso"

  user_attribute   = "nivel_acesso"  # Atributo customizado do usuário
  claim_name      = "nivel_acesso"   # Nome do claim no token JWT
  claim_value_type = "String"        # Tipo do valor
  add_to_id_token = true             # Inclui no ID Token
  add_to_access_token = true         # Inclui no Access Token
}

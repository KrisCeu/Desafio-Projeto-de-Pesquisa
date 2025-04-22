# 1. Fluxo principal
resource "keycloak_authentication_flow" "custom_browser" {
  realm_id    = keycloak_realm.autentica_realm.id
  alias       = "custom-browser"
  description = "Fluxo com TOTP opcional"
  provider_id = "basic-flow"
}


# 3. Execução username/password
resource "keycloak_authentication_execution" "username_password" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.custom_browser.alias
  authenticator     = "auth-username-password-form"
  requirement       = "REQUIRED"
}

# 4. Subflow condicional TOTP
resource "keycloak_authentication_subflow" "subflow_totp" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.custom_browser.alias
  alias             = "subflow-totp-check"
  provider_id       = "basic-flow"
  requirement       = "ALTERNATIVE" # <- Required para que o condicional seja sempre avaliado
}

# 5. Verifica se o usuário configurou TOTP
resource "keycloak_authentication_execution" "totp_condition" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.subflow_totp.alias
  authenticator     = "auth-otp-form"
  requirement       = "REQUIRED"
}

# 6. Executa TOTP se a condição anterior for verdadeira
resource "keycloak_authentication_execution_config" "totp" {
  realm_id = keycloak_realm.autentica_realm.id
  alias = "no_flow_authentica"
  execution_id = keycloak_authentication_execution.totp_condition.id
  config = {
  }
}

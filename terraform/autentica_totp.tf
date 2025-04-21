# 1. Fluxo principal
resource "keycloak_authentication_flow" "custom_browser" {
  realm_id    = keycloak_realm.autentica_realm.id
  alias       = "custom-browser"
  description = "Fluxo com TOTP opcional"
  provider_id = "basic-flow"
}

# 2. Subflow de formulários (senha)
resource "keycloak_authentication_subflow" "forms" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.custom_browser.alias
  alias             = "forms-forms"
  provider_id       = "basic-flow"
  requirement       = "REQUIRED"
}

# 3. Execução username/password
resource "keycloak_authentication_execution" "username_password" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.forms.alias
  authenticator     = "auth-username-password-form"
  requirement       = "REQUIRED"
}

# 4. Subflow condicional TOTP
resource "keycloak_authentication_subflow" "subflow_totp" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.custom_browser.alias
  alias             = "subflow-totp-check"
  provider_id       = "basic-flow"
  requirement       = "REQUIRED" # <- Required para que o condicional seja sempre avaliado
}

# 5. Verifica se o usuário configurou TOTP
resource "keycloak_authentication_execution" "totp_condition" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.subflow_totp.alias
  authenticator     = "conditional-user-configured"
  requirement       = "REQUIRED"
}

# 6. Executa TOTP se a condição anterior for verdadeira
resource "keycloak_authentication_execution" "totp" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.subflow_totp.alias
  authenticator     = "auth-otp-form"
  requirement       = "REQUIRED"
}

# 7. Bind ao fluxo do navegador
resource "keycloak_authentication_bindings" "bind_browser" {
  realm_id     = keycloak_realm.autentica_realm.id
  browser_flow = keycloak_authentication_flow.custom_browser.alias
}

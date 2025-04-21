# Criação do fluxo principal
resource "keycloak_authentication_flow" "custom_browser" {
  realm_id    = keycloak_realm.autentica_realm.id
  alias       = "custom-browser"
  description = "Fluxo de autenticação personalizado com TOTP opcional"
  provider_id = "basic-flow"
}

# Subflow de formulários (como no padrão)
resource "keycloak_authentication_subflow" "forms" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.custom_browser.alias
  alias             = "forms-forms"
  provider_id       = "basic-flow"
  requirement       = "REQUIRED"
}

# Execução do formulário username/password dentro do subflow
resource "keycloak_authentication_execution" "username_password" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.forms.alias
  authenticator     = "auth-username-password-form"
  requirement       = "REQUIRED"
}

# Execução do TOTP dentro do subflow
resource "keycloak_authentication_execution" "totp" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_subflow.forms.alias
  authenticator     = "auth-otp-form"
  requirement       = "ALTERNATIVE"
}

# Bind do fluxo ao navegador
resource "keycloak_authentication_bindings" "bind_browser" {
  realm_id     = keycloak_realm.autentica_realm.id
  browser_flow = keycloak_authentication_flow.custom_browser.alias
}

# Nível de garantia para username/password
resource "keycloak_authentication_execution_config" "username_password_config" {
  realm_id     = keycloak_realm.autentica_realm.id
  alias        = "username-password-context"
  execution_id = keycloak_authentication_execution.username_password.id

  config = {
    authnContextClassRef = "1"
  }

   depends_on = [
    keycloak_authentication_execution.username_password
  ]
}

# Nível de garantia para TOTP
resource "keycloak_authentication_execution_config" "totp_config" {
  realm_id     = keycloak_realm.autentica_realm.id
  alias        = "totp-context"
  execution_id = keycloak_authentication_execution.totp.id

  config = {
    authnContextClassRef = "5"
  }

  depends_on = [
  keycloak_authentication_execution.totp
]
}

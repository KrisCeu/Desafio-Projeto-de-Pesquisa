resource "keycloak_authentication_flow" "browser_conditional_totp" {
  realm_id    = keycloak_realm.autentica_realm.id
  alias       = "browser-conditional-totp"
  description = "Browser flow that requires TOTP only if nivel_acesso = alto"
  provider_id = "basic-flow"
}

resource "keycloak_authentication_execution" "username_password_form" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.browser_conditional_totp.alias
  authenticator     = "auth-username-password-form"
  requirement       = "REQUIRED"
  priority          = 0
}

resource "keycloak_authentication_execution" "check_nivel_acesso" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.browser_conditional_totp.alias
  authenticator     = "condition-user-attribute"
  requirement       = "CONDITIONAL"
  priority          = 1
}

resource "keycloak_authentication_execution_config" "check_nivel_acesso_config" {
  realm_id     = keycloak_realm.autentica_realm.id
  execution_id = keycloak_authentication_execution.check_nivel_acesso.id

  alias = "Verifica nivel_acesso"

  config = {
    "user.attribute"  = "nivel_acesso"
    "attribute.value" = "alto"
  }
}


resource "keycloak_authentication_execution" "otp_form" {
  realm_id          = keycloak_realm.autentica_realm.id
  parent_flow_alias = keycloak_authentication_flow.browser_conditional_totp.alias
  authenticator     = "auth-otp-form"
  requirement       = "REQUIRED"
  priority          = 2
}

resource "keycloak_authentication_flow_bindings" "bindings" {
  realm_id           = keycloak_realm.autentica_realm.id
  browser_flow_alias = keycloak_authentication_flow.browser_conditional_totp.alias
}

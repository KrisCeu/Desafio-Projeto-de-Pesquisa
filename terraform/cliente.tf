# Criação de um cliente OpenID público que será usado para registrar outros clientes dinamicamente
resource "keycloak_openid_client" "dynamic_client_registration" {
  realm_id                     = keycloak_realm.autentica_realm.id            # Referência ao ID do realm "autentica_realm"
  client_id                    = "dynamic-client-registration"                # Identificador único para o cliente
  name                         = "Dynamic Client Registration"                # Nome descritivo do cliente
  enabled                      = true                                         # Ativa o cliente
  access_type                  = "PUBLIC"                                     # Tipo "PUBLIC" → sem client_secret
  standard_flow_enabled        = true                                         # Permite o Authorization Code Flow
  direct_access_grants_enabled = true                                         # Permite login direto com usuário/senha
  valid_redirect_uris          = ["http://localhost:3000/callback"]           # URIs válidas para redirecionamento pós-login
}

# Criação de um cliente confidencial que atuará como registrador de outros clientes
resource "keycloak_openid_client" "client_registrador" {
  realm_id                     = keycloak_realm.autentica_realm.id           # Realm "autentica_realm"
  client_id                    = "registrador"                               # Identificador único
  name                         = "Client Registrador"                        # Nome do cliente
  access_type                  = "CONFIDENTIAL"                              # Cliente confidencial → usa client_secret
  enabled                      = true                                        # Ativa o cliente
  service_accounts_enabled     = true                                        # Ativa conta de serviço
  standard_flow_enabled        = false                                       # Desativa Authorization Code Flow
  direct_access_grants_enabled = false                                       # Desativa login direto
  client_secret                = "secretKey"                                 # Secret usado para autenticação
}

# Obtém o client interno usado para administração do realm
data "keycloak_openid_client" "realm_management" {
  realm_id  = keycloak_realm.autentica_realm.id         # Realm "autentica_realm"
  client_id = "realm-management"                        # Client interno do Keycloak
}

# Concede permissão à conta de serviço do cliente "registrador" para gerenciar outros clients
resource "keycloak_openid_client_service_account_role" "registrador_manage_clients" {
  realm_id                = keycloak_realm.autentica_realm.id                                         # Realm "autentica_realm"
  service_account_user_id = keycloak_openid_client.client_registrador.service_account_user_id         # Conta de serviço do client registrador
  client_id               = data.keycloak_openid_client.realm_management.id                           # Client interno do Keycloak
  role                    = "manage-clients"                                                          # Permissão para gerenciar clients
}

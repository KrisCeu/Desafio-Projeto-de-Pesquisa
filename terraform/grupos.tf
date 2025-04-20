#cria um grupo no realm autentica_realm e com o nome de nivel_alto e nivel de acesso alto.
resource "keycloak_group" "nivel_alto" {
  realm_id = keycloak_realm.autentica_realm.id
  name = "nivel_alto"
  attributes = {
  "nivel_acesso" = "alto"
  }
}

#grupo de nivel de acesso baixo
resource "keycloak_group" "nivel_baixo" {
  realm_id = keycloak_realm.autentica_realm.id
  name     = "nivel_baixo"
  attributes = {
    "nivel_acesso" = "baixo"
  }
}

#designando os usuarios aos grupos
resource "keycloak_group_memberships" "joao_em_nivel_alto" {
  realm_id = keycloak_realm.autentica_realm.id
  group_id = keycloak_group.nivel_alto.id
  members  = [keycloak_user.joao.username]
}

resource "keycloak_group_memberships" "joaquina_em_nivel_baixo" {
  realm_id = keycloak_realm.autentica_realm.id
  group_id = keycloak_group.nivel_baixo.id
  members  = [keycloak_user.joaquina.username]
}
resource "keycloak_user" "joao" {
  realm_id = keycloak_realm.projeto_realm.id
  username = "joao"
  enabled  = true

  attributes = {
    nivel_acesso = "alto"
  }

  email      = "joao@teste.com"
  first_name = "João"
  last_name  = "Silva"

  initial_password {
    value     = "senha123"
    temporary = false
  }
}

resource "keycloak_user" "maria" {
  realm_id = keycloak_realm.projeto_realm.id
  username = "Joaquina"
  enabled  = true

  attributes = {
    nivel_acesso = "baixo"
  }

  email      = "joaquina@example.com"
  first_name = "Joaquina"
  last_name  = "Oliveira"

  initial_password {
    value     = "senha456"
    temporary = false
  }
}

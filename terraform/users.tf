#! criando os usuarios no keycloack utilizando o realm
//joao será o nome interno usado no terraform
resource "keycloak_user" "joao" {
  //colocando o usuario dentro do realm
  realm_id = keycloak_realm.autentica_realm.id
  username = "joao"
  enabled  = true

  //criando um atributo personalizado chamado "nível de acesso" para usar na autenticação por qrcode
  attributes = {
    nivel_acesso = "alto"
  }

  //dados pessoais do user visíveis no keycloak
  email      = "joao@user.com"
  first_name = "João"
  last_name  = "Silva"

  //senha do user, temporary = false para evitar que o user precise trocar a senha toda vez que for logar
  initial_password {
    value     = "123"
    temporary = false
  }
}

//mesmo processo do user anterior
resource "keycloak_user" "joaquina" {
  realm_id = keycloak_realm.autentica_realm.id
  username = "joaquina"
  enabled  = true

  //há diferença aqui, com nivel de acesso baixo só será necessário a senha, sem uso de qrcode
  attributes = {
    nivel_acesso = "baixo"
  }

  email      = "joaquina@user.com"
  first_name = "Joaquina"
  last_name  = "Oliveira"

  initial_password {
    value     = "1234"
    temporary = false
  }
}

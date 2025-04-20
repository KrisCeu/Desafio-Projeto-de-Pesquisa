#! criando os usuarios no keycloack utilizando o realm
//atribuindo as roles manualmente para conserta os erros de funções false
data "keycloak_role" "default_roles" {
  realm_id = keycloak_realm.autentica_realm.id
  name     = "default-roles-autentica_realm"
}


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

//atruindo os roles default para o joão
resource "keycloak_user_roles" "joao_roles" {
  realm_id = keycloak_realm.autentica_realm.id
  user_id  = keycloak_user.joao.id

  role_ids = [
    data.keycloak_role.default_roles.id
  ]
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

//atruindo os roles default para a joaquina
resource "keycloak_user_roles" "joaquina_roles" {
  realm_id = keycloak_realm.autentica_realm.id
  user_id  = keycloak_user.joaquina.id

  role_ids = [
    data.keycloak_role.default_roles.id
  ]
}

//criando um resource do tipo keycloak realm chamando de autentica realm
resource "keycloak_realm" "autentica_realm" {
  //nome do realm que irá aparecer na interface do keycloak
  realm   = "projeto-realm"
  //ativar o realm quando for criado
  enabled = true
}

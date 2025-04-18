//criando um resource do tipo keycloak realm chamando de autentica realm
resource "keycloak_realm" "autentica_realm" {
  //nome do realm que irá aparecer na interface do keycloak
  realm   = "autentica-realm"
  //ativar o realm quando for criado
  enabled = true

  //Ativar o botão de "Registrar-se"
  registration_allowed = true  
  //Permitir login com email
  login_with_email_allowed = true  
  //Impedir e-mails duplicados
  duplicate_emails_allowed = false 
  //Permitir recuperação de senha
  reset_password_allowed = true  
  //Permitir editar o nome de usuário
  edit_username_allowed = true  
}

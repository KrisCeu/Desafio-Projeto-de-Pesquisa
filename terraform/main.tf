terraform {
  //definindo o provider(provedor) para permitir que o terraform se comunique com o keycloak
  required_providers {
    keycloak = {
      //nome do provider do keycloak, irá procurar o keycloak oficial
      source  = "keycloak/keycloak"
      //versão do provider do keycloak
      version = ">= 4.0.0"
    }
  }
}

//credenciais e endereço do servidor keycloak 
provider "keycloak" {
  //nome do client padrão para autenticar o terraform 
  client_id     = "admin-cli"
  //nome de usuario do administrador 
  username      = "admin"
  //senha do administrador
  password      = "admin"
  //endereço do servidor keycloak (neste caso está se juntando a url do docker)
  url           = "http://localhost:8080"
  //realm  padrão do keycloak
  realm         = "master"
}

# Desafio-Projeto-de-Pesquisa

## Visão Geral

Este projeto implementa um sistema de autenticação com **Keycloak** como Provedor de Identidade (PI) e uma aplicação web PHP como Provedor de Serviço (PS), utilizando autenticação via OIDC com suporte a TOTP, atributos personalizados e controle de acesso por nível de autenticação.

A infraestrutura foi orquestrada com **Docker Compose** e provisionada parcialmente via **Terraform**.

## Arquitetura

```
[Usuário] --> [Aplicação PS em PHP] --> [Keycloak - PI]
                                ↳ Login OIDC
                                ↳ Registro dinâmico 
```

## 📁 Estrutura

```bash
Desafio-Projeto-de-Pesquisa/
├── docker/                 # Arquivos pertencentes ao Docker
├── ps/                     # Scripts e arquivos do Provedor de Serviços
├── terraform/              # Arquivos de infraestrutura como código via Terraform
├── README.md               # Documentação principal do projeto
```


## Tecnologias Utilizadas

* Keycloak
* Terraform (provider oficial: `keycloak/keycloak`)
* Docker / Docker Compose
* PHP-CLI
* OIDC
* TOTP (Google Authenticator)
* JWT
* GitLab CI (não implementado)


## Funcionalidades Implementadas


### 🔐 Provedor de Identidade (Keycloak)

* ✅ Criação automatizada de um realm (`autentica_realm`) via Terraform.
* ✅ Dois usuários criados com atributos personalizados (`nivel_acesso`).
* ✅ Auto-registro de usuários habilitado.
* ✅ Fluxo de autenticação com senha (`REQUIRED`) e TOTP (`ALTERNATIVE`).
* ✅ Fluxo condicional baseado na configuração do TOTP pelo usuário.
* ✅ Nível de autenticação (context class) configurado via execução.
* ❎ Registro dinâmico de clients (RFC 7591) *(parcial)*

### 🌐 Provedor de Serviço (Aplicação PHP)

* ✅ Login OIDC implementado.
* ✅ Decodificação do JWT e leitura de atributos do usuário.
* ✅ Rejeição de acesso para `nivel_acesso != alto`.
* ❎  Registro dinâmico de client (parcialmente planejado).
* ❎  Aplicação integrada ao fluxo CI/CD (pendente).

### ⚙️ Infraestrutura

* ✅ Docker Compose com containers:

  * Keycloak
  * PHP (servidor CLI)
  * Terraform

* ✅ Comunicação parcial entre PHP e Keycloak validada (login redireciona corretamente).
* ❎  Callback com erro no recebimento do token.

### 🚀 CI/CD (parcialmente planejado)

* ❎  `.gitlab-ci.yml` não finalizado.
* ❎  Testes automatizados de login e atributos pendentes.


## Como Rodar Localmente

1. **Clone o repositório**

```bash
git clone https://github.com/KrisCeu/Desafio-Projeto-de-Pesquisa.git
cd Desafio-Projeto-de-Pesquisa
```

2. **Suba os containers**

```bash
docker-compose up --build
```

3. **Acesse a aplicação**

* Navegador: `http://localhost:8000/login.php`
* Keycloak: `http://localhost:8080`

4. **Login com usuários de teste**

* Usuário 1: `usuario_alto` (com TOTP)
* Usuário 2: `usuario_baixo` (sem TOTP)


## Considerações Finais

Devido ao prazo do desafio, algumas funcionalidades foram parcialmente implementadas ou deixadas como planejadas. O foco principal foi demonstrar:

* A criação do ambiente via Terraform.
* Autenticação baseada em fatores com controle de acesso.
* Integração inicial entre PS e PI.

---

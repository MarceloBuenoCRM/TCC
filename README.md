# Projeto-TCC

Ambiente de testes
http://projeto.tcc.test/</br>
Usuário: admin@gmail.com
Senha: password

Base de Dados (PHPMyAdmin)
http://projeto.tcc.test:8081/</br>
Usuário: root
Senha: root

---

#### Conteúdo
- [INFO. GERAIS](#infos)
- [INSTALAÇÃO](#install)
- [INICIALIZAR](#inicio)
  
---

### <a id="infos">**Informações Gerais**</a>
Estas são as definições do Software:

- Servidor: Linux Ubuntu 20.04</br>
- Servidor Web: Nginx (1.18)</br>
- Versão PHP: 8.0.5 (cli)</br>
- Laravel: ^8.0</br>
- Base: MYSQL Server (8.0)</br>
- Gerenciador de Base: PHPMyAdmin (5.0)</br>
- Gerenciador de Dependências Back-End: Composer (2.2.7)</br>
- Gerenciador de Dependências Front-End: Node (16)</br>
- Docker: 20.10.10</br>
- Docker-Compose: 1.26.0</br>
- Versionamento em Git</br>

---

### <a id="install">**Instalação**</a></br>

Após clonar o repositório, copiar o arquivo `.env.example` para o `.env`

`cp .env.example .env`

Em seguida, rodar o composer install

`docker-compose run --rm composer install --ignore-platform-reqs`

Agora gere uma chave

`docker-compose run --rm artisan key:generate`

Adicionar no hosts 

`#PROJETO
127.0.0.1 projeto.tcc.test`

Caso tenha problemas com erro 500 ou direitos de arquivos, certifique-se todo o diretório do projeto pertence ao usuario atual:

`sudo chown -R $USER:$USER ./`

Agora gere o Banco para testes

`docker-compose run --rm artisan migrate`

Gere a tabela de Cidades e Estados segundo a API da IBGE:

`docker-compose run --rm artisan suporte:importa-cidade-estado`

Gere o Usuário de testes

`docker-compose run --rm artisan db:seed`

Atualize o Composer para evitar problemas
`docker-compose run --rm composer update`

---

### <a id="inicio">**Inicializar Projeto**</a></br>

Iniciar a Aplicação

```
docker-compose up -d nginx
```

Rodar Comandos em Containers

```
docker-compose run --rm 'NomeDoContainer' 'Comando'
```

---

### <a id="uteis">**Uteis**</a></br>

Criar Model com Controller e Migration:
```
docker-compose run --rm artisan make:model NomeDoModel -c -m
```

Criar Model com Controller Resource e Migration:
```
docker-compose run --rm artisan make:model NomeDoModel -r -m
```
Criar Request:
```
docker-compose run --rm artisan make:request NomeDoRequest
```

---

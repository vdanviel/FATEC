# Modelo Inicial CRUD

Este projeto serve como um modelo inicial para a implementação de um sistema CRUD (Create, Read, Update, Delete) básico, utilizando PHP para fins educacionais. 
É projetado para ensinar os fundamentos da construção de uma aplicação CRUD seguindo boas práticas de programação e padrões de projeto.

## Padrões Utilizados

### Padrão de Design

O projeto segue o padrão MVC (Model-View-Controller), que separa a aplicação em três componentes principais para organizar a lógica de negócios, a interface do usuário e a interação do usuário. Isso promove uma separação clara de preocupações, facilitando a manutenção e expansão do código.

- **Model**: Representa a estrutura de dados, contendo lógica relacionada ao banco de dados.
- **View**: (Não implementado explicitamente neste modelo inicial) Seria responsável pela exibição dos dados ao usuário. na branch separada há um arquivo que irámanipular a rota nos seus respectivos verbos
- **Controller**: Contém a lógica de controle, intermediando a comunicação entre o Model e a View.

### Padrão de Arquitetura

Utilizamos uma arquitetura baseada em serviços, onde o backend pode ser consumido por diferentes clientes (como uma aplicação web front-end ou mobile) através de uma API RESTful.

### Padrão de Comunicação

A comunicação entre o cliente e o servidor é feita através de HTTP, seguindo os princípios REST. Isso permite uma comunicação stateless, utilizando os métodos HTTP (GET, POST, PUT, DELETE) para realizar operações CRUD.

### Padrão de Armazenamento e Repository

A persistência de dados é realizada utilizando o SQLite, o que torna este projeto modelo inicial fácil de configurar e executar sem a necessidade de um ambiente de banco de dados complexo. Entretanto, a abstração da camada de banco de dados através do uso do padrão Repository permite a fácil substituição por outros SGBDs (Sistemas Gerenciadores de Banco de Dados), como MySQL, PostgreSQL, entre outros. Isso é alcançado ajustando apenas a configuração de conexão, demonstrando a flexibilidade do projeto em se adaptar a diferentes ambientes de banco de dados.

## Configuração do Ambiente de Desenvolvimento

Este projeto utiliza [Composer](https://getcomposer.org/) para gerenciar suas dependências. Assim, é necessário ter o Composer instalado no seu sistema para configurar o ambiente de desenvolvimento.

### Instalando Dependências

Após clonar o repositório para a sua máquina local, navegue até o diretório do projeto abre o promp de comando e execute o seguinte comando para instalar as dependências necessárias:

```bash
composer install

```
### Iniciando o Servidor PHP
Para desenvolvedores que têm o PHP instalado independentemente:

Se você tem o PHP instalado em seu sistema, pode iniciar o servidor embutido do PHP com o seguinte comando:
```bash
php -S localhost:8000


```

## Para usuários do XAMPP:

Se preferir usar o XAMPP, coloque o projeto na pasta htdocs do XAMPP e inicie o Apache através do painel de controle do XAMPP. Então, você poderá acessar o projeto via navegador com uma URL baseada no nome da pasta dentro de htdocs.


## Uso

### Documentação da API
Esta API fornece um conjunto de endpoints para operações CRUD (Create, Read, Update, Delete) para usuários. Abaixo estão os detalhes de como interagir com cada endpoint.

Base URL
Supondo que o servidor esteja executando localmente na porta 8000, a URL base será: http://localhost:8000/

#### Autenticação de Usuários (Login)
URL: /login?action=login
Método: POST
Dados Requeridos:
```bash
{
  "email": "user@example.com",
  "senha": "password123"
}

```
Descrição: Autentica um usuário com email e senha.

#### Criar Novo Usuário
URL: /
Método: POST
Dados Requeridos:
```bash
{
  "nome": "Novo Usuario",
  "email": "novo@example.com",
  "senha": "novaSenha123"
}


```
Descrição: Cria um novo usuário com nome, email e senha.

#### Ler Informações de Usuário(s)
Para um único usuário:
URL: /?id=1
Método: GET
Descrição: Obtém as informações de um usuário específico pelo ID.
#### Para todos os usuários:
URL: /
Método: GET
Descrição: Lista todos os usuários.

Atualizar Usuário
URL: /
Método: PUT
Dados Requeridos:
```bash
{
  "usuario_id": 1,
  "nome": "Usuario Atualizado",
  "email": "atualizado@example.com",
  "senha": "senhaAtualizada123"
}
```
Descrição: Atualiza as informações de um usuário existente.

#### Deletar Usuário
URL: /?id=1
Método: DELETE
Descrição: Exclui um usuário específico pelo ID.

### Testando com Postman
Para testar esses endpoints com o Postman:

Abra o Postman e crie uma nova requisição.
2. Selecione o método apropriado (GET, POST, PUT, DELETE) conforme a operação que deseja testar.

Insira a URL base seguida pelo caminho do endpoint. Por exemplo, para criar um novo usuário, a URL seria http://localhost:8000/ com o método POST.
Para os métodos que requerem dados (POST e PUT), vá até a aba "Body", selecione "raw" e escolha "JSON" como formato. Então, insira os dados requeridos no formato JSON.
Pressione o botão "Send" para realizar a requisição.

## Licença

Especifique a licença sob a qual o projeto é disponibilizado, promovendo o uso e contribuição da comunidade.

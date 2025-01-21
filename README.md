# Projeto CEP API

Este é um projeto PHP para consultar dados de CEP.

## Requisitos

Para rodar este projeto, você precisa ter os seguintes itens instalados no seu sistema:

- **PHP**: Versão 7.4 ou superior.
- **Composer**: Ferramenta para gerenciamento de dependências do PHP.

## Como rodar o projeto localmente

### Passo 1: Clonar o repositório

Clone o repositório utilizando o comando abaixo:

```bash
git clone git@github.com:nathanmoreira1/cep.git
```

### Passo 2: Instalar as dependências

Após clonar o repositório, vá até o diretório do projeto e execute o comando para instalar as dependências utilizando o Composer:

```bash
composer install
```

Este comando vai instalar todas as dependências necessárias, como o autoload e as bibliotecas do projeto.

### Passo 3: Rodar o projeto

Para rodar o projeto localmente, vá até o diretório `public` dentro do projeto e execute o comando abaixo para iniciar o servidor PHP embutido:

```bash
php -S localhost:8000
```

Isso vai iniciar um servidor local e o projeto estará acessível em `http://localhost:8000`.

Agora você pode testar a API de CEP no seu navegador ou utilizando ferramentas como o Postman.

---

## Documentação de Endpoints

### 1. Endpoint: `/cep`

- **Método**: `GET`
- **Parâmetros**:
  - `cep`: O CEP desejado. Deve ser fornecido sem formatação (somente números).

- **Exemplo de requisição**:

  `GET http://localhost:8000/cep?cep=01001000`

- **Resposta**:
  A resposta será um JSON com as informações do CEP fornecido, como o logradouro, cidade, estado, etc. Em caso de erro, será retornado um código 404 com a mensagem "CEP não encontrado".

---

Se você encontrar algum problema ou tiver dúvidas, fique à vontade para abrir uma issue no repositório.

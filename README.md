# Desafio - Sócios

  - Execução:
    
    * Executar o comando abaixo na raiz do projeto para instalar as dependências 
      do projeto base Symfony.                                                    
    ```$ composer install```
    * Configurar conexão a base de dados no arquivo **.env** na raiz do projeto.
    * Configurar driver da base em **config/packages/doctrine.yaml**.
    * Executar o comando abaixo para rodar migrations de criação das tabelas e 
      inserção de dados na base de dados configurada.                                             
    ```$ php bin/console doctrine:migrations:migrate  ```
    * Executar o comando abaixo na pasta public para acesso local a API Rest criada.                                             
    ```$ php -S localhost:8080```

--- 

  - Atividades:
    
    * CRUD Empresas
    * CRUD de Sócios (vinculando a empresa)
    * Recursos em API Rest. [DOC API](https://documenter.getpostman.com/view/5142062/SVYuqwm7?version=latest)

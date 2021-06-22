
## Objetivo:

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar  **somente**  ao fluxo de transferência entre dois usuários.

Requisitos:

-   Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.
    
-   Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.
    
-   Lojistas  **só recebem**  transferências, não enviam dinheiro para ninguém.
    
-   Validar se o usuário tem saldo antes da transferência.
    
-   Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular ([https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6](https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6)).
    
-   A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.
    
-   No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio ([http://o4d9z.mocklab.io/notify](http://o4d9z.mocklab.io/notify)).
    
-   Este serviço deve ser RESTFul.

## Instalação

Após o git clone, entre na pasta do projeto e execute os seguintes comandos:

    - composer install


Crie um banco de dados MySQL e configure o acesso a ele no arquivo .env (eu usei o comando abaixo):

    create database desafio

Para criar os tabelas do banco execute:

    php artisan migrate

E em seguida, para executar o projeto:

    php artisan serve

Por fim, [neste link, confira a documentação da API com as propostas de payload](https://documenter.getpostman.com/view/14344627/TzeZDRoi)

*Por default, na criação do usuário está sendo setado um saldo de 1.000,00 para cada um para que seja possível efetuar os testes de transferência.* 

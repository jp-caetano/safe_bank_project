# Safe Bank - Aplicação web segura em Laravel com API RESTful

Aplicação de um banco digital nomeado por `Safe Bank` com autenticação utilizando API RESTful + Laravel Sanctum.

Projeto desenvolvido como requisito para o Trabalho de Conclusão de Curso (TCC), do curso de Engenharia de Computação da Universidade do Oeste de Santa Catarina (Unoesc).

## Setup da aplicação
- Certifique-se de ter instalado em sua máquina o PHP8 e o MySQL;
- Copie o arquivo `.env.example` para `.env` e mude as configurações do banco de dados conforme o seu que deseja usar;
- Abra o seu terminal/cmd, e execute `composer install` para instalar todos os packages relacionados ao PHP, e execute `npm install` para instalar os packages relacionados ao Javascript;
- Execute `php artisan migrate` (isso cria as tabelas requeridas pela aplicação no seu banco de dados);
- Execute `npm run dev` (para compilar e fazer o build do JS), abra outro terminal/cmd e execute `php artisan serve` (inicia o servidor Laravel para a execução da aplicação);
- Finalmente, vá para o seu navegador e entre no endereço do seu servidor laravel que está rodando localmente em: http://localhost:8000.
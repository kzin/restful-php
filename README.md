# restful-php

Usando PHP para criar um webservice baseado: http://www.uiminds.com/2015/10/creating-restful-api-with-php.html

# projeto

Este projeto visa estruturar classes em PHP para criar um webservice rest usando rotas, por exemplo, dar um POST 
em /user cria um usuário novo no banco de dados e dar um GET em /user/{id} retorna um usuário do banco de dados.

# .htaccess

Usamos o rewrite engine para procurar pela rota na nossa URL e assim redirecionar o método certo.

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule (.*)$ api.php?request=$1 [QSA,NC,L]
</IfModule>

# banco de dados

Usaremos uma tabela para guardar nossos usuários:

CREATE TABLE IF NOT EXISTS `user_data` (
`id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
`name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
`password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

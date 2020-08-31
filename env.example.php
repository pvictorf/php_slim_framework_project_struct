<?php
//DEBUG
putenv('DISPLAY_ERROS_DETAILS=' . true);

//TIMEZONE
putenv('DEFAULT_TIMEZONE=' . 'America/Sao_Paulo');

//MYSQL
putenv('MYSQL_HOST='  . 'localhost');
putenv('MYSQL_DBNAME='. 'YOUR_DATABASE');
putenv('MYSQL_USER='  . 'YOUR_USE');
putenv('MYSQL_PASS='  . 'YOUR_PASS');
putenv('MYSQL_PORT='  . '3306');

//JWT
putenv('JWT_SECRET_KEY='  . 'YOUR_PASSWORD_JWT');

//PATH VIEWS
putenv('PATH_VIEWS_TEMPLATE=' . __DIR__ . '/app/Views/');
putenv('PATH_PARTIALS_TEMPLATE=' . __DIR__ . '/app/Views/partials/');
putenv('PATH_VIEWS_CACHE=' . __DIR__ . false); 
putenv('PATH_BASE_URL=' . 'https://localhost/public/');
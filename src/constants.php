<?php
date_default_timezone_set('America/Sao_Paulo');
$currentYear = date('Y');
$currentDate = date('Y-m-d H:i:s');
$logYear = date('Y-m-d H:i:s');

define('YEAR', $currentYear);
define('TODAY', $currentDate);

//LOCAL

define('PREFIX', 'Intelli_Food');
define('PATH', 'http://local.intellifood.com');
define('PATH_VENDOR', 'http://local.intellifood.com/vendor');
define('PATH_ADMIN', 'http://local.intellifood.com/vendor/almasaeed2010/adminlte');



//WEB
/*
define('PREFIX', 'Intelli_Food');
define('PATH', 'https://timerweb.com.br/IntelliFood');
define('PATH_VENDOR', 'https://timerweb.com.br/IntelliFood/vendor');
define('PATH_ADMIN', 'https://timerweb.com.br/IntelliFood/vendor/almasaeed2010/adminlte');
*/
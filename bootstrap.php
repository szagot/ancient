<?php

use Szagot\Helper\Conn\Connection;
use Szagot\Helper\Conn\Query;

define('BASEDIR', __DIR__ . DIRECTORY_SEPARATOR);
define('ROOT', 'ancient/backend/');

require_once BASEDIR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$debug = false;

// Configurações do servidor
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
ini_set('max_execution_time', 3600);
ini_set('display_errors', $debug ? 'On' : 'Off');
error_reporting($debug ? E_ALL : 0);

Query::setConn(
    new Connection(
        'ancient',
        'localhost',
        'root',
        ''
    )
);

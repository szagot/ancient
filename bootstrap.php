<?php

use Szagot\Helper\Conn\Connection;
use Szagot\Helper\Conn\Query;
use Szagot\Helper\Server\Uri;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

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
        'ancient',
        '4nc13nt'
    )
);

Uri::newInstance('ancient/backend');

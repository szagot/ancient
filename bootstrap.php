<?php
const BASEDIR = __DIR__ . DIRECTORY_SEPARATOR;
const DATABASE = BASEDIR . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR;
const ROOT = '/';

require_once BASEDIR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$debug = false;

// Configurações do servidor
header('Content-type: application/json');
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
ini_set('max_execution_time', 3600);
ini_set('display_errors', $debug ? 'On' : 'Off');
error_reporting($debug ? E_ALL : 0);

if(!file_exists(DATABASE)){
    mkdir(DATABASE);
}
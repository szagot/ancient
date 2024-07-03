<?php

namespace Ancient\Service;

use Sz\Config\Uri;

class Control
{
    static public function run(Uri $uri): void
    {
        self::cors();
        if (!self::checkBasicAuth()) {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Area Restrita"');
            exit('Acesso não autorizado.');
        }
        
        switch (strtolower($uri->pagina)) {
            case 'questions':
                Questions::run($uri);
                break;
            case 'characters':
                Characters::run($uri);
                break;
        }

        die(json_encode([]));
    }

    public static function cors(): void
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
    }

    // Função para verificar as credenciais de autenticação básica
    private static function checkBasicAuth(): bool
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        $expectedUser = getenv('ANCIENT_USER');
        $expectedPass = getenv('ANCIENT_PASS');

        // Verifica se as credenciais correspondem
        if ($_SERVER['PHP_AUTH_USER'] !== $expectedUser || $_SERVER['PHP_AUTH_PW'] !== $expectedPass) {
            return false;
        }

        return true;
    }
}
<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Sz\Config\Uri;

class Control
{
    static public function run(Uri $uri): void
    {
        self::cors();
        
        $db = new Database();

        switch (strtolower($uri->pagina)) {
            case 'questions':
                Questions::run($uri, $db);
                break;
            case 'people':
                People::run($uri, $db);
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
}
<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Config;
use JetBrains\PhpStorm\NoReturn;
use Sz\Config\Uri;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;

class Control
{
    #[NoReturn]
    static public function run(Uri $uri): void
    {
        self::cors();
        if (!self::checkBasicAuth($uri)) {
            Output::error('Não autorizado', Output::ERROR_UNAUTHORIZED);
        }

        switch (strtolower($uri->pagina)) {
            // Perguntas
            case 'questions':
                Questions::run($uri);
                break;

            // Personagens
            case 'characters':
                Characters::run($uri);
                break;

            // Sala e Jogadores
            case 'room':
                Room::run($uri);
                break;

            // Jogo
            case 'game':
                Game::run($uri);
                break;
        }

        Output::success();
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
    private static function checkBasicAuth(Uri $uri): bool
    {
        $auth = $uri->getHeader('AncientAuth');
        if (empty($auth)) {
            return false;
        }

        try {
            /** @var Config $apiPass */
            $apiPass = Crud::get(Config::class, 'field', 'api');
        } catch (ConnException) {
            return false;
        }

        return $apiPass?->value == $auth;
    }
}
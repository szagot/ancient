<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Config;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Server\Uri;

class Control
{
    static public function run(): void
    {
        self::cors();

        if (!self::checkBasicAuth()) {
            Output::error('Não autorizado', Output::ERROR_UNAUTHORIZED);
        }

        switch (strtolower(Uri::newInstance()->getUri(0))) {
            // Perguntas
            case 'questions':
                Questions::run();
                break;

            // Personagens
            case 'characters':
                Characters::run();
                break;

            // Sala e Jogadores
            case 'room':
                Room::run();
                break;

            // Jogo
            case 'game':
                Game::run();
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
    private static function checkBasicAuth(): bool
    {
        $auth = Uri::newInstance()->getHeader('Ancient-Auth');
        if (empty($auth)) {
            return false;
        }

        try {
            /** @var Config $apiPass */
            $apiPass = Crud::get(Config::class, 'api');
        } catch (ConnException) {
            return false;
        }

        return $apiPass?->getValue() == $auth;
    }
}
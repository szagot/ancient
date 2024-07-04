<?php

namespace Ancient\Config;

use JetBrains\PhpStorm\NoReturn;

class Output
{
    const GET_SUCCESS             = 200;
    const POST_SUCCESS            = 201;
    const PUT_SUCCESS             = 204;
    const DELETE_SUCCESS          = 204;
    const ERROR_UNAUTHORIZED      = 401;
    const ERROR_MALFORMED_REQUEST = 400;
    const ERROR_NOT_FOUND         = 404;

    #[NoReturn]
    static public function success(mixed $output = [], int $httpCode = self::GET_SUCCESS): void
    {
        if (!is_string($output)) {
            $output = empty($output) ? '[]' : @json_encode($output);
        }

        header('Content-type: application/json');
        http_response_code($httpCode);
        die($output);
    }

    #[NoReturn]
    static public function error($message, int $httpCode = self::ERROR_MALFORMED_REQUEST): void
    {
        self::success(
            [
                'status' => $httpCode,
                'msg'    => $message,
            ],
            $httpCode
        );
    }
}
<?php

namespace Ancient\Config;

class Output
{
    static public function success(mixed $output, int $httpCode = 200): void
    {
        if (!is_string($output)) {
            $output = @json_encode($output);
        }

        http_response_code($httpCode);
        die($output);
    }

    static public function error($message, int $httpCode = 400): void
    {
        self::success(
            [
                'status'  => $httpCode,
                'message' => $message,
            ],
            $httpCode
        );
    }


}
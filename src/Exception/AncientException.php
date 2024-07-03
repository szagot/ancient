<?php

namespace Ancient\Exception;

use Exception;
use Sz\Conn\Query;

class AncientException extends Exception
{
    public function __construct(string $message = "", $isDB = true)
    {
        $logPath = BASEDIR . 'logs' . DIRECTORY_SEPARATOR;
        if (!file_exists($logPath)) {
            mkdir($logPath);
        }

        file_put_contents(
            $logPath . date('Ymd') . '-error.log',
            (
                date('H:i:s') . PHP_EOL .
                ($isDB ? print_r(Query::getLog(), true) : $message) . PHP_EOL .
                $this->getTraceAsString() . PHP_EOL .
                '----------' . PHP_EOL
            ),
            FILE_APPEND | LOCK_EX
        );

        parent::__construct($message);
    }

    public function __toString()
    {
        return $this->getMessage();
    }

}
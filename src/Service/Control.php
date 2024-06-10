<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Models\Person;
use Ancient\Models\Question;
use JetBrains\PhpStorm\NoReturn;
use Sz\Config\Uri;

class Control
{
    static public function run(Uri $uri): void
    {
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
}
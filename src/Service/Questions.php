<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Sz\Config\Uri;

class Questions
{
    public static function run(Uri $uri, Database $db): void
    {
        $id = (int)$uri->opcao;

        switch ($uri->getMethod()) {
            case 'GET':
                if (empty($id)) {
                    // GET
                    die(json_encode($db->getQuestions()));
                }

                // GET id
                die(json_encode($db->getQuestion($id)));
                break;

            case 'POST':
                break;

            case 'DELETE':
                break;

            case 'PUT':
            case 'PATCH':
                break;
        }
    }
}
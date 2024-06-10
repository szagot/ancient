<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Sz\Config\Uri;

class People
{
    public static function run(Uri $uri, Database $db): void
    {
        $id = (int)$uri->opcao;

        switch ($uri->getMethod()) {
            case 'GET':
                if (empty($id)) {
                    // GET
                    die(json_encode($db->getPeople()));
                }

                // GET id
                die(json_encode($db->getPerson($id)));
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
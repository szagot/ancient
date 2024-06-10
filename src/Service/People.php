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
                if (empty($id)) {
                    die(json_encode(['msg' => 'Informe o ID para deleção']));
                }
                break;

            case 'PUT':
            case 'PATCH':
                if (empty($id)) {
                    die(json_encode(['msg' => 'Informe o ID para atualização']));
                }
                break;
        }
    }
}
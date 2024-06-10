<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Models\Person;
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
                $name = $uri->getParam('name');
                if (empty($name)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o nome do personagem']));
                }

                $lastPerson = $db->getLastPerson();
                $id = 1 + ($lastPerson?->id ?? 0);
                $db->addPerson(new Person($id, $name));
                $db->persist();
                http_response_code(201);
                break;

            case 'DELETE':
                if (empty($id)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o ID para deleção']));
                }
                break;

            case 'PUT':
            case 'PATCH':
                if (empty($id)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o ID para atualização']));
                }
                break;
        }
    }
}
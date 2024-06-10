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
                    // GET All
                    die(json_encode($db->getPeople()));
                }

                // GET /{id}/questions
                if($uri->detalhe == 'questions'){
                    die(json_encode($db->getPersonQuestions($id)));
                }

                // GET {id}
                die(json_encode($db->getPerson($id)));

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

                $db->removePerson($id);
                $db->persist();
                http_response_code(204);
                break;

            case 'PUT':
            case 'PATCH':
                if (empty($id)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o ID para atualização']));
                }

                $name = $uri->getParam('name');
                if (empty($name)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o nome do personagem']));
                }
                
                $person = $db->getPerson($id);
                $person->name = $name;
                $db->updatePerson($person);
                $db->persist();
                http_response_code(204);
                break;
        }
    }
}
<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Config\Output;
use Ancient\Control\Crud;
use Ancient\Models\Character;
use Sz\Config\Uri;

class Characters
{
    public static function run(Uri $uri): void
    {
        $id = (int)$uri->opcao;

        switch ($uri->getMethod()) {
            case 'GET':
                if (empty($id)) {
                    // GET All
                    Output::success(Crud::getAll(Character::class));
                }

                /** @var Character $character */
                $character = Crud::get(Character::class, 'id', $id);

                // GET /{id}/questions
                if ($uri->detalhe == 'questions') {
                    Output::success($character->getQuestions());
                }

                // GET {id}
                Output::success($character);
                
                break;

            case 'POST':
                $name = $uri->getParam('name');
                if (empty($name)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o nome do personagem']));
                }

//                $lastPerson = $db->getLastPerson();
//                $id = 1 + ($lastPerson?->id ?? 0);
//                $db->addPerson(new Character($id, $name));
//                $db->persist();
                http_response_code(201);
                break;

            case 'DELETE':
                if (empty($id)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o ID para deleção']));
                }

//                $db->removePerson($id);
//                $db->persist();
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

//                $person = $db->getPerson($id);
//                $person->name = $name;
//                $db->updatePerson($person);
//                $db->persist();
                http_response_code(204);
                break;
        }
    }
}
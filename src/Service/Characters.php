<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Character;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Server\Uri;

class Characters
{
    public static function run(): void
    {
        $uri = Uri::newInstance();
        $id = (int)$uri->getUri(1);

        try {
            switch ($uri->getMethod()) {
                case 'GET':
                    if (empty($id)) {
                        // GET All
                        $characters = Crud::getAll(Character::class, 0, 0, 'name');
                        /** @var Character $character */
                        foreach ($characters as $index => $character) {
                            $characters[$index] = $character->toArray();
                        }
                        Output::success($characters);
                    }

                    /** @var Character $character */
                    $character = Crud::get(Character::class, $id);
                    if (!$character) {
                        Output::error('Personagem não encontrado.', 404);
                    }

                    // GET {id}
                    $character->getQuestions();
                    Output::success($character->toArray(true));

                case 'POST':
                    $name = $uri->getParameter('name');
                    if (empty($name)) {
                        Output::error('Informe o nome do personagem');
                    }

                    // Nome já cadastrado?
                    $character = Crud::search(Character::class, 'name', $name);
                    if (count($character) > 0) {
                        Output::success($character[0]);
                    }

                    $character = new Character();
                    $id = Crud::insert(Character::class, $character->setName($name));

                    Output::success(['id' => $id], Output::POST_SUCCESS);

                case 'PUT':
                case 'PATCH':
                    if (empty($id)) {
                        Output::error('Informe o ID para atualização.');
                    }

                    $name = $uri->getParameter('name');
                    if (empty($name)) {
                        Output::error('Informe o nome do personagem.');
                    }

                    /** @var Character $character */
                    $character = Crud::get(Character::class, $id);
                    if (!$character) {
                        Output::error('Personagem não encontrado.');
                    }

                    // Verifica se tem outro personagem com esse nome alterado
                    $validate = Crud::search(Character::class, 'name', $name);
                    if($validate){
                        Output::error('Já existe um personagem com esse nome.');
                    }

                    Crud::update(Character::class, $character->setName($name));

                    Output::success([], Output::PUT_SUCCESS);

                case 'DELETE':
                    if (empty($id)) {
                        Output::error('Informe o ID para deletar.');
                    }

                    Crud::delete(Character::class, $id);

                    Output::success([], Output::DELETE_SUCCESS);
            }
        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }
}
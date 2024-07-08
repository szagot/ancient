<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Control\CharacterQuestion;
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

                    /** @var Character $character */
                    $character = Crud::get(Character::class, $id);
                    if (!$character) {
                        Output::error('Personagem não encontrado.');
                    }

                    if ($uri->parameterExists('name')) {
                        $name = $uri->getParameter('name');
                        if (empty($name)) {
                            Output::error('Informe o nome do personagem.');
                        }

                        $validate = Crud::search(Character::class, 'name', $name);
                        if (!empty($validate) && $validate[0]?->getId() != $id) {
                            Output::error('Já existe um personagem com esse nome.');
                        }

                        Crud::update(Character::class, $character->setName($name));
                    }

                    // Recebeu dados de atualização de perguntas?
                    if ($uri->parameterExists('questionIds')) {
                        if (
                            !CharacterQuestion::saveCharacterQuestions(
                                $character,
                                $uri->getParameter('questionIds')->getValue()
                            )
                        ) {
                            Output::error('Informe apenas Perguntas válidas para esse personagem');
                        }
                    }

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
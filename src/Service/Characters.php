<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Character;
use Sz\Config\Uri;
use Szagot\Conn\ConnException;
use Szagot\Conn\Crud;

class Characters
{
    public static function run(Uri $uri): void
    {
        $id = (int)$uri->opcao;

        try {
            switch ($uri->getMethod()) {
                case 'GET':
                    if (empty($id)) {
                        // GET All
                        Output::success(Crud::getAll(Character::class,0,0,'name'));
                    }

                    /** @var Character $character */
                    $character = Crud::get(Character::class, 'id', $id);
                    if (!$character) {
                        Output::error('Personagem não encontrado.', 404);
                    }

                    // GET /{id}/questions
                    if ($uri->detalhe == 'questions') {
                        Output::success($character->getQuestions());
                    }

                    // GET {id}
                    Output::success($character);

                case 'POST':
                    $name = $uri->getParam('name');
                    if (empty($name)) {
                        Output::error('Informe o nome do personagem');
                    }

                    // Nome já cadastrado?
                    $character = Crud::search(Character::class, 'name', $name);
                    if (count($character) > 0) {
                        Output::success($character[0]);
                    }

                    $id = Crud::insert(Character::class, 'id', $uri->getParametros());

                    Output::success(['id' => $id], Output::POST_SUCCESS);

                case 'PUT':
                case 'PATCH':
                    if (empty($id)) {
                        Output::error('Informe o ID para atualização.');
                    }

                    $name = $uri->getParam('name');
                    if (empty($name)) {
                        Output::error('Informe o nome do personagem.');
                    }

                    $character = Crud::get(Character::class, 'id', $id);
                    if (!$character) {
                        Output::error('Personagem não encontrado.');
                    }

                    $character->name = $name;
                    Crud::update(Character::class, 'id', $character);

                    Output::success([], Output::PUT_SUCCESS);

                case 'DELETE':
                    if (empty($id)) {
                        Output::error('Informe o ID para deletar.');
                    }

                    Crud::delete(Character::class, 'id', $id);

                    Output::success([], Output::DELETE_SUCCESS);
            }
        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }
}
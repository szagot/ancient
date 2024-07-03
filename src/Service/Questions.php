<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Control\Crud;
use Ancient\Exception\AncientException;
use Ancient\Models\Question;
use Sz\Config\Uri;

class Questions
{
    public static function run(Uri $uri): void
    {
        $id = (int)$uri->opcao;

        try {
            switch ($uri->getMethod()) {
                case 'GET':
                    if (empty($id)) {
                        // GET All
                        Output::success(Crud::getAll(Question::class));
                    }

                    /** @var Question $question */
                    $question = Crud::get(Question::class, 'id', $id);

                    // GET /{id}/characters
                    if ($uri->detalhe == 'characters') {
                        Output::success($question->getCharacters());
                    }

                    // GET {id}
                    Output::success($question);

                    break;

                case 'POST':
                    if (empty($uri->getParam('question'))) {
                        Output::error('A pergunta não pode estar vazia');
                    }

                    $id = Crud::insert(Question::class, 'id', $uri->getParametros());

                    Output::success(['id' => $id], 201);

                    break;

                case 'PUT':
                case 'PATCH':
                    if (empty($id)) {
                        Output::error('Informe o ID para atualização.');
                    }

                    $questionTxt = $uri->getParam('question');
                    if (empty($questionTxt)) {
                        Output::error('A pergunta não pode estar vazia');
                    }

                    $question = Crud::get(Question::class, 'id', $id);
                    if (!$question) {
                        Output::error('Pergunta não encontrado.');
                    }

                    $question->question = $questionTxt;
                    Crud::update(Question::class, 'id', $question);

                    Output::success([], 204);

                    break;

                case 'DELETE':
                    if (empty($id)) {
                        Output::error('Informe o ID para deletar.');
                    }

                    Crud::delete(Question::class, 'id', $id);

                    Output::success([], 204);
                    break;
            }
        } catch (AncientException $e) {
            Output::error($e->getMessage());
        }
    }
}
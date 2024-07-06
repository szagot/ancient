<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Question;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Server\Uri;

class Questions
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
                        Output::success(Crud::getAll(Question::class));
                    }

                    /** @var Question $question */
                    $question = Crud::get(Question::class, $id);
                    if (!$question) {
                        Output::error('Pergunta não encontrada.', 404);
                    }

                    // GET /{id}/characters
                    if ($uri->getUri(2) == 'characters') {
                        Output::success($question->getCharacters());
                    }

                    // GET {id}
                    Output::success($question);

                case 'POST':
                    $questionTxt = $uri->getParameter('question');
                    if (empty($questionTxt)) {
                        Output::error('A pergunta não pode estar vazia');
                    }

                    $question = new Question();
                    $question->question = $questionTxt;
                    $id = Crud::insert(Question::class, $question);

                    Output::success(['id' => $id], Output::POST_SUCCESS);

                case 'PUT':
                case 'PATCH':
                    if (empty($id)) {
                        Output::error('Informe o ID para atualização.');
                    }

                    $questionTxt = $uri->getParameter('question');
                    if (empty($questionTxt)) {
                        Output::error('A pergunta não pode estar vazia');
                    }

                    $question = Crud::get(Question::class, $id);
                    if (!$question) {
                        Output::error('Pergunta não encontrado.');
                    }

                    $question->question = $questionTxt;
                    Crud::update(Question::class, $question);

                    Output::success([], Output::PUT_SUCCESS);

                case 'DELETE':
                    if (empty($id)) {
                        Output::error('Informe o ID para deletar.');
                    }

                    Crud::delete(Question::class, $id);

                    Output::success([], Output::DELETE_SUCCESS);
            }

        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }
}
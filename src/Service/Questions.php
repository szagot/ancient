<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Config\Output;
use Ancient\Control\Crud;
use Ancient\Models\Character;
use Ancient\Models\Question;
use Sz\Config\Uri;

class Questions
{
    public static function run(Uri $uri): void
    {
        $id = (int)$uri->opcao;

        switch ($uri->getMethod()) {
            case 'GET':
                if (empty($id)) {
                    // GET All
                    Output::success(Crud::getAll(Question::class));
                }

                /** @var Question $question */
                $question = Crud::get(Question::class, 'id', $id);

                // GET /{id}/questions
                if ($uri->detalhe == 'characters') {
                    Output::success($question->getCharacters());
                }

                // GET {id}
                Output::success($question);

                break;
        }
    }
}
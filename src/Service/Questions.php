<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Models\Question;
use Sz\Config\Uri;

class Questions
{
    public static function run(Uri $uri, Database $db): void
    {
        $id = (int)$uri->opcao;

        switch ($uri->getMethod()) {
            case 'GET':
                if (empty($id)) {
                    // GET
                    die(json_encode($db->getQuestions()));
                }

                // GET id
                die(json_encode($db->getQuestion($id)));

            case 'POST':
                $question = $uri->getParam('question');
                if (empty($question)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe a pergunta']));
                }

                $lastQuestion = $db->getLastQuestion();
                $id = 1 + ($lastQuestion?->id ?? 0);
                $db->addQuestion(new Question($id, $question));
                $db->persist();
                http_response_code(201);
                break;

            case 'DELETE':
                if (empty($id)) {
                    http_response_code(400);
                    die(json_encode(['msg' => 'Informe o ID para deleção']));
                }

                $db->removeQuestion($id);
                $db->persist();
                http_response_code(204);
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
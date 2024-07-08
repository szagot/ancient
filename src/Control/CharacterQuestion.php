<?php

namespace Ancient\Control;

use Ancient\Models\Character;
use Ancient\Models\Question;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Query;

class CharacterQuestion
{
    /**
     * Salva os personagens da pergunta
     *
     * @throws ConnException
     */
    public static function saveQuestionCharacters(Question $question, array $characterIds = []): bool
    {
        if (!$question->getId()) {
            throw new ConnException('Informe uma pergunta cadastrada.');
        }

        // Primeiro limpa os registros já existentes
        if (!Query::exec(
            'DELETE FROM character_question WHERE question_id = :id',
            [
                'id' => $question->getId(),
            ]
        )) {
            throw new ConnException('Não foi possível atualizar os registros no momento. Problemas ao limpar registros.');
        }

        $characters = [];
        if (!empty($characterIds)) {
            foreach ($characterIds as $id) {
                $tmp = Crud::get(Character::class, $id);
                if (!$tmp) {
                    throw new ConnException('Informe apenas IDs cadastrados.');
                }
                $characters[] = $tmp;
            }

            /** @var Character $character */
            foreach ($characters as $character) {
                // Depois os recria
                if (!self::save($question, $character)) {
                    throw new ConnException("Não foi possível atualizar o registro de ID {$character->getId()} no momento. Problemas ao inserir registro.");
                }
            }
        }

        $question->getCharacters(true);
        return true;
    }

    /**
     * Salva as perguntas do personagem
     *
     * @throws ConnException
     */
    public static function saveCharacterQuestions(Character $character, array $questionIds = []): bool
    {
        if (!$character->getId()) {
            throw new ConnException('Informe um personagem cadastrado.');
        }

        // Primeiro limpa os registros já existentes
        if (!Query::exec(
            'DELETE FROM character_question WHERE character_id = :id',
            [
                'id' => $character->getId(),
            ]
        )) {
            throw new ConnException('Não foi possível atualizar os registros no momento. Problemas ao limpar registros.');
        }

        $questions = [];
        if (!empty($questionIds)) {
            foreach ($questionIds as $id) {
                $tmp = Crud::get(Question::class, $id);
                if (!$tmp) {
                    throw new ConnException('Informe apenas IDs cadastrados.');
                }
                $questions[] = $tmp;
            }

            /** @var Character $character */
            foreach ($questions as $question) {
                // Depois os recria
                if (!self::save($question, $character)) {
                    throw new ConnException("Não foi possível atualizar o registro de ID {$character->getId()} no momento. Problemas ao inserir registro.");
                }
            }
        }

        $character->getQuestions(true);
        return true;
    }

    private static function save(Question $question, Character $character): bool
    {
        return Query::exec(
            'INSERT INTO character_question (character_id, question_id) VALUES (:character_id, :question_id)',
            [
                'question_id'  => $question->getId(),
                'character_id' => $character->getId(),
            ]
        );
    }
}
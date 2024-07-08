<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\Query;

#[Table(name: 'questions')]
class Question extends aModel
{
    #[PrimaryKey]
    protected int     $id;
    protected ?string $question;

    #[IgnoreField]
    protected ?array $characters = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Question
    {
        $this->id = $id;
        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): Question
    {
        $this->question = $question;
        return $this;
    }

    public function getCharacters(): array
    {
        if (empty($this->characters)) {
            $this->characters = Query::exec(
                'SELECT c.* FROM characters c INNER JOIN character_question cq on c.id = cq.character_id WHERE cq.question_id = :id',
                [
                    'id' => $this->id,
                ],
                Character::class
            ) ?? [];
        }

        return $this->characters;
    }

    /**
     * Seta os caracteres
     *
     * @throws ConnException
     */
    public function setCharacters(?array $characterIds = []): bool
    {
        // Primeiro limpa os registros já existentes
        $this->characters = [];
        if (!Query::exec(
            'DELETE FROM character_question WHERE question_id = :id',
            [
                'id' => $this->id,
            ]
        )) {
            throw new ConnException('Não foi possível atualizar os registros de no momento. Problemas ao limpar registros.');
        }

        if (!empty($characterIds)) {
            foreach ($characterIds as $id) {
                $tmp = Crud::get(Character::class, $id);
                if (!$tmp) {
                    return false;
                }
                $this->characters[] = $tmp;
            }

            /** @var Character $character */
            foreach ($this->characters as $character) {
                // Depois os recria
                if (!Query::exec(
                    'INSERT INTO character_question (character_id, question_id) VALUES (:character_id, :question_id)',
                    [
                        'question_id'  => $this->id,
                        'character_id' => $character->getId(),
                    ]
                )) {
                    throw new ConnException("Não foi possível atualizar o registro de ID {$character->getId()} no momento. Problemas ao inserir registro.");
                }
            }
        }
        return true;
    }
}
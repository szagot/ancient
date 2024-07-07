<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
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
}
<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\Query;

#[Table(name: 'characters')]
class Character extends aModel
{
    #[PrimaryKey]
    protected int     $id;
    protected ?string $name;
    #[IgnoreField]
    protected array   $questions = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Character
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Character
    {
        $this->name = $name;
        return $this;
    }

    public function getQuestions(bool $forceUpdate = false): array
    {
        if (empty($this->questions) || $forceUpdate) {
            $this->questions = Query::exec(
                'SELECT q.* FROM questions q INNER JOIN character_question cq on q.id = cq.question_id WHERE cq.character_id = :id',
                [
                    'id' => $this->id,
                ],
                Question::class
            ) ?? [];
        }

        return $this->questions;
    }

}
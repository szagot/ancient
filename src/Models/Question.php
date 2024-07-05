<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\Query;

#[Table(name: 'questions')]
class Question extends aModel
{
    #[PrimaryKey]
    public int     $id;
    public ?string $question;

    public function getCharacters(): array
    {
        return Query::exec(
            'SELECT c.* FROM characters c INNER JOIN character_question cq on c.id = cq.character_id WHERE cq.question_id = :id',
            [
                'id' => $this->id,
            ],
            Character::class
        ) ?? [];
    }
}
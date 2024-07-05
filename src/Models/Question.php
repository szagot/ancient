<?php

namespace Ancient\Models;

use Szagot\Conn\aModel;
use Szagot\Conn\Query;

class Question extends aModel
{
    const TABLE = 'questions';

    public int $id;
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
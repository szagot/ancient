<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\Query;

#[Table(name: 'characters')]
class Character extends aModel
{
    #[PrimaryKey]
    public int     $id;
    public ?string $name;

    public function getQuestions(): array
    {
        return Query::exec(
            'SELECT q.* FROM questions q INNER JOIN character_question cq on q.id = cq.question_id WHERE cq.character_id = :id',
            [
                'id' => $this->id,
            ],
            Question::class
        ) ?? [];
    }
}
<?php

namespace Ancient\Models;

use Szagot\Conn\aModel;
use Szagot\Conn\Query;

class Character extends aModel
    {
        const TABLE = 'characters';

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
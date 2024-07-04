<?php

namespace Ancient\Models;

use Sz\Conn\Query;

class Character
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
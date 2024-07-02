<?php

namespace Ancient\Models;

class Character
{
    public int $id;
    public ?string $name;

    public function getQuestions(): array
    {
        // TODO
        return [];
    }
}
<?php

namespace Ancient\Models;

class PersonQuestion
{
    public string $id;
    public string $question;

    /**
     * @param string $id
     * @param string $question
     */
    public function __construct(string $id, string $question)
    {
        $this->id = $id;
        $this->question = $question;
    }
}
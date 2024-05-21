<?php

namespace Ancient\Models;

class Person
{
    public string $id;
    public string $name;
    public array $questions;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->questions = [];
    }

    public function getQuestion(string $id): ?PersonQuestion
    {
        if (empty($this->questions)) {
            return null;
        }

        /** @var PersonQuestion $question */
        foreach ($this->questions as $question) {
            if ($question->id == $id) {
                return $question;
            }
        }

        return null;
    }

    public function addQuestion(PersonQuestion $question): void
    {
        if ($this->getQuestion($question->id)) {
            return;
        }

        $this->questions[] = $question;
    }

    public function removeQuestion(string $id): void
    {
        if (empty($this->questions)) {
            return;
        }

        /** @var PersonQuestion $question */
        foreach ($this->questions as $index => $question) {
            if ($question->id == $id) {
                unset($this->questions[$index]);
                $this->questions = array_values($this->questions);
                return;
            }
        }
    }

    public function updateQuestion(PersonQuestion $newQuestion): void
    {
        if (empty($this->questions)) {
            return;
        }

        foreach ($this->questions as $index => $question) {
            if ($question->id == $newQuestion->id) {
                $this->questions[$index] = $newQuestion;
                return;
            }
        }
    }
}
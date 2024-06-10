<?php

namespace Ancient\Models;

class Question
{
    public string $id;
    public string $question;
    public array $people = [];

    /**
     * @param string $id
     * @param string $question
     */
    public function __construct(string $id, string $question)
    {
        $this->id = $id;
        $this->question = $question;
    }

    public function getPerson(string $id): ?Person
    {
        if (empty($this->people)) {
            return null;
        }

        /** @var Person $person */
        foreach ($this->people as $person) {
            if ($person->id == $id) {
                return $person;
            }
        }

        return null;
    }

    public function addPerson(Person $person): void
    {
        if ($this->getPerson($person->id)) {
            return;
        }

        $this->people[] = $person;
    }

    public function removePerson(string $id): void
    {
        if (empty($this->people)) {
            return;
        }

        /** @var Person $person */
        foreach ($this->people as $index => $person) {
            if ($person->id == $id) {
                unset($this->people[$index]);
                $this->people = array_values($this->people);
                return;
            }
        }
    }

    public function updatePerson(Person $newPerson): void
    {
        if (empty($this->people)) {
            return;
        }

        /** @var Person $person */
        foreach ($this->people as $index => $person) {
            if ($person->id == $newPerson->id) {
                $this->people[$index] = $newPerson;
                return;
            }
        }
    }
}
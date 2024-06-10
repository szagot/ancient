<?php

namespace Ancient\Models;

class Question
{
    public string $id;
    public string $question;
    public array $persons = [];

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
        if (empty($this->persons)) {
            return null;
        }

        /** @var Person $person */
        foreach ($this->persons as $person) {
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

        $this->persons[] = $person;
    }

    public function removePerson(string $id): void
    {
        if (empty($this->persons)) {
            return;
        }

        /** @var Person $person */
        foreach ($this->persons as $index => $person) {
            if ($person->id == $id) {
                unset($this->persons[$index]);
                $this->persons = array_values($this->persons);
                return;
            }
        }
    }

    public function updatePerson(Person $newPerson): void
    {
        if (empty($this->persons)) {
            return;
        }

        /** @var Person $person */
        foreach ($this->persons as $index => $person) {
            if ($person->id == $newPerson->id) {
                $this->persons[$index] = $newPerson;
                return;
            }
        }
    }
}
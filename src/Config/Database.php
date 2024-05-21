<?php

namespace Ancient\Config;

use Ancient\Models\Gamer;
use Ancient\Models\Person;
use Ancient\Models\PersonQuestion;

class Database
{
    const FILE_PEOPLES = DATABASE . 'peoples.json';
    const FILE_GAMERS = DATABASE . 'gamers.json';

    private array $gamers;
    private array $people;

    public function __construct()
    {
        $this->refresh();
    }

    /**
     * Atualiza as propriedades internas com os valores dos arquivos
     * @return void
     */
    public function refresh(): void
    {
        $this->gamers = [];
        $this->people = [];
        if (file_exists(self::FILE_PEOPLES)) {
            $people = @json_decode(file_get_contents(self::FILE_PEOPLES));
            foreach ($people as $person) {
                $people = new Person($person->id, $person->name);
                if (!empty($person->questions)) {
                    foreach ($person->questions as $question) {
                        $people->addQuestion(new PersonQuestion($question->id, $question->question));
                    }
                }
                $this->people[] = $people;
            }
        }

        if (file_exists(self::FILE_GAMERS)) {
            $gamers = @json_decode(file_get_contents(self::FILE_GAMERS));
            foreach ($gamers as $gamer) {
                $this->gamers[] = new Gamer($gamer->id, $gamer->name);
            }
        }
    }

    /**
     * Salva nos arquivos as propriedades internas
     * @return void
     */
    public function persist(): void
    {
        file_put_contents(self::FILE_GAMERS, json_encode($this->gamers));
        file_put_contents(self::FILE_PEOPLES, json_encode($this->people));
    }

    public function getGamer(string $id): ?Gamer
    {
        if (empty($this->gamers)) {
            return null;
        }

        /** @var Gamer $gamer */
        foreach ($this->gamers as $gamer) {
            if ($gamer->id == $id) {
                return $gamer;
            }
        }

        return null;
    }

    public function addGamer(Gamer $gamer): void
    {
        if ($this->getGamer($gamer->id)) {
            return;
        }

        $this->gamers[] = $gamer;
    }

    public function removeGamer(string $id): void
    {
        if (empty($this->gamers)) {
            return;
        }

        /** @var Gamer $gamer */
        foreach ($this->gamers as $index => $gamer) {
            if ($gamer->id == $id) {
                unset($this->gamers[$index]);
                $this->gamers = array_values($this->gamers);
                return;
            }
        }
    }

    public function updateGamer(Gamer $newGamer): void
    {
        if (empty($this->gamers)) {
            return;
        }

        foreach ($this->gamers as $index => $gamer) {
            if ($gamer->id == $newGamer->id) {
                $this->gamers[$index] = $newGamer;
                return;
            }
        }
    }

    public function getPerson(string $id): ?Person
    {
        if (empty($this->people)) {
            return null;
        }

        /** @var Person $gamer */
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

    public function removePerson(string $id)
    {
        if (empty($this->people)) {
            return;
        }

        /** @var Gamer $gamer */
        foreach ($this->people as $index => $person) {
            if ($person->id == $id) {
                unset($this->people[$index]);
                $this->people = array_values($this->people);
                return null;
            }
        }
    }

    public function updatePerson(Person $newPerson): void
    {
        if (empty($this->people)) {
            return;
        }

        foreach ($this->people as $index => $person) {
            if ($person->id == $newPerson->id) {
                $this->people[$index] = $newPerson;
                return;
            }
        }
    }
}
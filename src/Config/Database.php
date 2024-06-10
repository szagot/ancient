<?php

namespace Ancient\Config;

use Ancient\Models\Person;
use Ancient\Models\Question;

class Database
{
    const FILE_PEOPLES   = DATABASE . 'peoples.json';
    const FILE_QUESTIONS = DATABASE . 'questions.json';

    private array $questions;
    private array $people;

    public function __construct()
    {
        $this->refresh();
    }

    /**
     * Atualiza as propriedades internas com os valores dos arquivos
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->people = [];
        $this->questions = [];
        if (file_exists(self::FILE_PEOPLES)) {
            $people = @json_decode(file_get_contents(self::FILE_PEOPLES));
            foreach ($people as $person) {
                $this->people[] = new Person($person->id, $person->name);
            }
        }

        if (file_exists(self::FILE_QUESTIONS)) {
            $questions = @json_decode(file_get_contents(self::FILE_QUESTIONS));
            foreach ($questions as $question) {
                $personQuestion = new Question($question->id, $question->question);
                /** @var Person $person */
                foreach ($question->persons as $person) {
                    $personQuestion->addPerson(new Person($person->id, $person->name));
                }

                $this->questions[] = $personQuestion;
            }
        }
    }

    /**
     * Salva nos arquivos as propriedades internas
     *
     * @return void
     */
    public function persist(): void
    {
        file_put_contents(self::FILE_PEOPLES, json_encode($this->people));
        file_put_contents(self::FILE_QUESTIONS, json_encode($this->questions));
    }

    /**
     * Pega o último registro de um dos dados
     *
     * @param array $array
     *
     * @return Person|Question|null
     */
    private function getLast(array $array = []): Person|Question|null
    {
        if (empty($array)) {
            return null;
        }

        $max = 0;
        $return = null;
        foreach ($array as $find) {
            if ($find->id > $max) {
                $return = $find;
            }
        }

        return $return;
    }

    public function getPeople(): array
    {
        return $this->people ?? [];
    }

    public function getLastPerson(): ?Person
    {
        return $this->getLast($this->getPeople());
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

        /** @var Person $person */
        foreach ($this->people as $index => $person) {
            if ($person->id == $id) {
                unset($this->people[$index]);
                $this->people = array_values($this->people);

                /** @var Question $question Remove as pessoas das questões também */
                foreach ($this->questions as $iQ => $question) {
                    /** @var Person $person */
                    foreach ($question->persons as $iP => $personQuestion) {
                        if ($personQuestion->id == $person->id) {
                            unset($this->questions[$iQ]->persons[$iP]);
                            $this->questions = array_values($this->questions);
                            break;
                        }
                    }
                }
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

                /** @var Question $question Atualiza as pessoas das questões também */
                foreach ($this->questions as $iQ => $question) {
                    /** @var Person $personQuestion */
                    foreach ($question->persons as $iP => $personQuestion) {
                        if ($personQuestion->id == $newPerson->id) {
                            $this->questions[$iQ]->persons[$iP] = $newPerson;
                            break;
                        }
                    }
                }
                return;
            }
        }
    }

    public function getQuestions(): array
    {
        return $this->questions ?? [];
    }

    public function getLastQuestion(): ?Question
    {
        return $this->getLast($this->getQuestions());
    }

    public function getQuestion(string $id): ?Question
    {
        if (empty($this->questions)) {
            return null;
        }

        /** @var Question $question */
        foreach ($this->questions as $question) {
            if ($question->id == $id) {
                return $question;
            }
        }

        return null;
    }

    public function addQuestion(Question $question): void
    {
        if ($this->getQuestion($question->id)) {
            return;
        }

        $this->questions[] = $question;
    }

    public function removeQuestion(string $id)
    {
        if (empty($this->questions)) {
            return;
        }

        /** @var Question $question */
        foreach ($this->questions as $index => $question) {
            if ($question->id == $id) {
                unset($this->questions[$index]);
                $this->questions = array_values($this->people);
                return null;
            }
        }
    }

    public function updateQuestion(Question $newQuestion): void
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
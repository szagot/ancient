<?php

namespace Ancient\Service;

use Ancient\Config\Database;
use Ancient\Models\Person;
use Ancient\Models\PersonQuestion;
use Sz\Config\Uri;

class Control
{
    static public function run(Uri $uri)
    {
        // Teste
        $db = new Database();

//        $person = new Person('123', 'Abraão');
//        $person->addQuestion(new PersonQuestion('123', 'Ele fez alguma viagem longa?'));
//        $person->addQuestion(new PersonQuestion('124', 'Foi um patriarca?'));
//
//        $db->addPerson($person);
//        $db->persist();

        echo json_encode($db->getPerson('123')?->getQuestion('124') ?? []);
    }
}
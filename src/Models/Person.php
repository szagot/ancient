<?php

namespace Ancient\Models;

class Person
{
    public string $id;
    public string $name;

    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}